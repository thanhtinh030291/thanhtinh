<?php

namespace App\Console\Commands;
use App\Claim;
use App\PaymentHistory;
use App\FinishAndPay;
use App\MANTIS_CUSTOM_FIELD_STRING;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use App\User;

class CheckFinishAndPay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CheckFinishAndPay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dump("JoBName : CheckFinishAndPay");
        dump("start : " . Carbon::now());
        $dt = Carbon::now();
        $dt_check  = $dt->subDays(10)->format('Y-m-d h:i:s');
        $FinishAndPay = FinishAndPay::join('claim','claim.id','=','claim_id')->where('claim_type',"M")->where('notify',1)->where('finished', 0)->pluck('mantis_id')->toArray();
        
        $finished = MANTIS_CUSTOM_FIELD_STRING::whereIn('bug_id',$FinishAndPay)
        ->where('field_id', 64) // 64 is resonstatus
        ->where('value','Finished')
        ->pluck('bug_id')->toArray();
        if(!empty($finished)){
            FinishAndPay::whereIn('mantis_id',$finished)->update(['finished' => 1]);
        }
        $non_pay = FinishAndPay::where('notify',1)->where('finished', 1)->where('pay_time', 1)->where('payed', 0)->pluck('cl_no')->toArray();
        $history = PaymentHistory::whereIn('CL_NO', $non_pay)->pluck('CL_NO')->toArray();
        FinishAndPay::whereIn('cl_no', $history)->update(['payed' => 1]);

        $non_pay_many = FinishAndPay::where('notify',1)->where('finished', 1)->where('pay_time','!=', 1)->where('payed', 0)->get();
        foreach ($non_pay_many as $key => $value) {
            $t = PaymentHistory::where('claim_id', $value->claim_id)->where('PAYMENT_TIME',$value->pay_time)->count();
            if($t > 0){
                FinishAndPay::where('cl_no', $value->cl_no)->update(['payed' => 1]);
            }
        }
        
        dump("End : " . Carbon::now());
    }
}
