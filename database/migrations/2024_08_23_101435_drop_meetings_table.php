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
        Schema::dropIfExists('meetings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->boolean('status_meeting')->default(false);
            $table->foreignId('investor_id')->constrained('investors')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('appointment_id')->constrained('appointments')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->date('meeting_date');
            $table->timestamps();
        });
    }
};
