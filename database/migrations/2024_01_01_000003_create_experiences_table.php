<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('organization');
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('type', ['job', 'education'])->default('job');
            $table->timestamps();
            
            $table->index('type');
            $table->index(['type', 'start_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
