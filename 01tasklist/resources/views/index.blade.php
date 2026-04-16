@extends('layouts.app')

@section('title','The list of tasks')

@section('content')
    <div class="mb-4">
        <a class="link" href="{{ route('tasks.create') }}">Add task</a>
    </div>

    {{--@if (count(tasks))--}}
    @forelse ($tasks as $task)

        <div>
           {{$task->id}}: <a @class(['line-through'=> $task->completed]) href="{{ route('tasks.show', ['task'=> $task->id]) }}">{{$task->title}}</a>
        </div>
    @empty
        <div>There are no tasks!</div>
    @endforelse

    @if($tasks->count())
        <nav class="mt-4">
            {{ $tasks->links() }}
        </nav>
    @endif
@endsection
