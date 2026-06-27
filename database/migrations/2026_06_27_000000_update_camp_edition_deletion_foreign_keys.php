<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table): void {
            $table->dropForeign(['edition_section_id']);
            $table->foreign('edition_section_id')
                ->references('id')
                ->on('edition_sections')
                ->nullOnDelete();
        });

        Schema::table('edition_sections', function (Blueprint $table): void {
            $table->dropForeign(['camp_edition_id']);
            $table->foreign('camp_edition_id')
                ->references('id')
                ->on('camp_editions')
                ->cascadeOnDelete();
        });

        Schema::table('registrations', function (Blueprint $table): void {
            $table->dropForeign(['camp_edition_id']);
            $table->foreign('camp_edition_id')
                ->references('id')
                ->on('camp_editions')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table): void {
            $table->dropForeign(['edition_section_id']);
            $table->foreign('edition_section_id')
                ->references('id')
                ->on('edition_sections')
                ->restrictOnDelete();

            $table->dropForeign(['camp_edition_id']);
            $table->foreign('camp_edition_id')
                ->references('id')
                ->on('camp_editions')
                ->restrictOnDelete();
        });

        Schema::table('edition_sections', function (Blueprint $table): void {
            $table->dropForeign(['camp_edition_id']);
            $table->foreign('camp_edition_id')
                ->references('id')
                ->on('camp_editions')
                ->restrictOnDelete();
        });
    }
};
