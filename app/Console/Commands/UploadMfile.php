<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Claim;
use App\PaymentHistory;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use App\HBS_CL_CLAIM;


class UploadMfile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UploadMfile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command UploadMfile';

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
        $now = \Carbon\Carbon::now();
        $arr_insert =[];
        $condition = function ($q) use($now) {  
            $q->where('updated_at',">=" , $now->toDateString() . " 00:00:00");
            $q->where('updated_at',"<=" , $now->toDateString() . " 23:59:59");
        };
        $PaymentHistory = \App\PaymentHistory::with(['LogMfile' => $condition])
        ->where('updated_at',">=" , $now->toDateString() . " 00:00:00")
        ->where('updated_at',"<=" , $now->toDateString() . " 23:59:59")
        ->get()->where('LogMfile',NULL)->pluck('claim_id')->toArray();
        $arr_insert = array_merge($arr_insert,$PaymentHistory);
        
        // close

        $LogUnfreezed = \App\LogUnfreezed::with(['LogMfile' => $condition])
        ->where('updated_at',">=" , $now->toDateString() . " 00:00:00")
        ->where('updated_at',"<=" , $now->toDateString() . " 23:59:59")
        ->where('reason','Close')
        ->get()->where('LogMfile',NULL)->pluck('claim_id')->toArray();
        
        $arr_insert = array_merge($arr_insert,$LogUnfreezed);

        //declined
        $MANTIS_BUG_HISTORY = \App\MANTIS_BUG_HISTORY::where('field_name', 'status') // 64 is resonstatus
        ->where('new_value', 13)
        ->where('date_modified',">=" , strtotime($now->toDateString()))
        ->pluck('bug_id')->unique()->toArray();
        $MANTIS_BUG_HISTORY = array_map(function ($item) {
            return (string)str_pad($item, 7, "0", \STR_PAD_LEFT); 
            },
            $MANTIS_BUG_HISTORY
        );
        
        
        $declined = \App\Claim::with(['LogMfile' => $condition])
        ->whereIn('barcode',$MANTIS_BUG_HISTORY)
        ->get()
        ->where('LogMfile',NULL)
        ->pluck('id')
        ->toArray();
        $arr_insert = array_merge($arr_insert,$declined);
        if(!empty($arr_insert)){
            foreach ($arr_insert as $key => $value) {
                \App\LogMfile::updateOrCreate([
                    'claim_id' => $value,
                ],[
                    'log_mfile' => 0
                ]);
            }
        }

        foreach ($arr_insert as $key => $value) {
            \App\Http\Controllers\AjaxCommonController::sendMfile($value);
        }
    }
}
