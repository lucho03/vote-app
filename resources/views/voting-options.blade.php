@extends('layouts.app')
@section('content')
    <div class="card">
        <form id="voteForm">
            <ul class="party-list">
                @foreach ($parties as $party)
                    <li class="party-item" data-party-id="{{ $party->id }}">

                        {{-- <input id="party-{{ $party->id }}" type="radio" name="party" value="{{ $party->id }}"> --}}

                        <label class="radio-wrapper">
                            <input id="party-{{ $party->id }}" type="radio" name="party" value="{{ $party->id }}">
                            <span class="custom-radio"></span>
                            <span class="radio-label"><strong>{{ $party->getDisplayName() }}</strong></span>
                        </label>
                        
                        <ul class="candidate-list">
                            @foreach ($party->candidates as $candidate)
                                <li class="candidate-item" data-candidate-id="{{ $candidate->id }}">
                                    
                                    {{-- <input id="candidate-{{ $candidate->id }}" type="radio" name="candidate" value="{{ $candidate->id }}"> --}}

                                    <label class="radio-wrapper">
                                        <input id="candidate-{{ $candidate->id }}" type="radio" name="candidate" value="{{ $candidate->id }}">
                                        <span class="custom-radio"></span>
                                        <span class="radio-label">{{ $candidate->name }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>

            <div class="person-credentials">
                <label class="person-label">
                    Voter ID:
                    <input id="voterId" class="person-input" placeholder="Id...">
                </label>

                <label class="person-label">
                    Voter Secret Key:
                    <input id="voterSecretKey" class="person-input" placeholder="Secret Key...">
                </label>
                
                <button id="sendEncryptedData" type="button" class="btn btn-primary">Submit Vote</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const partyItems = document.querySelectorAll(".party-item");

            console.log(partyItems);

            partyItems.forEach(party => {
                party.addEventListener("click", () => {

                    const candidatesItems = party.querySelectorAll(".candidate-item");
                    const currentlyOpen = party.classList.contains('open');

                    partyItems.forEach(i => i.classList.remove('open'));
                    

                    document.getElementById("party-" + party.dataset.partyId).checked = true;

                    candidatesItems.forEach(candidate => {
                        candidate.addEventListener("click", () => {
                            document.getElementById("candidate-" + candidate.dataset.candidateId).checked = true;
                        });
                    });

                    if (!currentlyOpen) {
                        party.classList.add('open');
                    }
                });
            });
        });
    </script>
@endsection

<div id="page-data" data-submit-endpoint="{{ route('vote.submit') }}" data-redirect-endpoint="{{ route('summary.index') }}" style="display: none"></div>
@push('scripts')
    @vite('resources/js/voting.js')
@endpush