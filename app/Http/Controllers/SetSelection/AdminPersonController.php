<?php

namespace App\Http\Controllers\SetSelection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Person;

use Illuminate\Support\Facades\Validator;

class AdminPersonController extends Controller
{
    public function index() {
        $people = Person::all();

        return view('admin.people.index', [
            'people' => $people
        ]);
    }

    public function create() {
        return view('admin.people.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'personal_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        Person::create([
            'personal_id' => hash('sha512', $data['personal_id']),
            'name'        => $data['name'],
            'address'     => $data['address'],
            'unique_secret_key' => substr(bin2hex(random_bytes(3)), 0, 6),
        ]);

        return redirect()->route('admin.people.index')->with('success', 'Record created successfully.');
    }

    public function destroy(Person $person) {
        $person->delete();

        return redirect()->route('admin.people.index')->with('success', 'Person deleted');
    }
}
