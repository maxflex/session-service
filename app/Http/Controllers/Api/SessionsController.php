<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\{Session, DelayedJob};
use App\Jobs\Delayed\LogoutNotifyJob;
use App\Events\LogoutSignal;

class SessionsController extends Controller
{
    public function action(Request $request)
    {
        $data['last_action_at'] = date('Y-m-d H:i:s');
        $data['type'] = $request->type;

        Session::updateOrCreate(['user_id' => $request->user_id], $data);

        DelayedJob::dispatch(
            LogoutNotifyJob::class,
            ['user_id' => $request->user_id],
            $request->type == 'ADMIN' ? (Session::ADMIN_DURATION - 1) : (Session::OTHER_DURATION - 1)
        );

        return response(null, 200);
    }

    /**
     * Существует ли активная сессия?
     */
    public function exists($user_id)
    {
        return response()->json(Session::active()->whereUserId($user_id)->exists(), 200);
    }

    public function destroy($user_id)
    {
        event(new LogoutSignal($user_id, Session::DESTROY));
        Session::where('user_id', $user_id)->delete();
    }
}
