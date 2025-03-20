<?php
// app/Models/Setting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use \Cache;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'app_name',
        'title',
        'meta_title',
        'meta_description',
        'logo',
        'icon',
        'language',
        'date_format',
        'time_format',
        'currency_symbol',
        'copyright_text',
        'maintenance_mode'
    ];

    protected $casts = [
        'maintenance_mode' => 'boolean'
    ];

    public static function getCachedSettings()
    {
        return Cache::remember('settings', 3600, function () {
            return self::first() ?? new self();
        });
    }

    public static function clearCache()
    {
        Cache::forget('settings');
    }

    protected static function booted()
    {
        static::saved(function ($setting) {
            self::clearCache();
        });
    }
}