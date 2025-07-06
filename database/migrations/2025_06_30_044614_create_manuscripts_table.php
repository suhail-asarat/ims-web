<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('manuscripts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->string('title');
            $table->text('description');
            $table->string('genre');
            $table->integer('pages')->nullable();
            $table->string('language', 50)->default('English');
            $table->string('manuscript_file')->nullable(); // File path for uploaded manuscript
            $table->string('cover_image')->nullable(); // Optional cover design
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected', 'published'])->default('pending');
            $table->text('admin_notes')->nullable(); // Admin feedback/notes
            $table->decimal('suggested_price', 8, 2)->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable(); // Admin who reviewed
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->index(['author_id', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manuscripts');
    }
};
