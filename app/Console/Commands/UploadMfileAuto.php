<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Claim;
use App\PaymentHistory;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use App\HBS_CL_CLAIM;


class UploadMfileAuto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UploadMfileAuto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command UploadMfileAuto';

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
       

        $LogUnfreezed = \App\LogMfile::where('m_errorCode',NULL)->pluck('claim_id');
        foreach ($LogUnfreezed as $key => $value) {
            \App\Http\Controllers\AjaxCommonController::sendMfile($value);
        }
    }
}
