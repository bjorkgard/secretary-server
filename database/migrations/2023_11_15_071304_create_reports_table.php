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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_group_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('identifier');
            $table->string('type');
            $table->string('name');
            $table->boolean('has_been_in_service')->default(false);
            $table->boolean('has_not_been_in_service')->default(false);
            $table->integer('studies')->nullable();
            $table->boolean('auxiliary')->default(false);
            $table->integer('hours')->nullable();
            $table->string('remarks')->nullable();
            $table->string('publisher_status');
            $table->string('publisher_name');
            $table->string('publisher_email')->nullable();
            $table->string('locale')->default('sv');
            $table->boolean('has_been_updated')->default(false);
            $table->boolean('send_email')->default(false);
            $table->string('email_status')->default('NONE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
