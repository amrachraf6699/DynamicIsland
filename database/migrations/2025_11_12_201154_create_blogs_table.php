<?php

use App\Models\BlogSection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->string('title');
            $table->string('slug')->unique();
            $table->string('cover')->nullable();
            $table->longText('content')->nullable();

            $table->text('excerpt')->nullable();

            $table->foreignIdFor(BlogSection::class)->nullable()->constrained('blog_sections')->onDelete('set null');

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
