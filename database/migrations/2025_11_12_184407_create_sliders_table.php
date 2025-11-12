<?php

use App\Models\Service;
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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('content')->nullable();
            $table->string('button')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('img');
            $table->foreignIdFor(Service::class)->nullable()->constrained()->nullOnDelete();
            $table->enum('text_align_horizontal', ['left', 'center', 'right'])->default('center');
            $table->enum('text_align_vertical', ['top', 'middle', 'bottom'])->default('middle');
            $table->enum('button_align_horizontal', ['left', 'center', 'right'])->default('center');
            $table->enum('button_align_vertical', ['top', 'middle', 'bottom'])->default('middle');
            $table->string('text_color')->nullable();
            $table->string('button_color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
