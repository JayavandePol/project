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
        Schema::create('booking_stored_procedure', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        DB::unprepared("DROP PROCEDURE IF EXISTS CreateBookingWithInvoice;");

        DB::unprepared("
            CREATE PROCEDURE CreateBookingWithInvoice(
                IN p_user_id BIGINT,
                IN p_klant_id BIGINT,
                IN p_reis_id BIGINT,
                IN p_accommodatie_id BIGINT,
                IN p_booking_date DATE,
                IN p_status VARCHAR(255)
            )
            BEGIN
                DECLARE v_booking_id BIGINT;
                DECLARE v_reis_price DECIMAL(10, 2);
                DECLARE v_invoice_number VARCHAR(255);
                
                -- Get the price of the trip
                SELECT price INTO v_reis_price FROM reizen WHERE id = p_reis_id;
                
                -- Insert the booking
                INSERT INTO boekingen (user_id, klant_id, reis_id, accommodatie_id, booking_date, status, created_at, updated_at)
                VALUES (p_user_id, p_klant_id, p_reis_id, p_accommodatie_id, p_booking_date, p_status, NOW(), NOW());
                
                SET v_booking_id = LAST_INSERT_ID();
                
                -- Generate a simple invoice number
                SET v_invoice_number = CONCAT('INV-', v_booking_id, '-', FLOOR(RAND() * 10000));
                
                -- Insert the invoice automatically
                INSERT INTO facturen (boeking_id, invoice_number, amount, status, due_date, created_at, updated_at)
                VALUES (v_booking_id, v_invoice_number, v_reis_price, 'unpaid', DATE_ADD(NOW(), INTERVAL 14 DAY), NOW(), NOW());
                
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS CreateBookingWithInvoice;");
        Schema::dropIfExists('booking_stored_procedure');
    }
};
