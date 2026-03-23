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
        DB::unprepared("DROP PROCEDURE IF EXISTS GetKlantById;");
        DB::unprepared("CREATE PROCEDURE GetKlantById(IN p_id BIGINT) BEGIN SELECT * FROM klanten WHERE id = p_id; END;");
        
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateKlant;");
        DB::unprepared("CREATE PROCEDURE UpdateKlant(IN p_id BIGINT, IN p_name VARCHAR(255), IN p_email VARCHAR(255), IN p_phone VARCHAR(255), IN p_address TEXT)
            BEGIN UPDATE klanten SET name = p_name, email = p_email, phone = p_phone, address = p_address, updated_at = NOW() WHERE id = p_id; END;");

        // 2. Reizen
        DB::unprepared("DROP PROCEDURE IF EXISTS GetReisById;");
        DB::unprepared("CREATE PROCEDURE GetReisById(IN p_id BIGINT) BEGIN SELECT * FROM reizen WHERE id = p_id; END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateReis;");
        DB::unprepared("CREATE PROCEDURE UpdateReis(IN p_id BIGINT, IN p_title VARCHAR(255), IN p_description TEXT, IN p_price DECIMAL(10,2), IN p_start_date DATE, IN p_end_date DATE)
            BEGIN UPDATE reizen SET title = p_title, description = p_description, price = p_price, start_date = p_start_date, end_date = p_end_date, updated_at = NOW() WHERE id = p_id; END;");

        // 3. Accommodaties
        DB::unprepared("DROP PROCEDURE IF EXISTS GetAccommodatieById;");
        DB::unprepared("CREATE PROCEDURE GetAccommodatieById(IN p_id BIGINT) BEGIN SELECT * FROM accommodaties WHERE id = p_id; END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateAccommodatie;");
        DB::unprepared("CREATE PROCEDURE UpdateAccommodatie(IN p_id BIGINT, IN p_name VARCHAR(255), IN p_location VARCHAR(255), IN p_type VARCHAR(255), IN p_price_per_night DECIMAL(10,2))
            BEGIN UPDATE accommodaties SET name = p_name, location = p_location, type = p_type, price_per_night = p_price_per_night, updated_at = NOW() WHERE id = p_id; END;");

        // 4. Boekingen
        DB::unprepared("DROP PROCEDURE IF EXISTS GetBoekingById;");
        DB::unprepared("CREATE PROCEDURE GetBoekingById(IN p_id BIGINT) BEGIN SELECT * FROM boekingen WHERE id = p_id; END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateBoeking;");
        DB::unprepared("CREATE PROCEDURE UpdateBoeking(IN p_id BIGINT, IN p_klant_id BIGINT, IN p_reis_id BIGINT, IN p_accommodatie_id BIGINT, IN p_booking_date DATE, IN p_status VARCHAR(255))
            BEGIN UPDATE boekingen SET klant_id = p_klant_id, reis_id = p_reis_id, accommodatie_id = p_accommodatie_id, booking_date = p_booking_date, status = p_status, updated_at = NOW() WHERE id = p_id; END;");

        // 5. Facturen
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateFactuurStatus;");
        DB::unprepared("CREATE PROCEDURE UpdateFactuurStatus(IN p_id BIGINT, IN p_status VARCHAR(255))
            BEGIN UPDATE facturen SET status = p_status, updated_at = NOW() WHERE id = p_id; END;");

        // 6. Users
        DB::unprepared("DROP PROCEDURE IF EXISTS GetUserById;");
        DB::unprepared("CREATE PROCEDURE GetUserById(IN p_id BIGINT) BEGIN SELECT * FROM users WHERE id = p_id; END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateUser;");
        DB::unprepared("CREATE PROCEDURE UpdateUser(IN p_id BIGINT, IN p_name VARCHAR(255), IN p_email VARCHAR(255), IN p_role VARCHAR(255))
            BEGIN UPDATE users SET name = p_name, email = p_email, role = p_role, updated_at = NOW() WHERE id = p_id; END;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS GetKlantById;");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateKlant;");
        DB::unprepared("DROP PROCEDURE IF EXISTS GetReisById;");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateReis;");
        DB::unprepared("DROP PROCEDURE IF EXISTS GetAccommodatieById;");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateAccommodatie;");
        DB::unprepared("DROP PROCEDURE IF EXISTS GetBoekingById;");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateBoeking;");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateFactuurStatus;");
        DB::unprepared("DROP PROCEDURE IF EXISTS GetUserById;");
        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateUser;");
    }
};
