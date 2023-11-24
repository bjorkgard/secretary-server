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
        Schema::table('service_groups', function (Blueprint $table) {
            $table->text('month')
                ->after('locale')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.php
     */
    public function down(): void
    {
        Schema::table('service_groups', function (Blueprint $table) {
            $table->dropColumn('month');
        });
    }
};
