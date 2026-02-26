<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'quantity',
        'available',
    ];

    /**
     * Get the borrowings for the book.
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }

    /**
     * Get only active (not returned) borrowings.
     */
    public function activeBorrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class)->whereNull('returned_at');
    }
}
