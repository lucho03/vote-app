<?php

namespace App\Http\Controllers\SetSelection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Party;

class CandidateController extends Controller
{
    public function index() {
        $candidates = Candidate::with('party')->get();

        return view('admin.candidates.index', [
            'candidates' => $candidates
        ]);
    }

    public function create() {
        $parties = Party::all();

        return view('admin.candidates.create', compact('parties'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'reference_number' => 'required|integer|unique:candidates',
            'party_id' => 'required|exists:parties,id'
        ]);

        Candidate::create($data);

        return redirect()->route('admin.candidates.index')->with('success', 'Candidate created');
    }

    public function edit(Candidate $candidate) {
        $parties = Party::all();
        return view('admin.candidates.edit', compact('candidate', 'parties'));
    }

    public function update(Request $request, Candidate $candidate){
        $data = $request->validate([
            'name' => 'required|string',
            'reference_number' => 'required|integer|unique:candidates,reference_number,' . $candidate->id,
            'party_id' => 'required|exists:parties,id'
        ]);

        $candidate->update($data);

        return redirect()->route('admin.candidates.index')->with('success', 'Candidate updated');
    }

    public function destroy(Candidate $candidate) {
        $candidate->delete();

        return redirect()->route('admin.candidates.index')->with('success', 'Candidate deleted');
    }
}
