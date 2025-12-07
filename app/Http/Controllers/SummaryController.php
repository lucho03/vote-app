<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
{
    public function index() {        
        return view('index', [
            'partyCounts' => $this->getData()
        ]);
    }
    
    public function data() {
        return response()->json( $this->getData() );
    }

    private function getData() {
        return Candidate::select('party_id', DB::raw('COUNT(votes.id) as votes'))
            ->leftJoin('votes', 'candidates.id', '=', 'votes.candidate_id')
            ->leftJoin('parties', 'candidates.party_id', '=', 'parties.id')
            ->groupBy('candidates.party_id')
            ->orderByDesc('votes')
            ->get()
            ->map(function($row) {
                return ['party' => $row->party->name ?? '—', 'votes' => (int) $row->votes];
            });
    }
}
