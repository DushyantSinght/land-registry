<?php
// app/Http/Controllers/RegistrationController.php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Property;
use App\Models\PropertyHistory;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['property', 'owner', 'createdBy'])
            ->search($request->search);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->type) {
            $query->where('registration_type', $request->type);
        }
        if ($request->date_from) {
            $query->whereDate('registration_date', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('registration_date', '<=', $request->date_to);
        }

        $registrations = $query->latest()->paginate(15)->withQueryString();
        $statuses  = ['pending', 'approved', 'rejected', 'cancelled'];
        $types     = ['first_registration', 'sale_deed', 'gift_deed', 'will_deed', 'partition_deed', 'lease_deed', 'mortgage_deed'];

        return view('registrations.index', compact('registrations', 'statuses', 'types'));
    }

    public function create()
    {
        $properties = Property::with('currentOwner')->orderBy('survey_number')->get();
        $owners     = Owner::active()->orderBy('full_name')->get();
        return view('registrations.create', compact('properties', 'owners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id'         => 'required|exists:properties,id',
            'owner_id'            => 'required|exists:owners,id',
            'registration_type'   => 'required|in:first_registration,sale_deed,gift_deed,will_deed,partition_deed,lease_deed,mortgage_deed',
            'registration_date'   => 'required|date',
            'execution_date'      => 'nullable|date',
            'sub_registrar_office'=> 'required|string|max:200',
            'document_number'     => 'nullable|string|max:100',
            'transaction_value'   => 'required|numeric|min:0',
            'stamp_duty'          => 'required|numeric|min:0',
            'registration_fee'    => 'required|numeric|min:0',
            'remarks'             => 'nullable|string',
            'witness1_name'       => 'nullable|string|max:100',
            'witness1_id'         => 'nullable|string|max:50',
            'witness2_name'       => 'nullable|string|max:100',
            'witness2_id'         => 'nullable|string|max:50',
            'deed_document'       => 'nullable|file|mimes:pdf|max:10240',
            'supporting_doc1'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'supporting_doc2'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status']     = 'pending';

        foreach (['deed_document', 'supporting_doc1', 'supporting_doc2'] as $file) {
            if ($request->hasFile($file)) {
                $validated[$file] = $request->file($file)->store('registrations/documents', 'public');
            }
        }

        $registration = Registration::create($validated);

        return redirect()->route('registrations.show', $registration)
            ->with('success', "Registration {$registration->registration_number} submitted successfully.");
    }

    public function show(Registration $registration)
    {
        $registration->load(['property.currentOwner', 'owner', 'createdBy', 'approvedBy']);
        return view('registrations.show', compact('registration'));
    }

    public function edit(Registration $registration)
    {
        abort_if($registration->status !== 'pending', 403, 'Only pending registrations can be edited.');
        $properties = Property::orderBy('survey_number')->get();
        $owners     = Owner::active()->orderBy('full_name')->get();
        return view('registrations.edit', compact('registration', 'properties', 'owners'));
    }

    public function update(Request $request, Registration $registration)
    {
        abort_if($registration->status !== 'pending', 403);

        $validated = $request->validate([
            'registration_type'    => 'required',
            'registration_date'    => 'required|date',
            'sub_registrar_office' => 'required|string',
            'transaction_value'    => 'required|numeric|min:0',
            'stamp_duty'           => 'required|numeric|min:0',
            'registration_fee'     => 'required|numeric|min:0',
        ]);

        $registration->update($validated);

        return redirect()->route('registrations.show', $registration)
            ->with('success', 'Registration updated.');
    }

    public function destroy(Registration $registration)
    {
        abort_if($registration->status === 'approved', 403, 'Approved registrations cannot be deleted.');
        $registration->delete();
        return redirect()->route('registrations.index')->with('success', 'Registration deleted.');
    }

    public function approve(Registration $registration)
    {
        abort_if(!Auth::user()->isRegistrar(), 403);
        abort_if($registration->status !== 'pending', 400, 'Only pending registrations can be approved.');

        DB::transaction(function () use ($registration) {
            $registration->update([
                'status'      => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            // Update property status and owner
            $registration->property->update([
                'status'           => 'registered',
                'current_owner_id' => $registration->owner_id,
            ]);

            // Record history
            PropertyHistory::create([
                'property_id' => $registration->property_id,
                'owner_id'    => $registration->owner_id,
                'from_date'   => $registration->registration_date,
                'event_type'  => 'registration',
                'notes'       => "Registered via {$registration->registration_number}",
            ]);
        });

        return back()->with('success', "Registration {$registration->registration_number} approved.");
    }

    public function reject(Request $request, Registration $registration)
    {
        abort_if(!Auth::user()->isRegistrar(), 403);
        $request->validate(['rejection_reason' => 'required|string|max:500']);

        $registration->update([
            'status'           => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_by'      => Auth::id(),
            'approved_at'      => now(),
        ]);

        return back()->with('success', 'Registration rejected.');
    }

    public function receipt(Registration $registration)
    {
        $registration->load(['property', 'owner', 'approvedBy']);
        $pdf = Pdf::loadView('registrations.receipt-pdf', compact('registration'))
            ->setPaper('A4', 'portrait');
        return $pdf->download("receipt-{$registration->registration_number}.pdf");
    }
}
