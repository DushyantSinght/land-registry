<?php
// app/Http/Controllers/TransferController.php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Property;
use App\Models\PropertyHistory;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function index(Request $request)
    {
        $transfers = Transfer::with(['property', 'fromOwner', 'toOwner'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()->paginate(15)->withQueryString();

        return view('transfers.index', compact('transfers'));
    }

    public function create()
    {
        $properties = Property::where('status', 'registered')->with('currentOwner')->get();
        $owners     = Owner::active()->orderBy('full_name')->get();
        return view('transfers.create', compact('properties', 'owners'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id'   => 'required|exists:properties,id',
            'from_owner_id' => 'required|exists:owners,id',
            'to_owner_id'   => 'required|exists:owners,id|different:from_owner_id',
            'transfer_date' => 'required|date',
            'transfer_value'=> 'required|numeric|min:0',
            'transfer_mode' => 'required|string|max:100',
            'reason'        => 'nullable|string',
            'transfer_deed' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status']     = 'pending';

        if ($request->hasFile('transfer_deed')) {
            $validated['transfer_deed'] = $request->file('transfer_deed')->store('transfers/documents', 'public');
        }

        $transfer = Transfer::create($validated);

        return redirect()->route('transfers.show', $transfer)
            ->with('success', "Transfer {$transfer->transfer_number} submitted for approval.");
    }

    public function show(Transfer $transfer)
    {
        $transfer->load(['property', 'fromOwner', 'toOwner', 'createdBy', 'approvedBy']);
        return view('transfers.show', compact('transfer'));
    }

    public function edit(Transfer $transfer)
    {
        abort_if($transfer->status !== 'pending', 403);
        $properties = Property::where('status', 'registered')->get();
        $owners     = Owner::active()->get();
        return view('transfers.edit', compact('transfer', 'properties', 'owners'));
    }

    public function update(Request $request, Transfer $transfer)
    {
        abort_if($transfer->status !== 'pending', 403);
        $validated = $request->validate([
            'transfer_date'  => 'required|date',
            'transfer_value' => 'required|numeric|min:0',
            'transfer_mode'  => 'required|string',
            'reason'         => 'nullable|string',
        ]);
        $transfer->update($validated);
        return redirect()->route('transfers.show', $transfer)->with('success', 'Transfer updated.');
    }

    public function destroy(Transfer $transfer)
    {
        abort_if($transfer->status === 'approved', 403);
        $transfer->delete();
        return redirect()->route('transfers.index')->with('success', 'Transfer deleted.');
    }

    public function approve(Transfer $transfer)
    {
        abort_if(!Auth::user()->isRegistrar(), 403);

        DB::transaction(function () use ($transfer) {
            $transfer->update([
                'status'      => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            $transfer->property->update(['current_owner_id' => $transfer->to_owner_id]);

            PropertyHistory::create([
                'property_id' => $transfer->property_id,
                'owner_id'    => $transfer->to_owner_id,
                'from_date'   => $transfer->transfer_date,
                'event_type'  => 'transfer',
                'notes'       => "Transferred from owner ID {$transfer->from_owner_id} via {$transfer->transfer_number}",
            ]);
        });

        return back()->with('success', "Transfer {$transfer->transfer_number} approved.");
    }

    public function reject(Request $request, Transfer $transfer)
    {
        abort_if(!Auth::user()->isRegistrar(), 403);
        $request->validate(['remarks' => 'required|string|max:500']);
        $transfer->update([
            'status'      => 'rejected',
            'remarks'     => $request->remarks,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        return back()->with('success', 'Transfer rejected.');
    }
}
