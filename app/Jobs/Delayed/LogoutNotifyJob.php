<?php

namespace App\Jobs\Delayed;

use App\Events\LogoutSignal;
use App\Models\Session;

/**
 * Уведомление о логауте
 */

class LogoutNotifyJob extends Job
{
    public function handle($params)
    {
        event(new LogoutSignal($params->user_id, Session::NOTIFY_LOGOUT));
    }
}
