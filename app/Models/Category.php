<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// This Laravel version configures mass-assignment with the #[Fillable] attribute
// (same style as the User model) instead of the older "protected $fillable" array.
// Only these three columns may be filled from a form; anything else is ignored.
#[Fillable(['name', 'type', 'user_id'])]
class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    /**
     * A category belongs to exactly one user (its owner).
     * This lets us write $category->user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A category has many transactions (the assignment's required relationship).
     * NOTE: the Transaction model is Amal's module. Referencing Transaction::class
     * here is safe even before that file exists, because ::class is resolved to a
     * plain string at compile time and is only loaded if you actually call
     * $category->transactions. Once Amal merges her model, this lights up for free.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}