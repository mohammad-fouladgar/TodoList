@extends('layouts.app')

@section('content')

<todolist-viewer source="{{ route('user.todolists') }}" title="{{ auth()->user()->name }} Todolist" />

@endsection


