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
        Schema::create('infrastructure_record_periodics', function (Blueprint $table) {
            $table->id();
            $table->timestamp('duedate');
            // period day
            $table->integer('period_number_day')->default(0);
            $table->integer('period_number_month')->default(0);
            $table->integer('period_number_year')->default(0);
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
        Schema::dropIfExists('infrastructure_record_periodics');
    }
};
