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
        // Update customers table phone field
        Schema::table('customers', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->change();
        });

        // Update authors table phone field
        Schema::table('authors', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert customers table phone field
        Schema::table('customers', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
        });

        // Revert authors table phone field
        Schema::table('authors', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
        });
    }
};
