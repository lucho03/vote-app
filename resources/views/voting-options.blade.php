@extends('layouts.app')
@section('content')
    <div class="card">
        <form id="voteForm">
            <ul class="party-list">
                @foreach ($parties as $party)
                    <li class="party-item" data-party-id="{{ $party->id }}">
                        <label class="radio-wrapper">
                            <input id="party-{{ $party->id }}" type="radio" name="party" value="{{ $party->id }}">
                            <span class="custom-radio"></span>
                            <span class="radio-label"><strong>{{ $party->getDisplayName() }}</strong></span>
                        </label>
                        
                        <ul class="candidate-list">
                            @foreach ($party->candidates as $candidate)
                                <li class="candidate-item" data-candidate-id="{{ $candidate->id }}">
                                    <label class="radio-wrapper">
                                        <input id="candidate-{{ $candidate->id }}" class="candidate-radio" type="radio" name="candidate" value="{{ $candidate->id }}">
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
@endsection

<div id="page-data" data-submit-endpoint="{{ route('vote.submit') }}" data-redirect-endpoint="{{ route('summary.index') }}" style="display: none"></div>
@push('scripts')
    @vite('resources/js/voting.js')
@endpush