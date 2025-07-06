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
        Schema::table('orders', function (Blueprint $table) {
            $table->text('admin_notes')->nullable()->after('store_amount');
            $table->unsignedBigInteger('confirmed_by')->nullable()->after('admin_notes');
            $table->timestamp('confirmed_at')->nullable()->after('confirmed_by');

            $table->foreign('confirmed_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['confirmed_by']);
            $table->dropColumn(['admin_notes', 'confirmed_by', 'confirmed_at']);
        });
    }
};
