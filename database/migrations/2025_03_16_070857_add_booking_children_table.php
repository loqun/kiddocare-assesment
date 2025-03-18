<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('booking_child')) {
            Schema::create('booking_child', function (Blueprint $table) {
                $table->id();
                $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
                $table->foreignId('child_id')->constrained('children')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_child');
    }
};
