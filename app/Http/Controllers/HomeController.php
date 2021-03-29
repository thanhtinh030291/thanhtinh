<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Claim;
use Carbon\Carbon;
use App\MANTIS_BUG;
use Redis;
use App\FinishAndPay;
use App\AUDIT_DLVN_HBS_CPS_DIFF_AMT;
use App\AUDIT_HBS_EXISTED;
use App\AUDIT_HBS_EXISTED_BACODE;
use App\AUDIT_HBS_MANTIS_DIFF_POCY;
use App\AUDIT_HBS_MANTIS_DIFF_STATUS;
use App\AUDIT_HBS_MANTIS_EXISTED_BUG_ID;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $PENDING_LIST = [9, 10, 14, 15, 16, 20, 21, 22, 23, 30, 40, 50, 60, 65, 66, 67, 68, 69, 100, 102, 103, 110, 115, 105, 120];
        $STATUS_COLOR_LIST = array
        (
            9 => 'FF0000',
            10 => 'fcbdbd',
            11 => '00ff00',
            12 => '00ffff',
            13 => 'ff0000',
            14 => 'ffff00',
            15 => 'c0c0c0',
            16 => 'CC9900',
            20 => 'e3b7eb',
            21 => 'B74C9E',
            22 => '4DA523',
            23 => 'E4B249',
            30 => 'ffcd85',
            40 => 'fff494',
            50 => 'c2dfff',
            60 => 'ffffff',
            65 => 'FF8000',
            66 => 'CCFF33',
            67 => '9999ff',
            68 => '00FF00',
            69 => '6699ff',
            80 => 'd2f5b0',
            89 => 'e0e1dd',
            90 => 'c9ccc4',
            100 => 'ace7ae',
            102 => 'DE2574',
            103 => '375130',
            105 => 'bc57be',
            110 => 'e7acae',
            115 => 'f7ac2e',
            120 => 'e7ac7e'
        );
        $Ipclient = \Request::getClientIp(true);
        $listUser = User::getListIncharge();
        $user = Auth::user()  ;
        $latestMessages = $user->messagesReceiver10;
        //dd($latestMessages);
        $sentMessages = $user->messagesSent10;
        $sumMember = User::count();
        $sumClaim  = Claim::count();
        $sumClaimToDate = Claim::whereDate('created_at', Carbon::today())->count();
        //mantis
        $MANTIS_BUG = MANTIS_BUG::with('PROJECT')->with('history')->with('HBS_DATA')->with(['CUSTOM_FIELD_STRING'=> function ($q) {
            $q->where('field_id', 13);
        }])
        
        
        ->whereHas('handler',function ($query) use ($user) {
            $query->where('email', $user->email);
        })
        ->whereHas('PROJECT',function ($query) use ($user) {
            $EXCLUDED_PROJECTS = array('Gen. Inquiry', 'Deleted');
            $query->whereNotIn('name', $EXCLUDED_PROJECTS);
        });
        
        if($user->hasRole('ClaimGOP')){
            $COUNT_PENDING = $MANTIS_BUG->whereIn('status',$PENDING_LIST)->where('project_id',5)->get();
            $MANTIS_BUG = $MANTIS_BUG->whereIn('status',[9,10,14,15,16,21,22,23,50,65,66,67,68,69,100,102,103,105,115,120])
            ->where('project_id',5)->orderBy('status')->get();
        }else{
            $COUNT_PENDING = $MANTIS_BUG->whereIn('status',$PENDING_LIST)->whereNotiN('project_id',[1,4,5])->get();
            // dd($COUNT_PENDING);
            $MANTIS_BUG = $MANTIS_BUG->whereIn('status',[9,10,14,15,16,21,22,23,50,65,66,67,68,69,100,102,103,105,115,120])
            ->whereNotiN('project_id',[1,4,5])->orderBy('id','DESC')->get();
        }
        $date_check = (Carbon::now())->subDays(2);
        
        $finishNotPay = FinishAndPay::selectRaw('cl_no, claim_id, user, mantis_id, updated_at,  DATEDIFF(NOW(), updated_at) as diff_date ')
        ->where('notify',1)->where('finished',1)->where('payed',0)->where('updated_at', '<=', $date_check)->get();
        
        $AUDIT_DLVN_HBS_CPS_DIFF_AMT = AUDIT_DLVN_HBS_CPS_DIFF_AMT::all();
        
        $AUDIT_HBS_EXISTED = AUDIT_HBS_EXISTED::all();
        $AUDIT_HBS_EXISTED_BACODE = AUDIT_HBS_EXISTED_BACODE::all();
        $AUDIT_HBS_MANTIS_DIFF_POCY = AUDIT_HBS_MANTIS_DIFF_POCY::all();
        $AUDIT_HBS_MANTIS_DIFF_STATUS = AUDIT_HBS_MANTIS_DIFF_STATUS::all();
        $AUDIT_HBS_MANTIS_EXISTED_BUG_ID = AUDIT_HBS_MANTIS_EXISTED_BUG_ID::all();
        return view('home', compact('listUser','latestMessages','sentMessages','sumMember','sumClaim','sumClaimToDate', 'Ipclient','MANTIS_BUG','STATUS_COLOR_LIST','COUNT_PENDING','PENDING_LIST','finishNotPay','AUDIT_DLVN_HBS_CPS_DIFF_AMT','AUDIT_HBS_EXISTED' , 'AUDIT_HBS_EXISTED_BACODE' ,'AUDIT_HBS_MANTIS_DIFF_POCY' , 'AUDIT_HBS_MANTIS_DIFF_STATUS', 'AUDIT_HBS_MANTIS_EXISTED_BUG_ID'));
    }
}
