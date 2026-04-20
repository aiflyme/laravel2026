@extends('layouts.app')

@section('title', 'Edit Note' )

@section('content')
    @include('notes/form',['note'=>$note])
@endsection
