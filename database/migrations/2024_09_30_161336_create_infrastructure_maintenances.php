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

            // tipe pajak berkala |  
            $table->string('name')->default('Perawatan');

            // descriptions
            $table->text('description')->nullable();

            // tipenya berkala / manual
            $table->string('type')->default('berkala')->index();

            // period day
            $table->integer('period_day')->default(0);
            $table->timestamp('duedate')->nullable();

            // morph
            $table->morphs('maintananceable');

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
