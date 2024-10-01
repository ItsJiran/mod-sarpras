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
        Schema::create('infrastructure_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->nullable();

            // name / descriptions
            $table->string('name')->default('Pajak');
            $table->text('description')->nullable();

            // status : pemindahan etc
            $table->string('status')->default('tersedia')->index();

            // driver license etc            
            $table->morphs('documentable');

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
        Schema::dropIfExists('infrastructure_documents');
    }
};
