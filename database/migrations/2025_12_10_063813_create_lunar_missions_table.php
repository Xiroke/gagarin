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
        Schema::create('lunar_missions', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->date('launch_date');
            $table->foreignIdFor(LaunchSite::class)->constrained()->cascadeOnDelete();

            $table->date('landing_date');
            $table->string('landing_name');
            $table->float('landing_latitude');
            $table->float('landing_longitude');

            $table->string('command_module');
            $table->string('lunar_module');
            $table->foreignIdFor(Crew::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lunar_missions');
    }
};
