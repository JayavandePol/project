<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_user_role;');
        DB::unprepared('
            CREATE PROCEDURE update_user_role(IN p_user_id BIGINT UNSIGNED, IN p_role VARCHAR(255))
            BEGIN
                UPDATE users SET role = p_role WHERE id = p_user_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS update_user_role;');
    }
};
