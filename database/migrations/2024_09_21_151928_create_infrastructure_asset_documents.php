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
        Schema::create('infrastructure_asset_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('for_asset_id')->nullable();
            $table->string('status')->default('tersedia')->index();
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
        Schema::dropIfExists('infrastructure_asset_documents');
    }
};
