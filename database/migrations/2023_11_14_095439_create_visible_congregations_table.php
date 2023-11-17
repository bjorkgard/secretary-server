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
        Schema::create('congregations', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('congregation');
            $table->string('congregation_number')->unique();
            $table->string('contact_firstname');
            $table->string('contact_lastname');
            $table->string('contact_email');
            $table->boolean('send_service_group_reports')->default(false);
            $table->boolean('send_publisher_reports')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('congregations');
    }
};
