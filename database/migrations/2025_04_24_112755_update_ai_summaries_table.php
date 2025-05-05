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
        Schema::table('ai_summaries', function (Blueprint $table) {
            // Remove the morphs column "reviewable"
            $table->dropMorphs('reviewable');
            $table->dropColumn('prev_count');

            // Add the new columns for business
            $table->foreignId('business_id')->nullable()->constrained('businesses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_summaries', function (Blueprint $table) {
            // Add the morphs column "reviewable" back
            $table->morphs('reviewable');
            // Remove the new columns for business
            $table->dropForeign(['business_id']);
            $table->dropColumn('business_id');
        });
    }
};
