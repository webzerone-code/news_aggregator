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
        Schema::table('raw_data_models', function (Blueprint $table) {
            $table->string('md5_title')->nullable()->index()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raw_data_models', function (Blueprint $table) {
            $table->dropColumn('md5_title');
        });
    }
};
