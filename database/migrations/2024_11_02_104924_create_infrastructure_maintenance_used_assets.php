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
        Schema::create('infrastructure_maintenance_used_assets', function (Blueprint $table) {
            $table->id();
            // for relation use
            $table->foreignId('tax_used_id');
            $table->foreignId('unit_id');
            $table->foreignId('asset_id');
            // timestamps
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
        Schema::dropIfExists('infrastructure_maintenance_used_assets');
    }
};
