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
        Schema::create('infrastructure_record_notes', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('record_id');
            $table->foreignId('user_id');

            // properties
            $table->string('name')->default('Pembayaran Record');
            $table->text('description')->nullable();

            // tanggal pembayaran
            $table->double('payprice')->default(0);
            $table->timestamp('paydate')->nullable();
            $table->string('proof_img_path')->nullable();

            // pending -> approve | cancelled | unapprove |  draft
            $table->string('status')->default('pending');

            $table->jsonb('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_record_notes');
    }
};
