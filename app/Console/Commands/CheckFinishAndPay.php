<?php

namespace App\Console\Commands;
use App\Claim;
use App\PaymentHistory;
use App\FinishAndPay;
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
        $dt = Carbon::now();
        $dt_check  = $dt->subDays(10)->format('Y-m-d h:i:s');
        $FinishAndPay = FinishAndPay::join('claim','claim.id','=','claim_id')->where('claim_type',"M")->where('notify',1)->where('finished', 0)->pluck('mantis_id')->toArray();
        echo "số lượng ban đầu: " . count($FinishAndPay);
        $body = [
            'issue_ids' => $FinishAndPay,
        ];
        try {
            $res = PostApiMantic('api/rest/plugins/apimanagement/issues/issues_finish_status',$body);
            $res = json_decode($res->getBody(),true);
        } catch (Exception $e) {
            $user = User::where('email','tinhnguyen@pacificcross.com.vn')->first();
            $data['content_error'] = $e->getMessage();
            sendEmail($user, $data, 'templateEmail.errorTemplate' , 'LOG ERROR Hệ Thống Claim Assistant');
        }
        echo "  số lượng thay đổi: " . count($res);
        if(!empty($res)){
            FinishAndPay::whereIn('mantis_id',$res)->update(['finished' => 1]);
        }
        
        $non_pay = FinishAndPay::where('notify',1)->where('finished', 1)->where('payed', 0)->pluck('cl_no')->toArray();

        $history = PaymentHistory::whereIn('CL_NO', $non_pay)->pluck('CL_NO')->toArray();

        FinishAndPay::whereIn('cl_no', $history)->update(['payed' => 1]);

    }
}
