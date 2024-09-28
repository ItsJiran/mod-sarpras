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
        Schema::create('infrastructure_asset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('for_asset_id');

            // tipe pajak berkala |  
            $table->string('name')->default('Pajak');

            // descriptions
            $table->text('description')->nullable();

            // tipenya berakala / manual
            $table->string('type')->default('berkala')->index();

            // period day
            $table->integer('period_day')->default(0);
            $table->timestamp('duedate')->nullable();

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
        Schema::dropIfExists('infrastructure_asset_maintenances');
    }
};
