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
        Schema::create('page_schemas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('schema_type');
            $table->string('scope')->default('route');
            $table->string('route_name')->nullable();
            $table->string('seoable_type')->nullable();
            $table->unsignedBigInteger('seoable_id')->nullable();
            $table->json('schema_json');
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['scope', 'route_name']);
            $table->index(['seoable_type', 'seoable_id']);
            $table->index(['is_active', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_schemas');
    }
};
