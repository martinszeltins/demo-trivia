<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    /**
     * Mark question as asked
     */
    public function markAsked()
    {
        $this->update(['has_been_asked' => true]);
    }

    /**
     * One random unasked question
     */
    public function scopeRandomUnasked()
    {
        return $this->whereHasBeenAsked(0)->inRandomOrder();
    }
}
