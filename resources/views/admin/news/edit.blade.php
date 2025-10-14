@extends('admin.layout')

@section('title', 'Edit News Article')

@section('content')
    @livewire('admin.news.edit', ['newsId' => $news->id])
@endsection

