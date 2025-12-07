<?php

namespace App\Http\Controllers\SetSelection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Party;

class PartiesConroller extends Controller
{
    public function index() {
        return view('admin.parties.index', [
            'parties' => Party::all()
        ]);
    }

    public function create() {
        return view('admin.parties.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string',
            'reference_number' => 'required|integer|unique:parties'
        ]);

        Party::create($data);

        return redirect()->route('admin.parties.index')->with('success', 'Party created');
    }

    public function edit(Party $party) {
        return view('admin.parties.edit', compact('party'));
    }

    public function update(Request $request, Party $party){
        $data = $request->validate([
            'name' => 'required|string',
            'reference_number' => 'required|integer|unique:parties,reference_number,' . $party->id
        ]);

        $party->update($data);

        return redirect()->route('admin.parties.index')->with('success', 'Party updated');
    }

    public function destroy(Party $party) {
        $party->delete();

        return redirect()->route('admin.parties.index')->with('success', 'Party deleted');
    }
}
