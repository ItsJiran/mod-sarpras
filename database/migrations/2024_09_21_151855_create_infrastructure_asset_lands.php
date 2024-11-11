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
        Schema::create('infrastructure_asset_lands', function (Blueprint $table) {
            $table->id();
            $table->timestamp('receive_date')->nullable();
            $table->double('receive_price')->default(0);            
            $table->string('status')->default('tersedia');            

            $table->string('atas_nama')->default('-');
            $table->string('nop')->default('-');

            $table->integer('luas_bumi')->unsigned()->nullable()->default(0);
            $table->integer('luas_bangunan')->unsigned()->nullable()->default(0);

            $table->integer('njop_bumi')->unsigned()->nullable()->default(0);
            $table->integer('njop_bangunan')->unsigned()->nullable()->default(0);

            $table->string('alamat_wajib_pajak')->default('-');
            $table->string('alamat_objek_pajak')->default('-');

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
        Schema::dropIfExists('infrastructure_asset_lands');
    }
};
