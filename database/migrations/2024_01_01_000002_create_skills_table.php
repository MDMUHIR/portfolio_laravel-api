<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['frontend', 'backend', 'tools', 'database', 'devops'])->default('frontend');
            $table->integer('proficiency_level')->default(50);
            $table->string('icon')->nullable();
            $table->timestamps();
            
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
    }
};
