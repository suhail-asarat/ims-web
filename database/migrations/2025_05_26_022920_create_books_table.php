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
        Schema::create('books', function (Blueprint $table) {
            $table->increments('book_id')->unique();
            $table->timestamps();
            $table->string('book_name', 255);
            $table->string('book_author', 30)->nullable();
            $table->decimal('book_price', 8, 2);
            $table->string('book_genre', 30)->nullable();
            $table->string('book_cover_link', 1024);
            $table->integer('book_pages')->nullable();
            $table->string('book_isbn_10', 20)->nullable();
            $table->string('book_isbn_13', 20)->nullable();
            $table->date('book_publication_date')->nullable();
            $table->date('book_publisher')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
