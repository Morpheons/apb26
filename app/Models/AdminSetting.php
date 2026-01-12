<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    protected $fillable = [
        'brand_name',
        'primary_color',
        'danger_color',
        'gray_color',
        'info_color',
        'success_color',
        'warning_color',
        'sidebar_color',
        'background_color',
        'font_family',
        'logo_path',
        'favicon_path',
        'show_breadcrumbs',
        'is_dark_mode_enabled',
    ];

    protected $casts = [
        'show_breadcrumbs' => 'boolean',
        'is_dark_mode_enabled' => 'boolean',
    ];

    /**
     * Get the singleton instance of admin settings.
     */
    public static function current(): self
    {
        try {
            return static::first() ?? static::create([
                'brand_name' => 'APB Dashboard',
                'primary_color' => '#06b6d4',
                'danger_color' => '#f43f5e',
                'gray_color' => '#64748b',
                'info_color' => '#3b82f6',
                'success_color' => '#14b8a6',
                'warning_color' => '#f59e0b',
                'sidebar_color' => '#0f172a',
                'background_color' => '#000000',
                'font_family' => 'Inter',
            ]);
        } catch (\Throwable $e) {
            // Retourne une instance non persistée en cas d'erreur (ex: table manquante)
            return new static([
                'brand_name' => 'APB Dashboard',
                'primary_color' => '#06b6d4',
                'danger_color' => '#f43f5e',
                'gray_color' => '#64748b',
                'info_color' => '#3b82f6',
                'success_color' => '#14b8a6',
                'warning_color' => '#f59e0b',
                'sidebar_color' => '#0f172a',
                'background_color' => '#000000',
                'font_family' => 'Inter',
            ]);
        }
    }
}
