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
        Schema::create('service_groups', function (Blueprint $table) {
            $table->id();
            $table->string('identifier');
            $table->string('service_group_identifier');
            $table->string('name');
            $table->string('responsible_email')->nullable();
            $table->string('assistant_email')->nullable();
            $table->string('locale')->default('sv');
            $table->string('email_status')->default('NONE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_groups');
    }
};
