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
        Schema::create('infrastructure_asset_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('asset_book_reservation_id');
            $table->foreignId('asset_book_info_id')->nullable();
            $table->timestamp('start_timestamp');
            $table->timestamp('expired_timestamp');
            $table->timestamp('returned_timestamp');
            $table->string('returned_proof_image_path');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_asset_books');
    }
};
