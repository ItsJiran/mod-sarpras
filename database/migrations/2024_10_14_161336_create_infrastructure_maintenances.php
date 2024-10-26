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

            // tipe perawatan berkala
            $table->string('name')->default('Perawatan');
            $table->text('description')->nullable();
            
            // morph
            $table->morphs('maintenanceable');
            $table->morphs('targetable');

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
