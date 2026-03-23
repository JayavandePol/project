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
        // 1. UpdateReis with Business Logic
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateReis;");
        DB::unprepared("
            CREATE PROCEDURE UpdateReis(
                IN p_id BIGINT, 
                IN p_title VARCHAR(255), 
                IN p_destination VARCHAR(255), 
                IN p_description TEXT, 
                IN p_price DECIMAL(10,2), 
                IN p_max_participants INT, 
                IN p_start_date DATE, 
                IN p_end_date DATE
            )
            BEGIN
                DECLARE v_current_start_date DATE;
                
                SELECT start_date INTO v_current_start_date FROM reizen WHERE id = p_id;
                
                IF v_current_start_date <= CURDATE() THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Deze reis is al gestart en kan niet meer gewijzigd worden.';
                END IF;
                
                UPDATE reizen 
                SET title = p_title, 
                    destination = p_destination, 
                    description = p_description, 
                    price = p_price, 
                    max_participants = p_max_participants, 
                    start_date = p_start_date, 
                    end_date = p_end_date, 
                    updated_at = NOW() 
                WHERE id = p_id;
            END;
        ");

        // 2. UpdateBoeking with Business Logic
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateBoeking;");
        DB::unprepared("
            CREATE PROCEDURE UpdateBoeking(
                IN p_id BIGINT, 
                IN p_klant_id BIGINT, 
                IN p_reis_id BIGINT, 
                IN p_accommodatie_id BIGINT, 
                IN p_num_people INT, 
                IN p_booking_date DATE, 
                IN p_status VARCHAR(255)
            )
            BEGIN
                DECLARE v_invoice_status VARCHAR(255);
                DECLARE v_travel_start_date DATE;
                
                -- Check Invoice Status
                SELECT status INTO v_invoice_status FROM facturen WHERE boeking_id = p_id;
                
                -- Check Travel Start Date
                SELECT r.start_date INTO v_travel_start_date 
                FROM boekingen b 
                JOIN reizen r ON b.reis_id = r.id 
                WHERE b.id = p_id;
                
                IF v_invoice_status = 'paid' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Deze boeking is al betaald en kan niet meer gewijzigd worden.';
                END IF;
                
                IF v_travel_start_date <= CURDATE() THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'De reis voor deze boeking is al gestart of voltooid.';
                END IF;
                
                UPDATE boekingen 
                SET klant_id = p_klant_id, 
                    reis_id = p_reis_id, 
                    accommodatie_id = p_accommodatie_id, 
                    num_people = p_num_people, 
                    booking_date = p_booking_date, 
                    status = p_status, 
                    updated_at = NOW() 
                WHERE id = p_id;
            END;
        ");
        
        // 3. DeleteReis with Business Logic
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteReis;");
        DB::unprepared("
            CREATE PROCEDURE DeleteReis(IN p_id BIGINT)
            BEGIN
                DECLARE v_start_date DATE;
                SELECT start_date INTO v_start_date FROM reizen WHERE id = p_id;
                
                IF v_start_date <= CURDATE() THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Een reis die al gestart is kan niet worden verwijderd.';
                END IF;
                
                DELETE FROM reizen WHERE id = p_id;
            END;
        ");

        // 4. DeleteBoeking with Business Logic
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteBoeking;");
        DB::unprepared("
            CREATE PROCEDURE DeleteBoeking(IN p_id BIGINT)
            BEGIN
                DECLARE v_invoice_status VARCHAR(255);
                SELECT status INTO v_invoice_status FROM facturen WHERE boeking_id = p_id;
                
                IF v_invoice_status = 'paid' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Een betaalde boeking kan niet worden verwijderd.';
                END IF;
                
                DELETE FROM boekingen WHERE id = p_id;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to simple versions if needed or just drop
    }
};
