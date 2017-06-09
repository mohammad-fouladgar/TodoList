@extends('layouts.app')

@section('content')

<tasks-viewer source="{{ route('tasks',['id'=>$todolist->id]) }}" title="{{ $todolist->title }} Tasks" />

@endsection


