@extends('layouts.app')

@section('title',$note->title)

@section('content')
    <div class="mb-4">
        <a class="link" href="{{ route('notes.index') }}"><- Go back to the note list</a>
    </div>
    <p class="mb-4 text-slate-700">{{ $note->content}}</p>


    <p class="mb-4 text-slate-500">Created: {{ $note->created_at->diffForHumans()}}</p>
    <p class="mb-4 text-slate-500">Updated: {{ $note->updated_at->diffForHumans()}}</p>
    <p class="mb-4">
        @if($note->is_pinned)
            <span class="font-medium text-green-500">Pinned</span>

        @else
            <span class="font-medium text-red-500">not Pinned</span>
        @endif
    </p>

    <div class="flex gap-2">
        <a class="btn" href="{{ route('notes.edit', ['note'=>$note->id]) }}">Edit</a>


        <form action="{{ route('notes.toggle-pinned',['note'=>$note->id]) }}" method="post">
            @csrf
            @method('PUT')
            <button type="submit" class="btn">
                Mark as {{ $note->is_pinned ? 'Not pinned' : 'pinned' }}
            </button>
        </form>

        <form action="{{ route('notes.destroy',['note'=>$note->id]) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">delete </button>
        </form>
    </div>
@endsection
