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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->string('title')->nullable();
            $table->string('cover')->nullable();
            $table->longText('content')->nullable();
            $table->string('demo')->nullable();
            $table->string('live_preview')->nullable();
            $table->string('client')->nullable();
            $table->string('location')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
