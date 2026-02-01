@extends('admin.layout')

@section('title', 'Messages')

@section('content')
    @livewire('admin.messages.index', ['create' => request()->routeIs('admin.messages.create'), 'editId' => request()->route('id')])
@endsection
