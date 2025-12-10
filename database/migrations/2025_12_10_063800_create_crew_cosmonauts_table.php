<?php

use App\Models\Cosmonaut;
use App\Models\Crew;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cosmonaut_crew', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cosmonaut::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Crew::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crew_cosmonauts');
    }
};
