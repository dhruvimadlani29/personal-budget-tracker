<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the categories table.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Owner of the category. constrained() adds a foreign key to users.id.
            // cascadeOnDelete() means: if a user is deleted, delete their categories too.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('name');

            // 'income' or 'expense'. Kept as a plain string (DB-agnostic); the
            // allowed values are enforced in validation on the form.
            $table->string('type');

            $table->timestamps();
        });
    }

    /**
     * Drop the categories table (used when rolling back).
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};