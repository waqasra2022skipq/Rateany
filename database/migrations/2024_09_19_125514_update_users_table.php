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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('reviews_count')->default(0);
            $table->unsignedInteger('1_star_count')->default(0);
            $table->unsignedInteger('2_star_count')->default(0);
            $table->unsignedInteger('3_star_count')->default(0);
            $table->unsignedInteger('4_star_count')->default(0);
            $table->unsignedInteger('5_star_count')->default(0);
            $table->float('average_rating', 3, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
