<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Quotes received before the phone field existed have no number, so the
 * column must allow NULL. Converts the empty strings MySQL back-filled.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->change();
        });

        DB::table('quotes')->where('phone', '')->update(['phone' => null]);
    }

    public function down(): void
    {
        // Left nullable: older quotes have no phone number to restore.
    }
};
