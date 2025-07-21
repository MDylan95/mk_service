<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageDiffusion extends Model
{
    protected $table = 'message_diffusion';
    protected $fillable = ['key', 'value'];

    public static function getValue(string $key, $default = null)
    {
        $record = self::where('key', $key)->first();
        return $record ? $record->value : $default;
    }
}
