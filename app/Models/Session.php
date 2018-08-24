<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Session extends Model
{
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'last_action_at', 'type'];
    public $timestamps = false;

    const ADMIN_DURATION = 40;
	const OTHER_DURATION = 15;

    const NOTIFY_LOGOUT = 'notify';
    const DESTROY = 'destroy';

    /**
     * Активная сессия
     */
    public function scopeActive($query)
    {
        $query->where(
            DB::raw('TIMESTAMPDIFF(MINUTE, last_action_at, NOW())'),
            '<',
            DB::raw("IF(type = 'ADMIN', " . self::ADMIN_DURATION . ", " . self::OTHER_DURATION . ")")
        );
    }
}
