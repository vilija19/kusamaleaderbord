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

<table class="table table-striped">
<thead>
<tr>
<th scope="col">Nomination<br>order</th>
<th scope="col">VALIDATOR NAME</th>
<th scope="col">SCORE</th>
<th scope="col">RANK</th>
<th scope="col">IS ACTIVE</th>
<th scope="col">IS VALID</th>
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
</tr>
@endforeach
</tbody>
</table>
@endsection