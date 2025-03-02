<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Models\SMS\SmsLog;
use Illuminate\Http\Request;

class SmsLogController extends Controller
{
    public function report(){
        $logs = SmsLog::where('branch_id', session('branch')['id'])->with('user')->latest()->paginate(100);
        return view('admin.sms.report.index', compact('logs'));
    }
}
