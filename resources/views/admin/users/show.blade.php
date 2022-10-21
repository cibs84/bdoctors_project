@extends('layouts.dashboard')

@section('content')
    <h1>ciao sono la dashboard privata</h1>

    <div>Hello {{$user->name}}!</div>
    <div>your Address is {{$user->address}}!</div>
    <div>your email-address is {{$user->email}}!</div>
@endsection