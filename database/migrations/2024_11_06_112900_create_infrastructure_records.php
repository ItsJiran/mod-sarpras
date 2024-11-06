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
        Schema::create('infrastructure_records', function (Blueprint $table) {
            $table->id();

            // properties
            $table->string('name')->default('Record');
            $table->text('description')->nullable();
            $table->string('type')->nullable();
            
            // morphs eaither assets or maintenance
            $table->morphs('recordable');
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
        Schema::dropIfExists('infrastructure_records');
    }
};
