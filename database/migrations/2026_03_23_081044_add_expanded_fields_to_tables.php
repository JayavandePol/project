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
        Schema::table('klanten', function (Blueprint $table) {
            $table->string('city')->nullable()->after('address');
            $table->string('postal_code')->nullable()->after('address');
        });

        Schema::table('reizen', function (Blueprint $table) {
            $table->string('destination')->nullable()->after('title');
            $table->integer('max_participants')->default(20)->after('price');
        });

        Schema::table('accommodaties', function (Blueprint $table) {
            $table->integer('rating')->default(3)->after('type'); // 1-5 stars
            $table->text('amenities')->nullable()->after('type'); // WiFi, Pool, etc.
        });

        Schema::table('boekingen', function (Blueprint $table) {
            $table->integer('num_people')->default(1)->after('accommodatie_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klanten', function (Blueprint $table) {
            $table->dropColumn(['city', 'postal_code']);
        });

        Schema::table('reizen', function (Blueprint $table) {
            $table->dropColumn(['destination', 'max_participants']);
        });

        Schema::table('accommodaties', function (Blueprint $table) {
            $table->dropColumn(['rating', 'amenities']);
        });

        Schema::table('boekingen', function (Blueprint $table) {
            $table->dropColumn(['num_people']);
        });
    }
};
