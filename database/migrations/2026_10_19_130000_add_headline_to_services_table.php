<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A service page's H1 headline, kept separate from the short name used in
 * menus and cards (e.g. "SEO Services" vs "SEO Services Company That Turns
 * Search Traffic Into Sales").
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('headline')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('headline');
        });
    }
};
