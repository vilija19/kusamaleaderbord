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
<h3>List of validators</h3> <h6> Last update (UTC): {{ $last_update }}</h6>
<style>
table, th, td {
  border: 1px solid black;
  padding: 5px;
}
</style>
<table class="unstyledTable">
<thead>
<tr>
<th>Nomination<br>order</th>
<th>VALIDATOR NAME</th>
<th>SCORE</th>
<th>RANK</th>
<th>IS ACTIVE</th>
<th>IS VALID</th>
</tr>
</thead>
<tbody>
@foreach ($candidates as $nomination_order => $candidate)
<tr>
<td>{{ $nomination_order }}</td>
<td><a href="/validator/{{ $candidate['id'] }}">{{ $candidate->name }}</a></td>
<td>{{ $candidate->score }}</td>
<td>{{ $candidate->rank }}</td>
<td>{{ $candidate->active }}</td>
<td>{{ $candidate->valid }}</td>
</tr>
@endforeach
</tbody>
</table>
@endsection