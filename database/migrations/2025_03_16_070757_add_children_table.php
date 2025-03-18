<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('children')) {
            Schema::create('children', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('age'); // Age in years
                $table->integer('month'); // Age in months
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
