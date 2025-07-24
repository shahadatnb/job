<?php

namespace App\Http\Controllers\SMS;
use App\Models\ApplicationStatus;
use App\Models\JobApplication;
use App\Models\Job;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\SMS\SmsTemplate;
use App\Models\SMS\SmsLog;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportNumber;
use App\Facades\CustomHelperFacade as CustomHelper;

class SMSController extends Controller
{
    public function index(Request $request){
        $templates = SmsTemplate::pluck('title', 'id')->toArray();
        $applicationStatus = ApplicationStatus::where('status', 1)->orderBy('serial', 'asc')->pluck('name', 'id');
        $jobs = Job::where('status', 1)->pluck('title', 'id');
        $data = ['job_id'=>'','status'=>'','phone'=>''];

        if(!empty($request->job_id)) {
            $applied_jobs = JobApplication::with('job', 'student')->latest();
            $data['job_id'] = $request->job_id;
            $applied_jobs = $applied_jobs->whereHas('job', function ($query) use ($request) {
                $query->where('id', $request->job_id);
            });

            if(!empty($request->phone)) {
                $data['phone'] = $request->phone;
                $applied_jobs = $applied_jobs->whereHas('student', function ($query) use ($request) {
                    $query->where('phone', $request->phone);
                });
            }

            if(!empty($request->status)) {
                $data['status'] = $request->status;
                $applied_jobs = $applied_jobs->where('status', $request->status);
            }

            $applied_jobs = $applied_jobs->paginate(100);
        }else{
            $applied_jobs = [];
        }
        return view('admin.sms.send.index', compact('templates', 'applicationStatus', 'applied_jobs', 'data', 'jobs'));
    }

    public function send(Request $request){
        $this->validate($request, [
            //'numberType' => 'required',
            'contacts' => 'required_if:numberType,contact',
            //'file' => 'mimes:xlsx,xls|required_if:numberType,excel',
            'content' => 'required',
        ]);

        //dd($request->all()); exit;

        foreach($request->contacts as $key => $number){
            $contact = substr($number, 0, 2) == '88' ? $number : '88'.$number;
            $message_body = str_replace('[name]', $request->applicant_name[$key], $request->content);
            $message_body = str_replace('[job_title]', $request->job_title[$key], $message_body);
            $response = CustomHelper::send_sms($contact, $message_body);
            $this->save_log($response, $contact, $message_body);
        }

        /*
        if($request->numberType == 'contact'){            
           $contacts = [];
            foreach($request->contacts as $key => $number){
                $number = substr($number, 0, 2) == '88' ? $number : '88'.$number;
                $contacts[$key] = $number;
                $message_body[$number] = str_replace('[name]', $request->applicant_name[$key], $request->content);
            }
            //$response = CustomHelper::post_send_sms($contacts, $request->content);
            if(count($contacts) > 50){
                foreach(array_chunk($contacts, 50) as $chunk){
                    $numbers = implode(',', $chunk);
                    $response = CustomHelper::send_sms($numbers, $request->content);
                    $this->save_log($response, $chunk, $request);
                }
            }else{
                $numbers = implode(',', $contacts);
                $response = CustomHelper::send_sms($numbers, $request->content);
                $this->save_log($response, $contacts, $request);
            }
            
        }elseif($request->numberType == 'excel'){
            //Excel::import(new ImportNumber, $request->file('file'));
            $array = Excel::toArray(new ImportNumber, $request->file('file'));
            //dd($array); exit;
            foreach($array[0] as $key => $row){
                $numbers[$key] = substr($row['mobile'], 0, 1) == '1' ? '0'.$row['mobile'] : $row['mobile'];
            }
            //$response = CustomHelper::post_send_sms($numbers, $request->content);
            if(count($numbers) > 50){
                foreach(array_chunk($numbers, 50) as $chunk){
                    $numbers = implode(',', $chunk);
                    $response = CustomHelper::send_sms($numbers, $request->content);
                    $this->save_log($response, $numbers, $request);
                }
            }else{
                $numbers = implode(',', $numbers);
                $response = CustomHelper::send_sms($numbers, $request->content);
                $this->save_log($response, $numbers, $request);
            }
        }
*/
        /*
        return Http::post(config('settings.sms_domain_url').':7788/send',[
            'apikey'=> config('settings.sms_api_key'),
            'secretkey'=> config('settings.sms_secretkey'),
            'content'=> [
                "callerID"=>"12345",
                "toUser"=>$numbers,
                "messageContent"=>$request->content
            ]
        ]);
        */
        //$response = Http::get(config('settings.sms_domain_url').':7788/send?apikey='.config('settings.sms_api_key').'&secretkey='.config('settings.sms_secretkey').'&content=[{"callerID":"12345","toUser":"'.$numbers.'","messageContent":"'.$request->content.'"}]');
        //$response = Http::get(config('settings.sms_domain_url',null).'/miscapi/'.config('settings.sms_api_key').'/getDLR/getAll');
        //dd($response);exit;
        //if($response->successful()){
        
        return redirect()->back();        
    }

    private function save_log($response, $contact, $content){
        if(str_contains($response, 'ACCEPTD')){
            session()->flash('success', 'SMS sent successfully');
            //return $response->json();
            //return $response;
            //return $data = json_decode($response->body());
            //$numbers = implode(' ', $contacts);
            SmsLog::create(
                [
                    'mobile' => $contact,
                    'message' => $content,
                    'status' => 'success',//$msg['Status'],
                    'created_by' => auth()->user()->id,
                    'sms_count' => 1,
                    'response' => 'success',//$data['Text'],
                ]
            );
            
        }
    }

    public function smsBalance(Request $request){
        //$response =  Http::get(config('settings.sms_domain_url')."/portal/sms/smsConfiguration/smsClientBalance.jsp?client=".config('settings.sms_client'));
        $response =  Http::get(config('settings.sms_domain_url').'/miscapi/'.config('settings.sms_api_key').'/getBalance');
        //$response = trim($response,'Your Balance is:BDT');
        return response()->json([
            'balance' => $response->body()
        ]);
        //return $response;
    }
}
