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
            $table->foreignId('tax_record_id')->index();
            $table->morphs('record_useable');
            $table->boolean('freeze_target')->default(false);
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