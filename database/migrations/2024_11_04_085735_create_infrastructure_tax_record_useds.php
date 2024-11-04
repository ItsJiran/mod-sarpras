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
        Schema::create('infrastructure_tax_record_useds', function (Blueprint $table) {
            $table->id();
            // for relation use
            $table->foreignId('tax_record_id');            
            $table->foreignId('unit_id');
            $table->foreignId('target_id');
            $table->text('type');
            $table->boolean('is_freeze')->default(false);
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
        Schema::dropIfExists('infrastructure_tax_record_useds');
    }
};
