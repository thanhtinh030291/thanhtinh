<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PaymentHistory;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class GetCPS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GetCPS';

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
        dump("JoBName : GetCPS");
        dump("start : " . Carbon::now());
        $token = getTokenCPS();
        $paym_ids = PaymentHistory::whereNotIn('TF_STATUS',[200,205,210,215,220,10])->pluck('PAYM_ID');
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'paym_ids' => json_encode($paym_ids,true),
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'get_payments' , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        $data = data_get($response, 'data');
        if (data_get($response, 'code') == "00" && data_get($response, 'data') != null) {
            $data = data_get($response, 'data');
            foreach ($data as $key => $value) {
                try {
                    DB::beginTransaction();
                    PaymentHistory::updateOrCreate([
                        'PAYM_ID' => data_get($value, "PAYM_ID"),
                    ], [
                        'ACCT_NAME' => data_get($value, "ACCT_NAME"),
                        'ACCT_NO' => data_get($value, "ACCT_NO"),
                        'BANK_NAME' => data_get($value, "BANK_NAME"),
                        'BANK_CITY' => data_get($value, "BANK_CITY"),
                        'BANK_BRANCH' => data_get($value, "BANK_BRANCH"),
                        'BENEFICIARY_NAME' => data_get($value, "BENEFICIARY_NAME"),
                        'PP_DATE' => data_get($value, "PP_DATE"),
                        'PP_PLACE' => data_get($value, "PP_PLACE"),
                        'PP_NO' => data_get($value, "PP_NO"),
                        'CL_TYPE' => data_get($value, "CL_TYPE"),
                        'BEN_TYPE' => data_get($value, "BEN_TYPE"),
                        'PAYMENT_TIME' => data_get($value, "PAYMENT_TIME"),
                        'TF_STATUS' => data_get($value, "TF_STATUS_ID"),
                        'TF_DATE' => data_get($value, "TF_DATE"),
                        
                        'VCB_SEQ' => data_get($value, "VCB_SEQ"),
                        'VCB_CODE' => data_get($value, "VCB_CODE"),
    
                        'MEMB_NAME' => data_get($value, "MEMB_NAME"),
                        'POCY_REF_NO' => data_get($value, "POCY_REF_NO"),
                        'MEMB_REF_NO' => data_get($value, "MEMB_REF_NO"),
                        'PRES_AMT' => data_get($value, "PRES_AMT"),
                        'APP_AMT' => data_get($value, "APP_AMT"),
                        'TF_AMT' => data_get($value, "TF_AMT"),
                        'DEDUCT_AMT' => data_get($value, "DEDUCT_AMT"),
                        'PAYMENT_METHOD' => data_get($value, "PAYMENT_METHOD"),
                        'MANTIS_ID' => data_get($value, "MANTIS_ID"),
                        
                    ]);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                }
            }
        }
        dump("End : " . Carbon::now());
        $this->info('Cron GetCPS Run successfully!');
        
    }
}
