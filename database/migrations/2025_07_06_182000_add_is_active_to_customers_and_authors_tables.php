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
        // Add is_active column to customers table
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('address');
        });

        // Add is_active column to authors table
        Schema::table('authors', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove is_active column from customers table
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        // Remove is_active column from authors table
        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};
