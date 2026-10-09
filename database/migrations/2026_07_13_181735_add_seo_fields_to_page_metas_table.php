<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('page_metas', function (Blueprint $table) {
            $table->string('route')->nullable()->change();
            $table->text('description')->nullable()->change();

            $table->string('seoable_type')->nullable();
            $table->unsignedBigInteger('seoable_id')->nullable();
            $table->unique(['seoable_type', 'seoable_id']);
            $table->json('keywords')->nullable()->after('description');
            $table->string('focus_keyword')->nullable()->after('keywords');
            $table->json('secondary_keywords')->nullable()->after('focus_keyword');
            $table->string('canonical_url')->nullable()->after('secondary_keywords');
            $table->boolean('robots_index')->default(true)->after('canonical_url');
            $table->boolean('robots_follow')->default(true)->after('robots_index');
            $table->string('og_title')->nullable()->after('robots_follow');
            $table->text('og_description')->nullable()->after('og_title');
            $table->string('og_image')->nullable()->after('og_description');
            $table->string('twitter_title')->nullable()->after('og_image');
            $table->text('twitter_description')->nullable()->after('twitter_title');
            $table->string('twitter_image')->nullable()->after('twitter_description');
            $table->boolean('is_active')->default(true)->after('twitter_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_metas', function (Blueprint $table) {
            $table->dropUnique(['seoable_type', 'seoable_id']);
            $table->dropColumn([
                'seoable_type', 'seoable_id', 'keywords', 'focus_keyword', 'secondary_keywords',
                'canonical_url', 'robots_index', 'robots_follow', 'og_title', 'og_description',
                'og_image', 'twitter_title', 'twitter_description', 'twitter_image', 'is_active',
            ]);

            $table->string('route')->nullable(false)->change();
            $table->string('description')->nullable()->change();
        });
    }
};
