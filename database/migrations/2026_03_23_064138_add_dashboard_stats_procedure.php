<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS GetDashboardStats;");
        DB::unprepared("
            CREATE PROCEDURE GetDashboardStats()
            BEGIN
                SELECT 
                    (SELECT COUNT(*) FROM users) as total_users,
                    (SELECT COUNT(*) FROM boekingen) as total_bookings,
                    (SELECT COUNT(*) FROM reizen) as total_trips,
                    (SELECT IFNULL(SUM(amount), 0) FROM facturen WHERE status = 'paid') as total_revenue;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS GetDashboardStats;");
    }
};
