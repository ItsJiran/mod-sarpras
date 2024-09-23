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
        Schema::create('infrastructure_asset_document_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_document_id');
            $table->text('description');
            $table->enum('status', [
                'settled',
                'shift',
                'renewal',
                'borrowing',
                'mutasi',
            ])->default('settled');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infrastructure_asset_document_infos');
    }
};
