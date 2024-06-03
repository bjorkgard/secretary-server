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
        Schema::create('mail_responses', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('publisher_email');
            $table->string('description')->nullable()->default(null);
            $table->string('event');
            $table->json('data');
            $table->boolean('fix')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_responses');
    }
};
