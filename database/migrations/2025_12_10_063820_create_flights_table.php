<?php

use App\Models\Crew;
use App\Models\LaunchSite;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->foreignIdFor(Crew::class)->constrained()->cascadeOnDelete();

            $table->date('launch_date');
            $table->foreignIdFor(LaunchSite::class)->constrained()->cascadeOnDelete();

            $table->date('landing_date');
            $table->string("landing_name");
            $table->float("landing_latitude");
            $table->float("landing_longitude");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
