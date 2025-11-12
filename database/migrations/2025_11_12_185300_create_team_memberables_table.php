<?php

use App\Models\TeamMember;
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
        Schema::create('team_memberables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TeamMember::class)->constrained()->cascadeOnDelete();
            $table->morphs('memberable');
            $table->string('role')->nullable();
            $table->timestamps();

            $table->unique(
                ['team_member_id', 'memberable_type', 'memberable_id'],
                'team_memberables_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_memberables');
    }
};
