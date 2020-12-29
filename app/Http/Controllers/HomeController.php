<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Claim;
use Carbon\Carbon;
use App\MANTIS_BUG;
use Redis;


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
        $listUser = User::whereNotIn('id',[Auth::User()->id])->pluck('email', 'id');
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
        
        ->whereHas('history',function ($query) use ($user) {
            $query->where('field_name', 'status');
        })
        ->whereHas('handler',function ($query) use ($user) {
            $query->where('email', $user->email);
        })
        ->whereHas('PROJECT',function ($query) use ($user) {
            $EXCLUDED_PROJECTS = array("'Gen. Inquiry'", "'Deleted'");
            $query->whereNotIn('name', $EXCLUDED_PROJECTS);
        })
        ->whereIn('status',[9,10,14,15,16,21,22,23,50,65,66,67,68,69,100,102,103,105,115,120])
        ->whereNotiN('project_id',[1,4,5])->orderBy('status')->get();
        //dd($MANTIS_BUG[0]->CUSTOM_FIELD_STRING);
        return view('home', compact('listUser','latestMessages','sentMessages','sumMember','sumClaim','sumClaimToDate', 'Ipclient','MANTIS_BUG','STATUS_COLOR_LIST'));
    }
}
