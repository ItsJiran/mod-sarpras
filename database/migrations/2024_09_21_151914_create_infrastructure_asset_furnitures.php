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
        Schema::create('infrastructure_asset_furnitures', function (Blueprint $table) {
            $table->id();
            $table->timestamp('receive_date')->nullable();
            $table->double('receive_price')->default(0);
            $table->string('last_location')->nullable();
            $table->string('status')->default('tersedia');                        
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
        Schema::dropIfExists('infrastructure_asset_furnitures');
    }
};
