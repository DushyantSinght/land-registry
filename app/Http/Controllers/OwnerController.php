<?php
// app/Http/Controllers/OwnerController.php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        $owners = Owner::search($request->search)
            ->when($request->type, fn ($q) => $q->where('owner_type', $request->type))
            ->latest()->paginate(15)->withQueryString();

        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:200',
            'owner_type'   => 'required|in:individual,company,government',
            'id_type'      => 'required|string|max:50',
            'id_number'    => 'required|string|max:50|unique:owners',
            'date_of_birth'=> 'nullable|date|before:today',
            'nationality'  => 'required|string|max:100',
            'phone'        => 'required|string|max:15',
            'email'        => 'nullable|email|max:150',
            'address'      => 'required|string',
            'city'         => 'required|string|max:100',
            'state'        => 'required|string|max:100',
            'pincode'      => 'required|string|max:10',
            'photo'        => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'id_document'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $validated['created_by'] = Auth::id();

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('owners/photos', 'public');
        }
        if ($request->hasFile('id_document')) {
            $validated['id_document'] = $request->file('id_document')->store('owners/documents', 'public');
        }

        $owner = Owner::create($validated);

        return redirect()->route('owners.show', $owner)
            ->with('success', "Owner {$owner->owner_number} created successfully.");
    }

    public function show(Owner $owner)
    {
        $owner->load(['properties', 'registrations.property', 'createdBy']);
        return view('owners.show', compact('owner'));
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $validated = $request->validate([
            'full_name'  => 'required|string|max:200',
            'phone'      => 'required|string|max:15',
            'email'      => 'nullable|email',
            'address'    => 'required|string',
            'city'       => 'required|string|max:100',
            'state'      => 'required|string|max:100',
            'pincode'    => 'required|string|max:10',
            'is_active'  => 'boolean',
        ]);

        $owner->update($validated);

        return redirect()->route('owners.show', $owner)->with('success', 'Owner updated.');
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();
        return redirect()->route('owners.index')->with('success', 'Owner record deleted.');
    }

    public function properties(Owner $owner)
    {
        $properties = $owner->properties()->paginate(10);
        return view('owners.properties', compact('owner', 'properties'));
    }
}
