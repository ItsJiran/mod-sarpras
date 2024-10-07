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
        Schema::create('infrastructure_tax_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_id');
            $table->foreignId('user_id');

            // properties
            $table->string('name')->default('Pembayaran Pajak');
            $table->text('description')->nullable();

            // tanggal pembayaran
            $table->timestamp('paydate')->nullable();
            $table->string('proof_img_path')->nullable();
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
        Schema::dropIfExists('infrastructure_tax_records');
    }
};
