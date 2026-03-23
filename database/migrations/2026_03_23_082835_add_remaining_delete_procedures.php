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
        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteKlant;");
        DB::unprepared("CREATE PROCEDURE DeleteKlant(IN p_id BIGINT) BEGIN DELETE FROM klanten WHERE id = p_id; END;");

        DB::unprepared("DROP PROCEDURE IF EXISTS DeleteAccommodatie;");
        DB::unprepared("CREATE PROCEDURE DeleteAccommodatie(IN p_id BIGINT) BEGIN DELETE FROM accommodaties WHERE id = p_id; END;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ...
    }
};
