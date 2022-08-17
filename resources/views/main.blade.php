@extends('layouts.main')
@section('content')
@if (session('message'))
<div style="color:green;">
    {!! session('message') !!}
</div>
@endif
@if (session('error'))
<div style="color:red;">
    {!! session('error') !!}
</div>
@endif
<div class="row mb-3 text-left">
    <div class="col-md-3 themed-grid-col">
        <h3>List of validators</h3>
    </div>
</div> 
<div class="row mb-3 text-left">
    <div class="col-md-6 themed-grid-col">
        <h6> Last update (UTC): {{ $last_update }}</h6> 
    </div>
    <div class="col-md-3 themed-grid-col">
        <div class="form-check form-switch">
            <input name="wish_only" class="form-check-input leaderboard-switch"
             type="checkbox" role="switch" id="wish_only" {{ $wish_only ? 'checked' : '' }}>
            <label class="form-check-label" for="flexSwitchCheckChecked">Show wish only</label>
        </div>         
    </div> 
    <div class="col-md-3 themed-grid-col">
        <div class="form-check form-switch">
            <input name="valid_only" class="form-check-input leaderboard-switch" 
            type="checkbox" role="switch" id="valid_only" {{ $valid_only ? 'checked' : '' }}>
            <label class="form-check-label" for="flexSwitchCheckChecked">Show valid only</label>
        </div>         
    </div>        
</div> 


<table class="table table-striped">
<thead>
<tr>
<th scope="col">Nomination<br>order</th>
<th scope="col">VALIDATOR NAME</th>
<th scope="col">SCORE</th>
<th scope="col">RANK</th>
<th scope="col">IS ACTIVE</th>
<th scope="col">IS VALID</th>
<th scope="col">WATCH</th>
</tr>
</thead>
<tbody>
@foreach ($candidates as $nomination_order => $candidate)
<tr @if (!$candidate->valid) class="table-danger" @endif>
<th scope="row">{{ $nomination_order }}</th>
<td><a href="/validator/{{ $candidate['id'] }}">{{ $candidate->name }}</a></td>
<td>{{ $candidate->score }}</td>
<td>{{ $candidate->rank }}</td>
<td @if ($candidate->active) class="table-success" @endif>{{ $candidate->active }}</td>
<td>{{ $candidate->valid }}</td>
<td>
    <div class="form-check">
        <input class="form-check-input item-wish" type="checkbox"
         value="" data-for="{{ $candidate['id'] }}" {{ isset($wish_list[$candidate->id]) ? 'checked' : '' }}>
    </div>
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection