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
        Schema::create('infrastructure_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id');
            $table->foreignId('asset_id');
            $table->foreignId('document_id')->nullable();

            // tipe pajak berkala |  
            $table->string('name')->default('Perawatan');

            // descriptions
            $table->text('description')->nullable();

            // tipenya berkala / manual
            $table->string('type')->default('berkala')->index();

            // tanggal pembayaran
            $table->timestamp('duedate')->nullable();

            // period day
            $table->integer('period_number_day')->default(0);
            $table->integer('period_number_month')->default(0);
            $table->integer('period_number_year')->default(0);
            
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
        Schema::dropIfExists('infrastructure_maintenances');
    }
};
