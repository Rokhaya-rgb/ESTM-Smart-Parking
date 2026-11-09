<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingMetric extends Model
{
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['key', 'value'];

    public static function put(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => (string) $value]);
    }

    public static function read(string $key, $default = null)
    {
        $m = static::find($key);
        return $m ? $m->value : $default;
    }
}
