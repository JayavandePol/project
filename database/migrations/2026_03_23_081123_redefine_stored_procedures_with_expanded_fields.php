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
        // --- 1. Klanten ---
        DB::unprepared("DROP PROCEDURE IF EXISTS InsertKlant;");
        DB::unprepared("CREATE PROCEDURE InsertKlant(IN p_name VARCHAR(255), IN p_email VARCHAR(255), IN p_phone VARCHAR(255), IN p_address TEXT, IN p_postal_code VARCHAR(255), IN p_city VARCHAR(255))
            BEGIN INSERT INTO klanten (name, email, phone, address, postal_code, city, created_at, updated_at) VALUES (p_name, p_email, p_phone, p_address, p_postal_code, p_city, NOW(), NOW()); END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateKlant;");
        DB::unprepared("CREATE PROCEDURE UpdateKlant(IN p_id BIGINT, IN p_name VARCHAR(255), IN p_email VARCHAR(255), IN p_phone VARCHAR(255), IN p_address TEXT, IN p_postal_code VARCHAR(255), IN p_city VARCHAR(255))
            BEGIN UPDATE klanten SET name = p_name, email = p_email, phone = p_phone, address = p_address, postal_code = p_postal_code, city = p_city, updated_at = NOW() WHERE id = p_id; END;");

        // --- 2. Reizen ---
        DB::unprepared("DROP PROCEDURE IF EXISTS InsertReis;");
        DB::unprepared("CREATE PROCEDURE InsertReis(IN p_title VARCHAR(255), IN p_destination VARCHAR(255), IN p_description TEXT, IN p_price DECIMAL(10,2), IN p_max_participants INT, IN p_start_date DATE, IN p_end_date DATE)
            BEGIN INSERT INTO reizen (title, destination, description, price, max_participants, start_date, end_date, created_at, updated_at) VALUES (p_title, p_destination, p_description, p_price, p_max_participants, p_start_date, p_end_date, NOW(), NOW()); END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateReis;");
        DB::unprepared("CREATE PROCEDURE UpdateReis(IN p_id BIGINT, IN p_title VARCHAR(255), IN p_destination VARCHAR(255), IN p_description TEXT, IN p_price DECIMAL(10,2), IN p_max_participants INT, IN p_start_date DATE, IN p_end_date DATE)
            BEGIN UPDATE reizen SET title = p_title, destination = p_destination, description = p_description, price = p_price, max_participants = p_max_participants, start_date = p_start_date, end_date = p_end_date, updated_at = NOW() WHERE id = p_id; END;");

        // --- 3. Accommodaties ---
        DB::unprepared("DROP PROCEDURE IF EXISTS InsertAccommodatie;");
        DB::unprepared("CREATE PROCEDURE InsertAccommodatie(IN p_name VARCHAR(255), IN p_location VARCHAR(255), IN p_type VARCHAR(255), IN p_rating INT, IN p_amenities TEXT, IN p_price_per_night DECIMAL(10,2))
            BEGIN INSERT INTO accommodaties (name, location, type, rating, amenities, price_per_night, created_at, updated_at) VALUES (p_name, p_location, p_type, p_rating, p_amenities, p_price_per_night, NOW(), NOW()); END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateAccommodatie;");
        DB::unprepared("CREATE PROCEDURE UpdateAccommodatie(IN p_id BIGINT, IN p_name VARCHAR(255), IN p_location VARCHAR(255), IN p_type VARCHAR(255), IN p_rating INT, IN p_amenities TEXT, IN p_price_per_night DECIMAL(10,2))
            BEGIN UPDATE accommodaties SET name = p_name, location = p_location, type = p_type, rating = p_rating, amenities = p_amenities, price_per_night = p_price_per_night, updated_at = NOW() WHERE id = p_id; END;");

        // --- 4. Boekingen ---
        DB::unprepared("DROP PROCEDURE IF EXISTS CreateBookingWithInvoice;");
        DB::unprepared("
            CREATE PROCEDURE CreateBookingWithInvoice(
                IN p_user_id BIGINT,
                IN p_klant_id BIGINT,
                IN p_reis_id BIGINT,
                IN p_accommodatie_id BIGINT,
                IN p_num_people INT,
                IN p_booking_date DATE,
                IN p_status VARCHAR(255)
            )
            BEGIN
                DECLARE v_booking_id BIGINT;
                DECLARE v_reis_price DECIMAL(10, 2);
                DECLARE v_invoice_number VARCHAR(255);
                
                SELECT price INTO v_reis_price FROM reizen WHERE id = p_reis_id;
                
                INSERT INTO boekingen (user_id, klant_id, reis_id, accommodatie_id, num_people, booking_date, status, created_at, updated_at)
                VALUES (p_user_id, p_klant_id, p_reis_id, p_accommodatie_id, p_num_people, p_booking_date, p_status, NOW(), NOW());
                
                SET v_booking_id = LAST_INSERT_ID();
                SET v_invoice_number = CONCAT('INV-', v_booking_id, '-', FLOOR(RAND() * 10000));
                
                INSERT INTO facturen (boeking_id, invoice_number, amount, status, due_date, created_at, updated_at)
                VALUES (v_booking_id, v_invoice_number, (v_reis_price * p_num_people), 'unpaid', DATE_ADD(NOW(), INTERVAL 14 DAY), NOW(), NOW());
            END;
        ");

        DB::unprepared("DROP PROCEDURE IF EXISTS UpdateBoeking;");
        DB::unprepared("CREATE PROCEDURE UpdateBoeking(IN p_id BIGINT, IN p_klant_id BIGINT, IN p_reis_id BIGINT, IN p_accommodatie_id BIGINT, IN p_num_people INT, IN p_booking_date DATE, IN p_status VARCHAR(255))
            BEGIN UPDATE boekingen SET klant_id = p_klant_id, reis_id = p_reis_id, accommodatie_id = p_accommodatie_id, num_people = p_num_people, booking_date = p_booking_date, status = p_status, updated_at = NOW() WHERE id = p_id; END;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't restore old procedures in DOWN for redefine blocks usually, but we could revert to simpler versions if needed.
    }
};
