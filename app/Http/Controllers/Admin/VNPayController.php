<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Video_page;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image;
use App\Model\VNPayLog;

class VNPayController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function logs()
    {
        $logs = VNPayLog::orderByDesc('created_at')->limit(6)->get();
        $data = [];
        foreach($logs as $log)
        {
            $data[] = [
                'ip'    => $log->ip,
                'data'    => json_decode($log->data, true),
            ];
        }
        ddd($data);
    }

}
