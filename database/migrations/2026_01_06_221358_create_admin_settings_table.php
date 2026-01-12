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
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name')->default('Les Hameçonnés');
            $table->string('primary_color')->default('#06b6d4'); // Cyan
            $table->string('danger_color')->default('#f43f5e'); // Rose
            $table->string('gray_color')->default('#64748b'); // Slate
            $table->string('info_color')->default('#3b82f6'); // Blue
            $table->string('success_color')->default('#14b8a6'); // Teal
            $table->string('warning_color')->default('#f59e0b'); // Amber
            $table->string('font_family')->default('Inter');
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->boolean('show_breadcrumbs')->default(true);
            $table->boolean('is_dark_mode_enabled')->default(true);
            $table->timestamps();
        });

        // Insert default settings
        DB::table('admin_settings')->insert([
            'brand_name' => 'Les Hameçonnés',
            'primary_color' => '#06b6d4',
            'danger_color' => '#f43f5e',
            'gray_color' => '#64748b',
            'info_color' => '#3b82f6',
            'success_color' => '#14b8a6',
            'warning_color' => '#f59e0b',
            'font_family' => 'Inter',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_settings');
    }
};
