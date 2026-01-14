<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'group', 'key', 'type', 'value',
    ];

    public $timestamps = true;

    public function getValueAttribute($value)
    {
        $type = $this->attributes['type'] ?? null;
        if ($type === 'json') {
            return $value ? json_decode($value, true) : [];
        }
        if ($type === 'bool') {
            return (bool) $value;
        }
        if ($type === 'number') {
            return is_numeric($value) ? 0 + $value : $value;
        }
        return $value;
    }

    public function setValueAttribute($value): void
    {
        if (is_array($value) || is_object($value)) {
            $this->attributes['type'] = 'json';
            $this->attributes['value'] = json_encode($value, JSON_UNESCAPED_UNICODE);
            return;
        }
        if (is_bool($value)) {
            $this->attributes['type'] = 'bool';
            $this->attributes['value'] = $value ? '1' : '0';
            return;
        }
        if (is_numeric($value)) {
            $this->attributes['type'] = 'number';
            $this->attributes['value'] = (string) $value;
            return;
        }
        $this->attributes['type'] = 'string';
        $this->attributes['value'] = (string) $value;
    }

    public static function get(string $group, string $key, $default = null)
    {
        $row = static::query()->where(compact('group', 'key'))->first();
        return $row ? $row->value : $default;
    }

    public static function set(string $group, string $key, $value): self
    {
        return tap(static::query()->firstOrNew(compact('group', 'key')), function ($row) use ($value) {
            $row->value = $value;
            $row->save();
        });
    }
}
