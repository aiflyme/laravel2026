@extends('layouts.app')

@section('title', 'Edit Task' )

@section('content')
    @include('form',['task'=>$task])
@endsection
<!--
{{ $errors }}
    <form method="POST" action="{{ route('tasks.update' , ['task' => $task->id]) }}">
        @csrf
        @method('PUT')
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ $task->title }}">
            @error('title')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" row="5" >{{ $task->description }}</textarea>
            @error('description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="long_description">Long Description</label>
            <textarea  id="long_description" name="long_description" row="10">{{ $task->long_description }}</textarea>
             @error('long_description')
                <p class="error-message">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <button type="submit">Edit Task</button>
            <button type="reset">Reset</button>
        </div>

    </form> -->
