<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Facades\LogBatch;

class ActivityLogController extends Controller
{
    static function activtyLog($data, $event, $log){
        LogBatch::startBatch();
        LogBatch::getUuid();
        activity()
        ->performedOn($data)
        ->withProperties(['ip' => controller::get_client_ip(), 'data' => json_encode($data)])
        ->event($event)
        ->log($log);

        return activity();
    }
}
