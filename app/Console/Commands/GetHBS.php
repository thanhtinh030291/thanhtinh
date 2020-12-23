<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Claim;
use App\PaymentHistory;
use App\HBS_CL_CLAIM;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GetHBS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GetHBS';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data hbs update ClaimAss';

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
        dump("JoBName :  GetHBS");
        dump("start : " . Carbon::now());
        $payments = PaymentHistory::where('update_hbs',0)->get();
        foreach ($payments as $key => $value) {
            $HBS_CL_CLAIM = HBS_CL_CLAIM::HBSData()->where('CL_NO',$value->CL_NO)->first();
            $payments[$key]->update_hbs = 1;
            $payments[$key]->HBS = json_encode($HBS_CL_CLAIM->toArray(),true);
            $payments[$key]->save();
        }
        dump("End : " . Carbon::now());
        $this->info('Cron GetHBS Run successfully!');
    }
}
