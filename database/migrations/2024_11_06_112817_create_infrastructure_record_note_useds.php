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
        Schema::create('infrastructure_record_note_useds', function (Blueprint $table) {
            $table->id();
            // for relation use
            $table->foreignId('record_id');
            $table->boolean('dibekukan')->default(false);
            // target morph
            $table->morph('targetable');
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
        Schema::dropIfExists('infrastructure_record_note_useds');
    }
};
