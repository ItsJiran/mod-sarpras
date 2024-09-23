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
        Schema::create('infrastructure_asset_book_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_book_id');
            $table->text('description');
            $table->enum('status', [
                'pending',
                'onbook',
                'queue',
                'finished',
                'unapprove',
                'booked',
                'cancelled',
            ])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_asset_book_infos');
    }
};
