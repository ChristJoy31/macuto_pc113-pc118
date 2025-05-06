<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Resident;

class CertificateController extends Controller
{

    public function index()
{
    $user = auth()->user();
    if ($user->role === 'resident') {
        return Certificate::where('resident_id', $user->id)->get();
    }

    // For secretary/admin, return all
    return Certificate::with('resident')->get();
}

    public function store(Request $request)
{
    
    $request->validate([
        'document_type' => 'required|string',
        'purpose' => 'required|string',
    ]);

    try {
        Certificate::create([
            'resident_id' => auth()->id(),
            'document_type' => $request->document_type,
            'purpose' => $request->purpose,
            'status' => 'Pending',
        ]);
        return response()->json(['success' => 200]);
    } catch (\Exception $e) {
        \Log::error('Certificate create error: ' . $e->getMessage());
        return response()->json(['error' => 'Something went wrong'], 500);
    }
}

public function myRequests(Request $request)
{
    $user = $request->user();

    return Certificate::where('resident_id', $user->id)
    ->orderBy('created_at', 'desc')
    ->select('id', 'document_type', 'purpose', 'status', 'reason', 'created_at', 'claimed_at')
    ->get();
}


public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Approved,Rejected',
        'reason' => 'nullable|string',
    ]);

    $certificate = Certificate::findOrFail($id);
    $certificate->status = $request->status;

    // Save reason only if status is Rejected
    if ($request->status === 'Rejected') {
        $certificate->reason = $request->reason;
    } else {
        $certificate->reason = null; // clear previous reason if re-approved
    }

    $certificate->save();

    return response()->json(['success' => true]);
}

public function markAsClaimed($id)
{
    $certificate = Certificate::findOrFail($id);

    if ($certificate->status !== 'Approved') {
        return response()->json(['error' => 'Only approved documents can be marked as claimed'], 400);
    }

    $certificate->is_claimed = true;
    $certificate->claimed_at = now();
    $certificate->save();

    return response()->json(['success' => true]);
}



}
