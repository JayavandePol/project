<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. InsertFactuur
        DB::unprepared("DROP PROCEDURE IF EXISTS InsertFactuur;");
        DB::unprepared("CREATE PROCEDURE InsertFactuur(IN p_boeking_id INT, IN p_amount DECIMAL(10,2), IN p_due_date DATE, IN p_status VARCHAR(255)) BEGIN INSERT INTO facturen (boeking_id, invoice_number, amount, status, due_date, created_at, updated_at) VALUES (p_boeking_id, UUID(), p_amount, p_status, p_due_date, NOW(), NOW()); END;");

        // 2. UpdateFactuur
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateFactuur;");
        DB::unprepared("CREATE PROCEDURE UpdateFactuur(IN p_id INT, IN p_amount DECIMAL(10,2), IN p_due_date DATE, IN p_status VARCHAR(255)) BEGIN DECLARE v_current_status VARCHAR(255); SELECT status INTO v_current_status FROM facturen WHERE id = p_id; IF v_current_status = 'paid' THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Deze factuur is al betaald en kan niet meer gewijzigd worden.'; END IF; UPDATE facturen SET amount = p_amount, due_date = p_due_date, status = p_status, updated_at = NOW() WHERE id = p_id; END;");

        // 3. DeleteFactuur
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteFactuur;");
        DB::unprepared("CREATE PROCEDURE DeleteFactuur(IN p_id INT) BEGIN DECLARE v_current_status VARCHAR(255); SELECT status INTO v_current_status FROM facturen WHERE id = p_id; IF v_current_status = 'paid' THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Een betaalde factuur kan niet verwijderd worden uit de administratie.'; END IF; DELETE FROM facturen WHERE id = p_id; END;");

        // 4. GetFactuurById
        DB::unprepared("DROP PROCEDURE IF EXISTS GetFactuurById;");
        DB::unprepared("CREATE PROCEDURE GetFactuurById(IN p_id INT) BEGIN SELECT f.*, k.name as klant_name, k.id as klant_id, r.title as reis_title, b.id as boeking_id FROM facturen f JOIN boekingen b ON f.boeking_id = b.id JOIN klanten k ON b.klant_id = k.id JOIN reizen r ON b.reis_id = r.id WHERE f.id = p_id; END;");
        
        // 5. GetAllFacturen
        DB::unprepared("DROP PROCEDURE IF EXISTS GetAllFacturen;");
        DB::unprepared("CREATE PROCEDURE GetAllFacturen() BEGIN SELECT f.*, k.name as klant_name, r.title as reis_title FROM facturen f JOIN boekingen b ON f.boeking_id = b.id JOIN klanten k ON b.klant_id = k.id JOIN reizen r ON b.reis_id = r.id ORDER BY f.created_at DESC; END;");
    }

    public function down(): void
    {
    }
};
