<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RobotRule extends Model
{
    protected $fillable = ['user_agent', 'disallow'];

    public static function renderTxt(): string
    {
        $lines = [];

        foreach (static::orderBy('user_agent')->get()->groupBy('user_agent') as $userAgent => $rules) {
            $lines[] = "User-agent: {$userAgent}";
            foreach ($rules as $rule) {
                $lines[] = "Disallow: {$rule->disallow}";
            }
            $lines[] = '';
        }

        return trim(implode("\n", $lines))."\n";
    }
}
