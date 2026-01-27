<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CipherHelper;
use App\Models\Candidate;
use App\Models\Party;
use App\Models\Person;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Helpers\RSAHelper;

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

    public function authenticate(Request $request) {
        try {
            $validated = $request->validate([
                'person_id' => 'required|string|size:10',
                'pin' => 'required|string|min:4'
            ]);

            $voter = Person::where('person_id', $validated['person_id'])->first();

            if (!$voter || !Hash::check($validated['pin'], $voter->pin_hash)) {
                return response()->json([
                    'error' => 'Invalid credentials'
                ]);
            }

            $token = Str::random(64);

            Cache::put("vote_token:$token", $voter->person_id, now()->addMinutes(5));

            return response()->json([
                'token' => $token
            ]);
        }
        catch (ValidationException $e) {
            return response()->json([
                'error' => 'Invalid input'
            ]);
        }
    }

    public function getPublicKey(Request $request) {
        $token = $request->bearerToken();

        if( !$token ) {
            return response()->json([
                'error' => 'Token not provided!'
            ]);
        }

        $personId = Cache::get("vote_token:$token");

        if( !$personId ) {
            return response()->json([
                'error' => 'Invalid or expired token!'
            ]);
        }

        $publicKey = Person::where('person_id', $personId)->value('public_key');

        return response()->json([
            'public_key' => $publicKey
        ]);
    }

    public function submit(Request $request) {
        $token = $request->bearerToken();

        if( !$token ) {
            return response()->json([
                'error' => 'Token not provided!'
            ]);
        }

        $personId = Cache::get("vote_token:$token");

        if( !$personId ) {
            return response()->json([
                'error' => 'Invalid or expired token!'
            ]);
        }

        $encryptedVote = $request->encrypted_vote;
        $privateKey = Person::where('person_id', $personId)->value('private_key'); 
        $privateKeyPem = decrypt($privateKey);
        
        $voteJson = RSAHelper::decryptRSA($encryptedVote, $privateKeyPem);
        $voteData = json_decode($voteJson, true);
        $voter = Person::where('person_id', $personId)->first();

        Cache::forget("vote_token:$token");

        try {
            $vote = Vote::where('person_id', $voter->getPrimaryKey())->first();

            if( !$vote ) {
                Vote::create([
                    'candidate_id' => $voteData['candidate'],
                    'person_id' => $voter->getPrimaryKey(),
                ]);
            }
            else {
                $vote->update([
                    'candidate_id' => $voteData['candidate'],
                ]);
            }
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
