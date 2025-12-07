<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CipherHelper;
use App\Models\Candidate;
use App\Models\Party;
use App\Models\Person;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    public function main() {
        return view('main');
    }

    public function index() {
        $parties = Party::all();
        $candidates = Candidate::all();

        $parties = Party::with('candidates')->get();

        return view('voting-options', [
            'candidates' => Candidate::all(),
            'parties' => Party::all(),
        ]);
    }

    public function submit(Request $request) {
        $validated = $request->validate([
            'cipher' => 'required|string|max:255',
            'iv' => 'required|string|max:255',
            'salt' => 'required|string|max:255',
            'voterID' => 'required|string'
        ]);
        
        $voter = Person::where('personal_id', $validated['voterID'])->first();

        $data = (new CipherHelper())->decrypt(
            [
            'cipher' => $validated['cipher'],
            'iv' => $validated['iv'],
            'salt' => $validated['salt'],
            ],
            $voter->getSecretKey()
        );

        if( $data === false ) {
            return response()->json([
                'message' => 'Decryption failed.',
            ], 400);
        }

        $data = json_decode($data, true);

        try {
            Vote::create([
                'candidate_id' => $data['candidate'],
                'person_id' => $voter->getPrimaryKey(),
            ]);

            $voter->update([
                'number_votes' => $voter->getNumberVotes() + 1
            ]);
        }
        catch( Exception $e ) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 401);
        }

        return response()->json([
            'message' => 'Vote submitted successfully!',
        ], 200);
    }
}
