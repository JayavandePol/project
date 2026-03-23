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
        Schema::create('boekingen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('klant_id')->constrained('klanten')->onDelete('cascade');
            $table->foreignId('reis_id')->constrained('reizen')->onDelete('cascade');
            $table->foreignId('accommodatie_id')->constrained('accommodaties')->onDelete('cascade');
            $table->date('booking_date');
            $table->string('status')->default('pending'); // pending, confirmed, cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boekingen');
    }
};
