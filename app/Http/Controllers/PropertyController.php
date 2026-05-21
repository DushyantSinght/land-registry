<?php
// app/Http/Controllers/PropertyController.php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::with('currentOwner')
            ->search($request->search)
            ->byDistrict($request->district)
            ->byLandType($request->land_type)
            ->byStatus($request->status);

        $properties = $query->latest()->paginate(15)->withQueryString();

        $districts = Property::distinct()->orderBy('district')->pluck('district');
        $landTypes = ['agricultural', 'residential', 'commercial', 'industrial', 'forest', 'government', 'other'];
        $statuses  = ['available', 'registered', 'disputed', 'mortgaged', 'government_acquired'];

        return view('properties.index', compact('properties', 'districts', 'landTypes', 'statuses'));
    }

    public function create()
    {
        $owners = Owner::active()->orderBy('full_name')->get();
        return view('properties.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'land_type'           => 'required|in:agricultural,residential,commercial,industrial,forest,government,other',
            'land_use'            => 'required|in:vacant,built_up,semi_built',
            'village'             => 'nullable|string|max:100',
            'taluka'              => 'required|string|max:100',
            'district'            => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'pincode'             => 'required|string|max:10',
            'address_description' => 'nullable|string',
            'area_sqft'           => 'required|numeric|min:1',
            'area_acres'          => 'nullable|numeric',
            'market_value'        => 'required|numeric|min:0',
            'government_value'    => 'required|numeric|min:0',
            'valuation_year'      => 'nullable|integer|min:2000|max:' . date('Y'),
            'current_owner_id'    => 'nullable|exists:owners,id',
            'status'              => 'required|in:available,registered,disputed,mortgaged,government_acquired',
            'has_disputes'        => 'boolean',
            'dispute_notes'       => 'nullable|string',
            'site_plan'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'survey_document'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $validated['created_by'] = Auth::id();

        foreach (['site_plan', 'survey_document'] as $file) {
            if ($request->hasFile($file)) {
                $validated[$file] = $request->file($file)->store('properties/documents', 'public');
            }
        }

        $property = Property::create($validated);

        return redirect()->route('properties.show', $property)
            ->with('success', "Property {$property->survey_number} created successfully.");
    }

    public function show(Property $property)
    {
        $property->load(['currentOwner', 'registrations.owner', 'transfers.fromOwner', 'transfers.toOwner', 'history.owner']);
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $owners = Owner::active()->orderBy('full_name')->get();
        return view('properties.edit', compact('property', 'owners'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'land_type'           => 'required',
            'land_use'            => 'required',
            'taluka'              => 'required|string|max:100',
            'district'            => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'pincode'             => 'required|string|max:10',
            'area_sqft'           => 'required|numeric|min:1',
            'market_value'        => 'required|numeric|min:0',
            'government_value'    => 'required|numeric|min:0',
            'status'              => 'required',
        ]);

        foreach (['site_plan', 'survey_document'] as $file) {
            if ($request->hasFile($file)) {
                Storage::disk('public')->delete($property->$file);
                $validated[$file] = $request->file($file)->store('properties/documents', 'public');
            }
        }

        $property->update($validated);

        return redirect()->route('properties.show', $property)
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('properties.index')->with('success', 'Property deleted.');
    }

    public function history(Property $property)
    {
        $history = $property->history()->with('owner')->paginate(20);
        return view('properties.history', compact('property', 'history'));
    }

    public function certificate(Property $property)
    {
        $property->load('currentOwner');
        $pdf = Pdf::loadView('properties.certificate-pdf', compact('property'))
            ->setPaper('A4', 'portrait');
        return $pdf->download("property-certificate-{$property->survey_number}.pdf");
    }
}
