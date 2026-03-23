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
        // 1. Klanten
        DB::unprepared("DROP PROCEDURE IF EXISTS GetAllKlanten;");
        DB::unprepared("CREATE PROCEDURE GetAllKlanten() BEGIN SELECT * FROM klanten ORDER BY name ASC; END;");
        
        DB::unprepared("DROP PROCEDURE IF EXISTS InsertKlant;");
        DB::unprepared("CREATE PROCEDURE InsertKlant(IN p_name VARCHAR(255), IN p_email VARCHAR(255), IN p_phone VARCHAR(255), IN p_address TEXT)
            BEGIN INSERT INTO klanten (name, email, phone, address, created_at, updated_at) VALUES (p_name, p_email, p_phone, p_address, NOW(), NOW()); END;");

        // 2. Reizen
        DB::unprepared("DROP PROCEDURE IF EXISTS GetAllReizen;");
        DB::unprepared("CREATE PROCEDURE GetAllReizen() BEGIN SELECT * FROM reizen ORDER BY start_date ASC; END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS InsertReis;");
        DB::unprepared("CREATE PROCEDURE InsertReis(IN p_title VARCHAR(255), IN p_description TEXT, IN p_price DECIMAL(10,2), IN p_start_date DATE, IN p_end_date DATE)
            BEGIN INSERT INTO reizen (title, description, price, start_date, end_date, created_at, updated_at) VALUES (p_title, p_description, p_price, p_start_date, p_end_date, NOW(), NOW()); END;");

        // 3. Accommodaties
        DB::unprepared("DROP PROCEDURE IF EXISTS GetAllAccommodaties;");
        DB::unprepared("CREATE PROCEDURE GetAllAccommodaties() BEGIN SELECT * FROM accommodaties ORDER BY name ASC; END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS InsertAccommodatie;");
        DB::unprepared("CREATE PROCEDURE InsertAccommodatie(IN p_name VARCHAR(255), IN p_location VARCHAR(255), IN p_type VARCHAR(255), IN p_price_per_night DECIMAL(10,2))
            BEGIN INSERT INTO accommodaties (name, location, type, price_per_night, created_at, updated_at) VALUES (p_name, p_location, p_type, p_price_per_night, NOW(), NOW()); END;");

        // 4. Boekingen (Complex Read with Joins)
        DB::unprepared("DROP PROCEDURE IF EXISTS GetAllBoekingen;");
        DB::unprepared("CREATE PROCEDURE GetAllBoekingen()
            BEGIN 
                SELECT b.*, k.name as klant_name, r.title as reis_title, a.name as acc_name, u.name as user_name
                FROM boekingen b
                JOIN klanten k ON b.klant_id = k.id
                JOIN reizen r ON b.reis_id = r.id
                JOIN accommodaties a ON b.accommodatie_id = a.id
                JOIN users u ON b.user_id = u.id
                ORDER BY b.booking_date DESC;
            END;");

        // 5. Facturen (Read with Joins)
        DB::unprepared("DROP PROCEDURE IF EXISTS GetAllFacturen;");
        DB::unprepared("CREATE PROCEDURE GetAllFacturen()
            BEGIN
                SELECT f.*, k.name as klant_name, r.title as reis_title
                FROM facturen f
                JOIN boekingen b ON f.boeking_id = b.id
                JOIN klanten k ON b.klant_id = k.id
                JOIN reizen r ON b.reis_id = r.id
                ORDER BY f.created_at DESC;
            END;");

        // 6. Users
        DB::unprepared("DROP PROCEDURE IF EXISTS GetAllUsers;");
        DB::unprepared("CREATE PROCEDURE GetAllUsers() BEGIN SELECT * FROM users ORDER BY name ASC; END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS InsertUser;");
        DB::unprepared("CREATE PROCEDURE InsertUser(IN p_name VARCHAR(255), IN p_email VARCHAR(255), IN p_password VARCHAR(255), IN p_role VARCHAR(255))
            BEGIN INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (p_name, p_email, p_password, p_role, NOW(), NOW()); END;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('all_crud_stored_procedures');
    }
};
