<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /** @use HasFactory<\Database\Factories\NoteFactory> */
    use HasFactory;

    protected $fillable = ['title', 'content', 'is_pinned'];

    public function togglePinned(){
        $this->is_pinned = !$this->is_pinned;
        $this->save();
    }

}
