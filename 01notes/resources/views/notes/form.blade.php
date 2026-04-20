
<pre class="error">{{ implode(' ', $errors->all()) }}</pre>
<form method="POST" action="{{ isset($note) ? route('notes.update' , ['note' => $note->id]) : route('notes.store') }}">
    @csrf
    @isset($note)
        @method('PUT')
    @endisset
    <div class="mb-4">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $note->title ?? '') }}" @class(['border-red-500'=>$errors->has('title')])>
        @error('title')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-4">
        <label for="content">Content</label>
        <textarea id="content" name="content" rows="4" @class(['border-red-500'=>$errors->has('content')])>{{ old('content', $note->content ?? '') }}</textarea>
        @error('content')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex items-center gap-2">
        <button type="submit" class='btn'>
            @isset($note)
                Update note
            @else
                Add note
            @endisset
        </button>
        <button type="reset" class='btn'>Reset</button>
        <a href="{{ route('notes.index') }}"  class='link'>Back</a>
    </div>

</form>
