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
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteBoeking;");
        DB::unprepared("
            CREATE PROCEDURE DeleteBoeking(IN p_id BIGINT)
            BEGIN
                DECLARE v_status VARCHAR(50);
                DECLARE v_travel_start_date DATE;
                
                -- Check Invoice Status
                SELECT status INTO v_status FROM facturen WHERE boeking_id = p_id;
                
                -- Check Travel Start Date
                SELECT r.start_date INTO v_travel_start_date 
                FROM boekingen b 
                JOIN reizen r ON b.reis_id = r.id 
                WHERE b.id = p_id;
                
                IF v_status = 'paid' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Een boeking met een betaalde factuur kan niet worden verwijderd.';
                ELSEIF v_travel_start_date <= CURDATE() THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Een boeking voor een reis die al gestart of voltooid is kan niet worden verwijderd.';
                ELSE
                    -- Delete related facturen first (since it's a child)
                    DELETE FROM facturen WHERE boeking_id = p_id;
                    DELETE FROM boekingen WHERE id = p_id;
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to the previous version (without start_date check)
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteBoeking;");
        DB::unprepared("
            CREATE PROCEDURE DeleteBoeking(IN p_id BIGINT)
            BEGIN
                DECLARE v_status VARCHAR(50);
                SELECT status INTO v_status FROM facturen WHERE boeking_id = p_id;
                
                IF v_status = 'paid' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Een boeking met een betaalde factuur kan niet worden verwijderd.';
                ELSE
                    DELETE FROM facturen WHERE boeking_id = p_id;
                    DELETE FROM boekingen WHERE id = p_id;
                END IF;
            END;
        ");
    }
};
