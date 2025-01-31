<?php

namespace App\Models;

use Cache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Remotelywork\Installer\Repository\App;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Add a settings value
     *
     * @param  string  $type
     * @return bool
     */
    public static function add($key, $val, $type = 'string')
    {
        if (self::has($key)) {
            return self::set($key, $val, $type);
        }

        return self::create(['name' => $key, 'val' => $val, 'type' => $type]) ? $val : false;
    }

    /**
     * Check if setting exists
     *
     * @return bool
     */
    public static function has($key)
    {
        if(!App::dbConnectionCheck()){
            return [];
        }
        
        return (bool) self::getAllSettings()->whereStrict('name', $key)->count();
    }

    /**
     * Get all the settings
     *
     * @return mixed
     */
    public static function getAllSettings()
    {
        if(!App::dbConnectionCheck()){
            return [];
        }

        return Cache::rememberForever('settings.all', function () {
            return self::all();
        });
    }

    /**
     * Set a value for setting
     *
     * @param  string  $type
     * @return bool
     */
    public static function set($key, $val, $type = 'string')
    {
        if ($setting = self::getAllSettings()->where('name', $key)->first()) {
            return $setting->update([
                'name' => $key,
                'val' => $val,
                'type' => $type]) ? $val : false;
        }

        return self::add($key, $val, $type);
    }

    /**
     * Remove a setting
     *
     * @return bool
     */
    public static function remove($key)
    {
        if (self::has($key)) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * Get the validation rules for setting fields
     *
     * @return array ;;
     */
    public static function getValidationRules($section)
    {
        return self::getDefinedSettingFields($section)->pluck('rules', 'name')
            ->reject(function ($val) {
                return is_null($val);
            })->toArray();
    }

    /**
     * Get all the settings fields from config ;;
     *
     * @return Collection
     */
    private static function getDefinedSettingFields($section)
    {
        return collect(config('setting')[$section]['elements']);
    }

    /**
     * Get the data type of a setting
     *
     * @return mixed ;;
     */
    public static function getDataType($field, $section)
    {
        $type = self::getDefinedSettingFields($section)
            ->pluck('data', 'name')
            ->get($field);

        return is_null($type) ? 'string' : $type;
    }

    /**
     * Get a settings value
     *
     * @param  null  $default
     * @return bool|int|mixed
     */
    public static function get($key, $section = null, $default = null)
    {
        if (self::has($key)) {
            $setting = self::getAllSettings()->where('name', $key)->first();

            return self::castValue($setting->val, $setting->type);
        }

        return self::getDefaultValue($key, $section, $default);
    }

    /**
     * caste value into respective type
     *
     * @return bool|int
     */
    private static function castValue($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer':
                return intval($val);
                break;

            case 'bool':
            case 'boolean':
                return boolval($val);
                break;

            default:
                return $val;
        }
    }

    /**
     * Get default value from config if no value passed
     *
     * @return mixed
     */
    private static function getDefaultValue($key, $section, $default)
    {
        return is_null($default) ? self::getDefaultValueForField($key, $section) : $default;
    }

    /**
     * Get default value for a setting
     *
     * @return mixed
     */
    public static function getDefaultValueForField($field, $section)
    {
        return self::getDefinedSettingFields($section)
            ->pluck('value', 'name')
            ->get($field);
    }

    /**
     * The "booting" account of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function () {
            self::flushCache();
        });
    }

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('settings.all');
    }
}
