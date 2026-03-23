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
        // 1. DeleteUser
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteUser;");
        DB::unprepared("
            CREATE PROCEDURE DeleteUser(IN p_id BIGINT, IN p_current_user_id BIGINT)
            BEGIN
                DECLARE admin_count INT;
                DECLARE target_role ENUM('user', 'admin');
                
                SELECT COUNT(*) INTO admin_count FROM users WHERE role = 'admin';
                SELECT role INTO target_role FROM users WHERE id = p_id;
                
                IF p_id = p_current_user_id THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'U kunt uw eigen account niet verwijderen.';
                ELSEIF admin_count <= 1 AND target_role = 'admin' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'U kunt de laatste administrator niet verwijderen.';
                ELSE
                    DELETE FROM users WHERE id = p_id;
                END IF;
            END;
        ");

        // 2. DeleteFactuur
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteFactuur;");
        DB::unprepared("
            CREATE PROCEDURE DeleteFactuur(IN p_id BIGINT)
            BEGIN
                DECLARE v_status VARCHAR(50);
                SELECT status INTO v_status FROM facturen WHERE id = p_id;
                
                IF v_status = 'paid' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Een betaalde factuur kan niet worden verwijderd.';
                ELSE
                    DELETE FROM facturen WHERE id = p_id;
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ...
    }
};
