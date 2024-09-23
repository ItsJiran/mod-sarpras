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
        Schema::create('infrastructure_asset_lands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id');
            $table->timestamp('receive_date')->nullable();
            $table->double('receive_price')->default(0);            
            $table->enum('status', [
                'selled',
                'exist',
            ])->default('exist');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_asset_lands');
    }
};
