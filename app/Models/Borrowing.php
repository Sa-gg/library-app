<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrowing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'book_id',
        'borrower_name',
        'borrower_email',
        'borrowed_at',
        'due_date',
        'returned_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'borrowed_at' => 'date',
            'due_date' => 'date',
            'returned_at' => 'date',
        ];
    }

    /**
     * Get the book that this borrowing belongs to.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
