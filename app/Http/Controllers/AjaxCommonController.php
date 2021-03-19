<?php

namespace App\Http\Controllers;
use App\HBS_CL_CLAIM;
use App\HBS_MR_POLICY_PLAN;
use App\HBS_PV_PROVIDER;
use App\HBS_RT_DIAGNOSIS;
use App\HBS_MR_MEMBER;
use App\HBS_CL_LINE;
use App\ExportLetter;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Claim;
use App\PaymentHistory;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use App\FinishAndPay;
use App\ExtendClaim;

use Illuminate\Http\Request;

class AjaxCommonController extends Controller
{
    //validat GOP
    public function AjaxValidClaim(Request $request){
        $TYPE = $request->ben_type ? $request->ben_type : "IP";
        $HEAD = $request->ben_head ? $request->ben_head : null;
        $YEAR = $request->year ? $request->year : Carbon::now()->year;
        $DIAGCODE = $request->diag_code;
        $HBS_RT_DIAGNOSIS = HBS_RT_DIAGNOSIS::whereIn('diag_oid',$DIAGCODE)->get();
        $DIAGNOSIS = $HBS_RT_DIAGNOSIS->pluck('diag_oid')->toArray();
        $message = [];
        $id_claim = $request->id_claim;
        $claim = HBS_CL_CLAIM::IOPDiag()->findOrFail($id_claim);
        $arr_max_bf = ["vis_yr","vis_day","amt_vis","amt_yr","amt_dis_yr","amt_life","deduct_amt","copay_pct","day_dis_yr","amt_day","deduct_amt_vis","amt_dis_vis","amt_dis_life"];
    //check min max Type
        $plan_all_limit = $claim->FirstLine->MR_POLICY_PLAN->PD_PLAN->PD_PLAN_LIMIT;
        $plant_type_limits = $plan_all_limit->whereIn('limit_type',['T','CT'])->where('PD_BEN_HEAD.0.scma_oid_ben_type', 'BENEFIT_TYPE_'.$TYPE);
        $memb_ref_no = $claim->member->memb_ref_no;
        $HBS_MR_MEMBER = HBS_MR_MEMBER::where('memb_ref_no',$memb_ref_no)->get();
        $memb_oids = $HBS_MR_MEMBER->pluck('memb_oid')->toArray();

        $all_cl_line = HBS_CL_LINE::select(DB::raw("CL_LINE.* ,TO_CHAR( incur_date_from , 'YYYY') year"))
        ->with('PD_BEN_HEAD')
        ->with('RT_DIAGNOSIS')
        ->whereIn('memb_oid',$memb_oids)
        ->where('rev_date',null)
        ->where('clam_oid','!=',$id_claim)->get();
        foreach ($arr_max_bf as $max_bf) {
            $limit_types = $plant_type_limits->where($max_bf,'!=',null);
            if($limit_types->count() > 0)
            {
                
                foreach($limit_types as $key_limit_type => $value_limit_type){
                    $value_limit = data_get($value_limit_type, $max_bf);
                    switch ($max_bf) {
                        case 'vis_yr':
                            if($value_limit_type->limit_type == "T"){
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->where('PD_BEN_HEAD.scma_oid_ben_type','BENEFIT_TYPE_'.$TYPE)
                                ->groupBy('incur_date_from')->count();
                                $remain = $value_limit - $count_vis;
                                $message['T_CT']['vis_yr'] = !isset($message['T_CT']['vis_yr']) ? $remain : $remain < $message['T_CT']['vis_yr'] ?  $remain : $message['T_CT']['vis_yr'];
                            }else{
                                $BENEFIT_TYPES = $value_limit_type->PD_BEN_HEAD->pluck('scma_oid_ben_type')->toArray();
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->whereIn('PD_BEN_HEAD.scma_oid_ben_type',$BENEFIT_TYPES)
                                ->groupBy('incur_date_from')->count();
                                $remain = $value_limit - $count_vis;
                                $message['T_CT']['vis_yr'] = !isset($message['vis_yr']) ? $remain : $remain < $message['T_CT']['vis_yr'] ?  $remain : $message['T_CT']['vis_yr'];
                            }
                            
                            break;
                        case 'vis_day':
                            break;
                        case 'amt_dis_yr':
                            if($value_limit_type->limit_type == "T"){
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->where('PD_BEN_HEAD.scma_oid_ben_type','BENEFIT_TYPE_'.$TYPE)
                                ->whereIn('diag_oid',$DIAGNOSIS)
                                ->groupBy('diag_oid');
                                if($count_vis->count() == 0){
                                    collect($DIAGNOSIS)->map(function ($item, $key) use($value_limit, &$message) {
                                        $message['T_CT']['amt_dis_yr'][$item] = $value_limit;
                                    });
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    $message['T_CT']['amt_dis_yr'][$key_count_vis] = !isset($message['T_CT']['amt_dis_yr'][$key_count_vis]) ? $remain : $remain < $message['T_CT']['amt_dis_yr'][$key_count_vis] ?  $remain : $message['T_CT']['amt_dis_yr'][$key_count_vis];
                                }
                            }else{
                                $BENEFIT_TYPES = $value_limit_type->PD_BEN_HEAD->pluck('scma_oid_ben_type')->toArray();
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->whereIn('PD_BEN_HEAD.scma_oid_ben_type',$BENEFIT_TYPES)
                                ->whereIn('diag_oid',$DIAGNOSIS)
                                ->groupBy('diag_oid');
                                if($count_vis->count() == 0){
                                    collect($DIAGNOSIS)->map(function ($item, $key) use($value_limit, &$message) {
                                        $message['T_CT']['amt_dis_yr'][$item] = $value_limit;
                                    });
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    $message['T_CT']['amt_dis_yr'][$key_count_vis] = !isset($message['T_CT']['amt_dis_yr'][$key_count_vis]) ? $remain : $remain < $message['T_CT']['amt_dis_yr'][$key_count_vis] ?  $remain : $message['T_CT']['amt_dis_yr'][$key_count_vis];
                                }
                            }
                            break;
                        case 'amt_dis_life':
                        case 'amt_vis':
                            if($value_limit_type->limit_type == "T"){
                                $count_vis = $all_cl_line
                                ->where('PD_BEN_HEAD.scma_oid_ben_type','BENEFIT_TYPE_'.$TYPE)
                                ->whereIn('diag_oid',$DIAGNOSIS)
                                ->groupBy('diag_oid');
                                
                                if($count_vis->count() == 0){
                                    collect($DIAGNOSIS)->map(function ($item, $key) use($value_limit, &$message) {
                                        $message['T_CT']['amt_dis_life'][$item] = $value_limit;
                                    });
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    $message['T_CT']['amt_dis_life'][$key_count_vis] = !isset($message['T_CT']['amt_dis_life'][$key_count_vis]) ? $remain : $remain < $message['T_CT']['amt_dis_life'][$key_count_vis] ?  $remain : $message['T_CT']['amt_dis_life'][$key_count_vis];
                                }
                            }else{
                                $BENEFIT_TYPES = $value_limit_type->PD_BEN_HEAD->pluck('scma_oid_ben_type')->toArray();
                                $count_vis = $all_cl_line
                                ->whereIn('PD_BEN_HEAD.scma_oid_ben_type',$BENEFIT_TYPES)
                                ->whereIn('diag_oid',$DIAGNOSIS)
                                ->groupBy('diag_oid');
                                if($count_vis->count() == 0){
                                    collect($DIAGNOSIS)->map(function ($item, $key) use($value_limit, &$message){
                                        $message['T_CT']['amt_dis_life'][$item] = $value_limit;
                                    });
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    $message['T_CT']['amt_dis_life'][$key_count_vis] = !isset($message['T_CT']['amt_dis_life'][$key_count_vis]) ? $remain : $remain < $message['T_CT']['amt_dis_life'][$key_count_vis] ?  $remain : $message['T_CT']['amt_dis_life'][$key_count_vis];
                                }
                            }
                            break;
                        
                        case 'amt_yr':
                            if($value_limit_type->limit_type == "T"){
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->where('PD_BEN_HEAD.scma_oid_ben_type','BENEFIT_TYPE_'.$TYPE)
                                ->sum('app_amt');
                                $remain = $value_limit - $count_vis;
                                $message['T_CT']['amt_yr'] = !isset($message['T_CT']['amt_yr']) ? $remain : $remain < $message['T_CT']['amt_yr'] ?  $remain : $message['T_CT']['amt_yr'];
                            }else{
                                $BENEFIT_TYPES = $value_limit_type->PD_BEN_HEAD->pluck('scma_oid_ben_type')->toArray();
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->whereIn('PD_BEN_HEAD.scma_oid_ben_type',$BENEFIT_TYPES)
                                ->sum('app_amt');
                                $remain = $value_limit - $count_vis;
                                $message['T_CT']['amt_yr'] = !isset($message['T_CT']['amt_yr']) ? $remain : $remain < $message['T_CT']['amt_yr'] ?  $remain : $message['T_CT']['amt_yr'];
                            }
                            break;
                        case 'amt_life':
                            if($value_limit_type->limit_type == "T"){
                                $count_vis = $all_cl_line
                                ->where('PD_BEN_HEAD.scma_oid_ben_type','BENEFIT_TYPE_'.$TYPE)
                                ->sum('app_amt');
                                $remain = $value_limit - $count_vis;
                                $message['T_CT']['amt_life'] = !isset($message['T_CT']['amt_life']) ? $remain : $remain < $message['T_CT']['amt_life'] ?  $remain : $message['T_CT']['amt_life'];
                            }else{
                                $BENEFIT_TYPES = $value_limit_type->PD_BEN_HEAD->pluck('scma_oid_ben_type')->toArray();
                                $count_vis = $all_cl_line
                                ->whereIn('PD_BEN_HEAD.scma_oid_ben_type',$BENEFIT_TYPES)
                                ->sum('app_amt');
                                $remain = $value_limit - $count_vis;
                                $message['T_CT']['amt_life'] = !isset($message['T_CT']['amt_life']) ? $remain : $remain < $message['T_CT']['amt_life'] ?  $remain : $message['T_CT']['amt_life'];
                            }
                            break;
                        case 'copay_pct':
                            
                            break;
                        case 'day_dis_yr':
                            
                            break;
                        case 'amt_day':
                            if($value_limit_type->limit_type == "T"){
                                $remain = $value_limit;
                                $message['T_CT']['amt_day'] = !isset($message['T_CT']['amt_day']) ? $remain : $remain < $message['T_CT']['amt_day'] ?  $remain : $message['T_CT']['amt_day'];
                            }else{
                                $remain = $value_limit ;
                                $message['T_CT']['amt_day'] = !isset($message['T_CT']['amt_day']) ? $remain : $remain < $message['T_CT']['amt_day'] ?  $remain : $message['T_CT']['amt_day'];
                            }
                            break;
                        case  'amt_dis_vis':
                            break;
                        case 'deduct_amt_vis':
                            if($value_limit_type->limit_type == "T"){
                                $remain = $value_limit;
                                $message['T_CT']['deduct_amt_vis'] = !isset($message['T_CT']['deduct_amt_vis']) ? $remain : $remain < $message['T_CT']['deduct_amt_vis'] ?  $remain : $message['T_CT']['deduct_amt_vis'];
                            }else{
                                $remain = $value_limit ;
                                $message['T_CT']['deduct_amt_vis'] = !isset($message['T_CT']['deduct_amt_vis']) ? $remain : $remain < $message['T_CT']['deduct_amt_vis'] ?  $remain : $message['T_CT']['deduct_amt_vis'];
                            }
                            break;
                        case 'deduct_amt':
                            if($value_limit_type->limit_type == "T"){
                                $remain = $value_limit;
                                $message['T_CT']['deduct_amt'] = !isset($message['T_CT']['deduct_amt']) ? $remain : $remain < $message['T_CT']['deduct_amt'] ?  $remain : $message['T_CT']['deduct_amt'];
                            }else{
                                $remain = $value_limit ;
                                $message['T_CT']['deduct_amt'] = !isset($message['T_CT']['deduct_amt']) ? $remain : $remain < $message['T_CT']['deduct_amt'] ?  $remain : $message['T_CT']['deduct_amt'];
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                }
                
            }

        }
    //end check type
    //check min max Head
        $plan_all_limit = $claim->FirstLine->MR_POLICY_PLAN->PD_PLAN->PD_PLAN_LIMIT;
        $plant_type_limits = $plan_all_limit->whereIn('limit_type',['H','CH'])->where('PD_BEN_HEAD.0.scma_oid_ben_type', 'BENEFIT_TYPE_'.$TYPE);
        foreach ($arr_max_bf as $max_bf) {
            $limit_types = $plant_type_limits->where($max_bf,'!=',null);
            if($limit_types->count() > 0)
            {
                foreach($limit_types as $key_limit_type => $value_limit_type){
                    $value_limit = data_get($value_limit_type, $max_bf);
                    $head = $value_limit_type->PD_BEN_HEAD->first()->ben_head;
                    switch ($max_bf) {
                        case 'vis_yr':
                            break;
                        case 'vis_day':
                            break;
                        case 'amt_dis_yr':
                            if ($value_limit_type->limit_type == "H") {
                                $count_vis = $all_cl_line->where('year', $YEAR)
                                ->where('PD_BEN_HEAD.scma_oid_ben_type', 'BENEFIT_TYPE_'.$TYPE)
                                ->where('PD_BEN_HEAD.ben_head', $head)
                                ->whereIn('diag_oid', $DIAGNOSIS)
                                ->groupBy('diag_oid');
                                if ($count_vis->count() == 0) {
                                    collect($DIAGNOSIS)->map(function ($item, $key) use ($value_limit, &$message , $head) {
                                        $message['H_CH']['amt_dis_yr'][$item][$head] = $value_limit;
                                    });
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    $message['H_CH']['amt_dis_yr'][$key_count_vis][$head] = !isset($message['H_CH']['amt_dis_yr'][$key_count_vis][$head]) ? $remain : $remain < $message['H_CH']['amt_dis_yr'][$key_count_vis][$head] ?  $remain : $message['H_CH']['amt_dis_yr'][$key_count_vis][$head];
                                }
                            }else{
                                $plant_type_ch = $value_limit_type->PD_BEN_HEAD->pluck('ben_head')->toArray();
                                
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->where('PD_BEN_HEAD.scma_oid_ben_type',"BENEFIT_TYPE_".$TYPE)
                                ->whereIn('PD_BEN_HEAD.ben_head', $plant_type_ch)
                                ->whereIn('diag_oid',$DIAGNOSIS)
                                ->groupBy('diag_oid');
                                if ($count_vis->count() == 0) {
                                    collect($DIAGNOSIS)->map(function ($item, $key) use ($value_limit, &$message , $head , $plant_type_ch) {
                                        foreach ($plant_type_ch as $keych => $valuech) {
                                            $message['H_CH']['amt_dis_life'][$item][$valuech] = $value_limit;
                                        }
                                    });
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    foreach ($plant_type_ch as $key_head => $value_head) {
                                        $message['H_CH']['amt_dis_yr'][$key_count_vis][$value_head] = !isset($message['H_CH']['amt_dis_yr'][$key_count_vis][$value_head]) ? $remain : $remain < $message['H_CH']['amt_dis_yr'][$key_count_vis][$value_head] ?  $remain : $message['H_CH']['amt_dis_yr'][$key_count_vis][$value_head];
                                    }
                                }
                            }
                            break;
                        case 'amt_dis_life':
                            if ($value_limit_type->limit_type == "H") {
                                $count_vis = $all_cl_line
                                ->where('PD_BEN_HEAD.scma_oid_ben_type', 'BENEFIT_TYPE_'.$TYPE)
                                ->where('PD_BEN_HEAD.ben_head', $head)
                                ->whereIn('diag_oid', $DIAGNOSIS)
                                ->groupBy('diag_oid');
                                if ($count_vis->count() == 0) {
                                    collect($DIAGNOSIS)->map(function ($item, $key) use ($value_limit, &$message , $head) {
                                        $message['H_CH']['amt_dis_life'][$item][$head] = $value_limit;
                                    });
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    $message['H_CH']['amt_dis_life'][$key_count_vis][$head] = !isset($message['H_CH']['amt_dis_life'][$key_count_vis][$head]) ? $remain : $remain < $message['H_CH']['amt_dis_life'][$key_count_vis][$head] ?  $remain : $message['H_CH']['amt_dis_life'][$key_count_vis][$head];
                                }
                            }else{
                                $plant_type_ch = $value_limit_type->PD_BEN_HEAD->pluck('ben_head')->toArray();
                                
                                $count_vis = $all_cl_line
                                ->where('PD_BEN_HEAD.scma_oid_ben_type',"BENEFIT_TYPE_".$TYPE)
                                ->whereIn('PD_BEN_HEAD.ben_head', $plant_type_ch)
                                ->whereIn('diag_oid',$DIAGNOSIS)
                                ->groupBy('diag_oid');
                                if ($count_vis->count() == 0) {
                                    collect($DIAGNOSIS)->map(function ($item, $key) use ($value_limit, &$message , $head , $plant_type_ch) {
                                        foreach ($plant_type_ch as $keych => $valuech) {
                                            $message['H_CH']['amt_dis_life'][$item][$valuech] = $value_limit;
                                        }
                                    });
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    foreach ($plant_type_ch as $key_head => $value_head) {
                                        $message['H_CH']['amt_dis_life'][$key_count_vis][$value_head] = !isset($message['H_CH']['amt_dis_life'][$key_count_vis][$value_head]) ? $remain : $remain < $message['H_CH']['amt_dis_life'][$key_count_vis][$value_head] ?  $remain : $message['H_CH']['amt_dis_life'][$key_count_vis][$value_head];
                                    }
                                }
                                
                            }
                        case 'amt_vis':
                            
                            break;
                        
                        case 'amt_yr':
                            if ($value_limit_type->limit_type == "H") {
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->where('PD_BEN_HEAD.scma_oid_ben_type', 'BENEFIT_TYPE_'.$TYPE)
                                ->where('PD_BEN_HEAD.ben_head', $head)
                                ->groupBy('diag_oid');
                                if ($count_vis->count() == 0) {
                                    $message['H_CH']['amt_yr'][$head] = $value_limit;
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    $message['H_CH']['amt_yr'][$head] = !isset($message['H_CH']['amt_yr'][$head]) ? $remain : $remain < $message['H_CH']['amt_yr'][$head] ?  $remain : $message['H_CH']['amt_yr'][$head];
                                }
                            }else{
                                $plant_type_ch = $value_limit_type->PD_BEN_HEAD->pluck('ben_head')->toArray();
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->where('PD_BEN_HEAD.scma_oid_ben_type',"BENEFIT_TYPE_".$TYPE)
                                ->whereIn('PD_BEN_HEAD.ben_head', $plant_type_ch)
                                ->groupBy('diag_oid');
                                if ($count_vis->count() == 0) {
                                    foreach ($plant_type_ch as $keych => $valuech) {
                                        $message['H_CH']['amt_yr'][$valuech] = $value_limit;
                                    }
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    foreach ($plant_type_ch as $key_head => $value_head) {
                                        $message['H_CH']['amt_yr'][$value_head] = !isset($message['H_CH']['amt_yr'][$value_head]) ? $remain : $remain < $message['H_CH']['amt_yr'][$value_head] ?  $remain : $message['H_CH']['amt_yr'][$value_head];
                                    }
                                }
                            }
                            break;
                        case 'amt_life':
                            if ($value_limit_type->limit_type == "H") {
                                $count_vis = $all_cl_line
                                ->where('PD_BEN_HEAD.scma_oid_ben_type', 'BENEFIT_TYPE_'.$TYPE)
                                ->where('PD_BEN_HEAD.ben_head', $head)
                                ->groupBy('diag_oid');
                                if ($count_vis->count() == 0) {
                                    $message['H_CH']['amt_life'][$head] = $value_limit;
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    $message['H_CH']['amt_life'][$head] = !isset($message['H_CH']['amt_life'][$head]) ? $remain : $remain < $message['H_CH']['amt_life'][$head] ?  $remain : $message['H_CH']['amt_life'][$head];
                                }
                            }else{
                                $plant_type_ch = $value_limit_type->PD_BEN_HEAD->pluck('ben_head')->toArray();
                                $count_vis = $all_cl_line
                                ->where('PD_BEN_HEAD.scma_oid_ben_type',"BENEFIT_TYPE_".$TYPE)
                                ->whereIn('PD_BEN_HEAD.ben_head', $plant_type_ch)
                                ->groupBy('diag_oid');
                                if ($count_vis->count() == 0) {
                                    foreach ($plant_type_ch as $keych => $valuech) {
                                        $message['H_CH']['amt_life'][$valuech] = $value_limit;
                                    }
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('app_amt');
                                    foreach ($plant_type_ch as $key_head => $value_head) {
                                        $message['H_CH']['amt_life'][$value_head] = !isset($message['H_CH']['amt_life'][$value_head]) ? $remain : $remain < $message['H_CH']['amt_life'][$value_head] ?  $remain : $message['H_CH']['amt_life'][$value_head];
                                    }
                                }
                            }
                            break;
                        case 'copay_pct':
                            
                            break;
                        case 'day_dis_yr':
                            if ($value_limit_type->limit_type == "H") {
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->where('PD_BEN_HEAD.scma_oid_ben_type', 'BENEFIT_TYPE_'.$TYPE)
                                ->where('PD_BEN_HEAD.ben_head', $head)
                                ->groupBy('diag_oid');
                                if ($count_vis->count() == 0) {
                                    $message['H_CH']['day_dis_yr'][$head] = $value_limit;
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('days');
                                    $message['H_CH']['day_dis_yr'][$head] = !isset($message['H_CH']['day_dis_yr'][$head]) ? $remain : $remain < $message['H_CH']['day_dis_yr'][$head] ?  $remain : $message['H_CH']['day_dis_yr'][$head];
                                }
                            }else{
                                $plant_type_ch = $value_limit_type->PD_BEN_HEAD->pluck('ben_head')->toArray();
                                $count_vis = $all_cl_line->where('year',$YEAR)
                                ->where('PD_BEN_HEAD.scma_oid_ben_type',"BENEFIT_TYPE_".$TYPE)
                                ->whereIn('PD_BEN_HEAD.ben_head', $plant_type_ch)
                                ->groupBy('diag_oid');
                                if ($count_vis->count() == 0) {
                                    foreach ($plant_type_ch as $keych => $valuech) {
                                        $message['H_CH']['day_dis_yr'][$valuech] = $value_limit;
                                    }
                                }
                                foreach ($count_vis as $key_count_vis => $value_count_vis) {
                                    $remain = $value_limit - $value_count_vis->sum('days');
                                    foreach ($plant_type_ch as $key_head => $value_head) {
                                        $message['H_CH']['day_dis_yr'][$value_head] = !isset($message['H_CH']['day_dis_yr'][$value_head]) ? $remain : $remain < $message['H_CH']['day_dis_yr'][$value_head] ?  $remain : $message['H_CH']['day_dis_yr'][$value_head];
                                    }
                                }
                            }
                            break;
                        case 'amt_day':
                            if ($value_limit_type->limit_type == "H") {

                                $remain = $value_limit;
                                $message['H_CH']['amt_day'][$head] = !isset($message['H_CH']['amt_day'][$head]) ? $remain : $remain < $message['H_CH']['amt_day'][$head] ?  $remain : $message['H_CH']['amt_day'][$head];

                            }else{
                                $plant_type_ch = $value_limit_type->PD_BEN_HEAD->pluck('ben_head')->toArray();
                                $plant_type_ch_string = implode("-",$plant_type_ch);
                                $remain = $value_limit ;
                                foreach ($plant_type_ch as $key_head => $value_head) {
                                    $message['H_CH']['amt_day'][$value_head] = !isset($message['H_CH']['amt_day'][$value_head]) ? $remain : $remain < $message['H_CH']['amt_day'][$value_head] ?  $remain : $message['H_CH']['amt_day'][$value_head];
                                }
                                $message['H_CH']['amt_day'][$plant_type_ch_string] = $remain;
                                
                            }
                            break;
                        case  'amt_dis_vis':
                            if ($value_limit_type->limit_type == "H") {

                                $remain = $value_limit;
                                $message['H_CH']['amt_dis_vis'][$head] = !isset($message['H_CH']['amt_dis_vis'][$head]) ? $remain : $remain < $message['H_CH']['amt_dis_vis'][$head] ?  $remain : $message['H_CH']['amt_dis_vis'][$head];

                            }else{
                                $plant_type_ch = $value_limit_type->PD_BEN_HEAD->pluck('ben_head')->toArray();
                                $plant_type_ch_string = implode("-",$plant_type_ch);
                                $remain = $value_limit ;
                                foreach ($plant_type_ch as $key_head => $value_head) {
                                    $message['H_CH']['amt_dis_vis'][$value_head] = !isset($message['H_CH']['amt_dis_vis'][$value_head]) ? $remain : $remain < $message['H_CH']['amt_dis_vis'][$value_head] ?  $remain : $message['H_CH']['amt_dis_vis'][$value_head];
                                }
                                $message['H_CH']['amt_dis_vis'][$plant_type_ch_string] = $remain;
                                
                            }
                            break;
                        case 'deduct_amt_vis':
                            
                            break;
                        case 'deduct_amt':
                            
                            break;
                        default:
                            # code...
                            break;
                    }
                }
                
            }
            
        }
    //end check head
        foreach ($arr_max_bf as $max_bf){
            switch ($max_bf) {
                case 'vis_yr':
                    if( isset($message['T_CT']['vis_yr'])){
                        $message['T_CT']['vis_yr'] = [
                            'max_limit' => $message['T_CT']['vis_yr'] ,
                            'message'     => "Giới Hạn (số lần thăm khám) yêu cầu bồi thường cho ({$TYPE}) còn lại trong năm {$YEAR} là : {$message['T_CT']['vis_yr']} ." ,
                        ];
                    }
                    if( isset($message['H_CH']['vis_yr'])){
                        $message['H_CH']['vis_yr'] = [
                            'max_limit' => $message['H_CH']['vis_yr'] ,
                            'message'     => "Giới Hạn (số lần thăm khám) yêu cầu bồi thường cho ({$TYPE}) còn lại trong năm {$YEAR} là : {$message['H_CH']['vis_yr']} ." ,
                        ];
                    }
                    break;
                case 'vis_day':
                    if( isset($message['T_CT']['vis_day'])){
                        $message['T_CT']['vis_day'] = [
                            'max_limit' => $message['T_CT']['vis_day'] ,
                            'message'     => "Giới Hạn (số lần nhập Viện) yêu cầu bồi thường cho ({$TYPE} còn lại trong Ngày là : {$message['T_CT']['vis_yr']} ." ,
                        ];
                    }
                    if( isset($message['H_CH']['vis_day'])){
                        $message['H_CH']['vis_day'] = [
                            'max_limit' => $message['H_CH']['vis_day'] ,
                            'message'     => "Giới Hạn (số lần nhập Viện) yêu cầu bồi thường cho ({$TYPE} còn lại trong Ngày là : {$message['H_CH']['vis_yr']} ." ,
                        ];
                    }
                break;
                case 'amt_dis_yr':
                    if( isset($message['T_CT']['amt_dis_yr'])){
                        foreach ($message['T_CT']['amt_dis_yr'] as $key => $value) {
                            $name_diag = $HBS_RT_DIAGNOSIS->where('diag_oid',$key)->first()->diag_desc_vn;
                            $format_value = formatPrice($value);
                            $message['T_CT']['amt_dis_life'][$key] = [
                                'max_limit' => $value ,
                                'message'     => "Giới Hạn (số tiền) yêu cầu bồi thường cho bệnh ({$name_diag})-({$TYPE}) còn lại trong Năm là : {$format_value} ." 
                            ];
                        }
                    }
                    if( isset($message['H_CH']['amt_dis_yr'])){
                        foreach ($message['H_CH']['amt_dis_yr'] as $key => $value) {
                            $name_diag = $HBS_RT_DIAGNOSIS->where('diag_oid',$key)->first()->diag_desc_vn;
                            foreach ($value as $key2 => $value2) {
                                $format_value = formatPrice($value2);
                                $message['H_CH']['amt_dis_yr'][$key][$key2] = [
                                    'max_limit' =>  $value2 ,
                                    'message'     => "Giới Hạn (số tiền) yêu cầu bồi thường cho ({$key2})-({$name_diag})-({$TYPE}) còn lại trong Năm là : {$format_value} ." ,
                                ];
                            }
                        }
                    }
                break;
                case 'amt_dis_life':
                    if( isset($message['T_CT']['amt_dis_life'])){
                        foreach ($message['T_CT']['amt_dis_life'] as $key => $value) {
                            $name_diag = $HBS_RT_DIAGNOSIS->where('diag_oid',$key)->first()->diag_desc_vn;
                            $format_value = formatPrice($value);
                            $message['T_CT']['amt_dis_life'][$key] = [
                                'max_limit' => $value ,
                                'message'     =>  "Giới Hạn (số tiền) yêu cầu bồi thường cho bệnh ({$name_diag}) ({$TYPE}) còn lại  là : {$format_value} ."
                            ];
                        }
                    }
                    if( isset($message['H_CH']['amt_dis_life'])){
                        foreach ($message['H_CH']['amt_dis_life'] as $key => $value) {
                            $name_diag = $HBS_RT_DIAGNOSIS->where('diag_oid',$key)->first()->diag_desc_vn;
                            foreach ($value as $key2 => $value2) {
                                $format_value = formatPrice($value2);
                                $message['H_CH']['amt_dis_life'][$key][$key2] = [
                                    'max_limit' =>  $value2 ,
                                    'message'     => "Giới Hạn (số tiền) yêu cầu bồi thường cho ({$key2})-({$name_diag})-({$TYPE}) còn lại là : {$format_value} ." ,
                                ];
                            }
                        }
                    }
                break;
                case 'amt_vis':
                    if( isset($message['T_CT']['amt_vis'])){
                        $format_value = formatPrice($message['T_CT']['amt_vis']);
                        $message['T_CT']['amt_vis'] = [
                            'max_limit' => $message['T_CT']['amt_vis'] ,
                            'message'     => "Giới Hạn (số tiền)  yêu cầu bồi thường mỗi lần thăm khám cho ({$TYPE}) là : {$format_value} ." ,
                        ];
                    }
                break;
                case 'amt_yr':
                    if( isset($message['T_CT']['amt_yr'])){
                        $format_value = formatPrice($message['T_CT']['amt_yr']);
                        $message['T_CT']['amt_yr'] = [
                            'max_limit' => $message['T_CT']['amt_yr'] ,
                            'message'     => "Giới Hạn (số tiền)  yêu cầu bồi thường cho ({$TYPE}) trong năm là : {$format_value} ." ,
                        ];
                    }
                    break;
                case 'amt_life':
                    if( isset($message['T_CT']['amt_life'])){
                        $format_value = formatPrice($message['T_CT']['amt_life']);
                        $message['T_CT']['amt_life'] = [
                            'max_limit' => $message['T_CT']['amt_life'] ,
                            'message'     => "Giới Hạn (số tiền)  yêu cầu bồi thường cho ({$TYPE}) là : {$format_value} ." ,
                        ];
                    }
                    if( isset($message['H_CH']['amt_life'])){
                        foreach ($message['H_CH']['amt_life'] as $key => $value) {
                            $format_value = formatPrice($value);
                            $message['H_CH']['amt_life'][$key] = [
                                'max_limit' =>  $value ,
                                'message'     => "Giới Hạn (số tiền) yêu cầu bồi thường cho ({$key})-({$TYPE}) còn lại là : {$format_value} ." ,
                            ];
                        }
                    }
                    break;
                case 'copay_pct':
                    
                    break;
                case 'day_dis_yr':
                    if( isset($message['H_CH']['day_dis_yr'])){
                        foreach ($message['H_CH']['day_dis_yr'] as $key => $value) {
                            $format_value = formatPrice($value);
                            $message['H_CH']['day_dis_yr'][$key] = [
                                'max_limit' =>  $value ,
                                'message'     => "Giới Hạn (số ngày) yêu cầu bồi thường cho ({$key})-({$TYPE}) còn lại là : {$format_value} ." ,
                            ];
                        }
                    }
                    break;
                case 'amt_day':
                    if( isset($message['T_CT']['amt_day'])){
                        $format_value = formatPrice($message['T_CT']['amt_day']);
                        $message['T_CT']['amt_day'] = [
                            'max_limit' => $message['T_CT']['amt_day'] ,
                            'message'     => "Giới Hạn (số tiền)  yêu cầu bồi thường cho ({$TYPE}) mỗi ngày là : {$format_value} ." ,
                        ];
                    }
                    if( isset($message['H_CH']['amt_day'])){
                        foreach ($message['H_CH']['amt_day'] as $key => $value) {
                            $format_value = formatPrice($value);
                            $message['H_CH']['amt_day'][$key] = [
                                'max_limit' =>  $value ,
                                'message'     => "Giới Hạn (số tiền) yêu cầu bồi thường cho ({$key})-({$TYPE}) còn lại là : {$format_value} ." ,
                            ];
                        }
                    }
                    break;
                case  'amt_dis_vis':
                    if( isset($message['H_CH']['amt_dis_vis'])){
                        foreach ($message['H_CH']['amt_dis_vis'] as $key => $value) {
                            $format_value = formatPrice($value);
                            $message['H_CH']['amt_dis_vis'][$key] = [
                                'max_limit' =>  $value ,
                                'message'     => "Giới Hạn (số tiền) yêu cầu bồi thường cho ({$key})-({$TYPE}) (/mỗi bệnh / mỗi lần khám )còn lại là : {$format_value} ." ,
                            ];
                        }
                    }
                    break;
                case 'deduct_amt':
                    if( isset($message['T_CT']['deduct_amt'])){
                        $format_value = formatPrice($message['T_CT']['deduct_amt']);
                        $message['T_CT']['deduct_amt'] = [
                            'min_limit' => $message['deduct_amt']['amt_day'] ,
                            'message'     => "Giới Hạn (số tiền)  yêu cầu bồi thường cho ({$TYPE}) phải lớn hơn : {$format_value} ." ,
                        ];
                    }
                    break;
                case 'deduct_amt_vis':
                    if( isset($message['T_CT']['deduct_amt_vis'])){
                        $format_value = formatPrice($message['T_CT']['deduct_amt_vis']);
                        $message['T_CT']['deduct_amt_vis'] = [
                            'min_limit' => $message['deduct_amt_vis']['amt_day'] ,
                            'message'     => "Giới Hạn (số tiền)  yêu cầu bồi thường cho ({$TYPE}) phải lớn hơn : {$format_value} ." ,
                        ];
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        return $message;
        
    }
    //ajax load ID claim auto complate 
    public function dataAjaxHBSClaim(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $datas = HBS_CL_CLAIM::where('cl_no','LIKE',"%$search%")
                    ->select('clam_oid as id', 'cl_no as text')
                    ->limit(20)->get();
            return response()->json($datas);
        }
        return response()->json($data);
    }

    public function dataAjaxHBSGOPClaim(Request $request)
    {
        $data = [];
        $conditionGOP = function($q) {
            $q->where('SCMA_OID_CL_TYPE', 'CL_TYPE_P');
        };
        if($request->has('q')){
            $search = $request->q;
            $datas = HBS_CL_CLAIM::where('cl_no','LIKE',"%$search%")
                    ->whereHas('HBS_CL_LINE' ,$conditionGOP)
                    ->select('clam_oid as id', 'cl_no as text')
                    ->limit(20)->get();
            return response()->json($datas);
        }
        return response()->json($data);
    }

    public function dataAjaxHBSDiagnosis(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = mb_strtolower($request->q);
            $datas = HBS_RT_DIAGNOSIS::where('diag_desc_vn','LIKE',"%$search%")->orWhere('diag_code','LIKE',"%$search%")
                    ->select(DB::raw("diag_oid  as id, diag_code ||'-'|| diag_desc_vn as text"))
                    ->limit(100)->get();
            
            
            return response()->json($datas);
        }
        return response()->json($data);
    }

    public function dataAjaxHBSProvByClaim($claim_oid){
        $data = HBS_CL_CLAIM::findOrFail($claim_oid)->provider;
        return response()->json($data);
    }

    //ajax load provider
    public function dataAjaxHBSProv(Request $request)
    {
        $data = [];
        if($request->has('q')){
            $search = mb_strtoupper($request->q);
            $datas = HBS_PV_PROVIDER::where('prov_name','LIKE',"%$search%")
                    ->select('prov_oid as id', 'prov_name as text')
                    ->limit(50)->get();
            return response()->json($datas);
        }
        return response()->json($data);
    }
    
    // jax load info of claim
    public function loadInfoAjaxHBSClaim(Request $request)
    {  
        
        $data = [];
        if($request->has('search')){
            $search = $request->search;
            $datas = HBS_CL_CLAIM::findOrFail($search);
            return response()->json(['member' => $datas->member , 'claim' =>$datas ]);
        }
        return response()->json($data);
    }

    //ajax load ID claim auto complate HAVE benhead is RB
    public function dataAjaxHBSClaimRB(Request $request)
    {
        
        $data = [];
        if($request->has('q')){
            $search = $request->q;
            $conditionBenHead = function($q) {
                $q->where('BEN_HEAD', 'RB');
            };
            $condition = function($q) use ($conditionBenHead){
                $q->whereHas('PD_BEN_HEAD', $conditionBenHead);
            };
            $datas = HBS_CL_CLAIM::where('cl_no','LIKE',"%$search%")
                    ->whereHas("HBS_CL_LINE", $condition)
                    ->select('clam_oid as id', 'cl_no as text')
                    ->limit(20)->get();
            return response()->json($datas);
        }
        return response()->json($data);
    }
    // jax load info of claim RB
    public function loadInfoAjaxHBSClaimRB(Request $request)
    {  
        
        $data = [];
        if($request->has('search')){
            $search = $request->search;
            $datas = HBS_CL_CLAIM::findOrFail($search)->member;
            
            $conditionBenHead = function($q) {
                $q->where('BEN_HEAD', 'RB');
            };
            $condition = function($q) use ($conditionBenHead){
                $q->whereHas('PD_BEN_HEAD', $conditionBenHead);
                $q->where('scma_oid_cl_line_status','!=','CL_LINE_STATUS_RV');
            };
            $data2 = HBS_CL_CLAIM::with(['HBS_CL_LINE' => $condition])->findOrFail($search)->HBS_CL_LINE->toArray();
            foreach ($data2 as $key => $value) {
                $incurDate = Carbon::parse($value['incur_date_from'])->format('d/m/Y') .' 00:00 - '. Carbon::parse($value['incur_date_to'])->format('d/m/Y') . " 23:59";
                $data2[$key]['incur_date'] = $incurDate;
            }
            $data['HBS_CL_CLAIM'] = $datas;
            $data['HBS_CL_LINE'] = $data2;
            return response()->json($data);
        }
        return response()->json($data);
    }

    // checkRoomBoard
    public function checkRoomBoard(Request $request){
        $data = [];
        if($request->has('search')){
            $search = $request->search;
            $conditionHasBenHead = function($q) {
                $q->where('scma_oid_ben_type', 'BENEFIT_TYPE_IP');
                $q->where('ben_head', 'RB');
            };

            $conditionPlanLimit = function($q) use ($conditionHasBenHead){
                $q->whereHas('PD_BEN_HEAD',$conditionHasBenHead);
            };

            $condition = function($q) use ($conditionPlanLimit){
                $q->with(['PD_PLAN_LIMIT' => $conditionPlanLimit]);
            };
            $datas = HBS_MR_POLICY_PLAN::with(['PD_PLAN' => $condition])
            ->findOrFail($search);
            return response()->json($datas->PD_PLAN->PD_PLAN_LIMIT[0]);
        }
        return response()->json($data);
    }

    // getPaymentHistory mantic
    public static function getPaymentHistory($cl_no){
        $data = GetApiMantic('api/rest/plugins/apimanagement/issues/'. $cl_no);
        $claim = Claim::where('code_claim_show',  $cl_no)->first();
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $approve_amt = $HBS_CL_CLAIM->sumAppAmt;
        return response()->json([ 'data' => $data, 'approve_amt' => $approve_amt]);
    }
    // get  payment of claim  CPS

    public static function getPaymentHistoryCPS($cl_no){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'get_payment/'. $cl_no , ['form_params'=>$body]);
        
        $response =  json_decode($response->getBody()->getContents());
        $response_full = collect($response)->where('TF_STATUS_NAME','!=', "NEW")->where('TF_STATUS_NAME','!=', "DELETED");
        $response = collect($response)->where('TF_STATUS_NAME','!=', "NEW")->where('TF_STATUS_NAME','!=', "DELETED");
            
        $claim = Claim::where('code_claim_show',  $cl_no)->first();
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $approve_amt = $HBS_CL_CLAIM->sumAppAmt;
        $present_amt = $HBS_CL_CLAIM->sumPresAmt;
        $payment_method = str_replace("CL_PAY_METHOD_","",$HBS_CL_CLAIM->payMethod);
        $payment_method = $payment_method == 'CA' ? "CH" : $payment_method;
        $pocy_ref_no = data_get($HBS_CL_CLAIM->Police,'pocy_ref_no');
        $memb_ref_no = $HBS_CL_CLAIM->member->memb_ref_no;
        $member_name = $HBS_CL_CLAIM->memberNameCap;
        return response()->json([ 'data' => $response,
                                'data_full' => $response_full,
                                'approve_amt' => round($approve_amt) , 
                                'present_amt' => round($present_amt) ,
                                'payment_method' => $payment_method,
                                'pocy_ref_no' => $pocy_ref_no,
                                'memb_ref_no' => $memb_ref_no,
                                'member_name' => $member_name,
                            ]);
    }
    // get  Balance of claim  CPS 
    public static function getBalanceCPS($mem_ref_no , $cl_no){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'get_client_debit/'. $mem_ref_no , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        /*
            There are 4 types:
            -	1: nợ được đòi lại
            -	2: nợ nhưng đã cấn trừ qua Claim khác
            -	3: nợ nhưng khách hàng đã gửi trả lại
            -	4: nợ không được đòi lại
        */
        if (empty($response)){
            $data =[
                'PCV_EXPENSE' => 0,
                'DEBT_BALANCE' => 0
            ];
            $data_full =[];
        }else{
            $colect_data = collect($response);
            $data =[
                'PCV_EXPENSE' => $colect_data->where('DEBT_CL_NO', $cl_no)->sum('PCV_EXPENSE'),
                'DEBT_BALANCE' => $colect_data->sum('DEBT_BALANCE')
            ];
            $data_full = collect($response);
        }

        return response()->json([ 'data' => $data , 'data_full' =>  $data_full]);
    }
    
    
    public static function setPcvExpense($paym_id, $pcv_expense){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'pcv_expense' => $pcv_expense,
            'username'    => Auth::user()->name
        ];

        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'set_pcv_expense/'. $paym_id , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function sendPayment($request, $id_claim){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'memb_name' => $request->memb_name,
            'pocy_ref_no' => $request->pocy_ref_no,
            'memb_ref_no' => $request->memb_ref_no,
            'pres_amt' => $request->pres_amt,
            'app_amt' => $request->app_amt,
            'tf_amt' => $request->tf_amt,
            'deduct_amt' => $request->deduct_amt,
            'payment_method' => $request->payment_method,
            'mantis_id' => $request->mantis_id,
            'username'    => 'claimassistant'
        ];
        
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'send_payment/'. $request->cl_no , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        $rs=data_get($response,'code');
        if(data_get($response,'code') == "00" && data_get($response,'data') != null){
            try {
                DB::beginTransaction();
                PaymentHistory::updateOrCreate([
                    'PAYM_ID' => data_get($response, "data.PAYM_ID"),
                    'CL_NO' => data_get($response, "data.CL_NO"),
                ], [
                    'ACCT_NAME' => data_get($response, "data.ACCT_NAME"),
                    'ACCT_NO' => data_get($response, "data.ACCT_NO"),
                    'BANK_NAME' => data_get($response, "data.BANK_NAME"),
                    'BANK_CITY' => data_get($response, "data.BANK_CITY"),
                    'BANK_BRANCH' => data_get($response, "data.BANK_BRANCH"),
                    'BENEFICIARY_NAME' => data_get($response, "data.BENEFICIARY_NAME"),
                    'PP_DATE' => data_get($response, "data.PP_DATE"),
                    'PP_PLACE' => data_get($response, "data.PP_PLACE"),
                    'PP_NO' => data_get($response, "data.PP_NO"),
                    'CL_TYPE' => data_get($response, "data.CL_TYPE"),
                    'BEN_TYPE' => data_get($response, "data.BEN_TYPE"),
                    'PAYMENT_TIME' => data_get($response, "data.PAYMENT_TIME"),
                    'TF_STATUS' => data_get($response, "data.TF_STATUS_ID"),
                    'TF_DATE' => data_get($response, "data.TF_DATE"),
                    
                    'VCB_SEQ' => data_get($response, "data.VCB_SEQ"),
                    'VCB_CODE' => data_get($response, "data.VCB_CODE"),

                    'MEMB_NAME' => data_get($response, "data.MEMB_NAME"),
                    'POCY_REF_NO' => data_get($response, "data.POCY_REF_NO"),
                    'MEMB_REF_NO' => data_get($response, "data.MEMB_REF_NO"),
                    'PRES_AMT' => data_get($response, "data.PRES_AMT"),
                    'APP_AMT' => data_get($response, "data.APP_AMT"),
                    'TF_AMT' => data_get($response, "data.TF_AMT"),
                    'DEDUCT_AMT' => data_get($response, "data.DEDUCT_AMT"),
                    'PAYMENT_METHOD' => data_get($response, "data.PAYMENT_METHOD"),
                    'PAYMENT_METHOD' => data_get($response, "data.PAYMENT_METHOD"),
                    'MANTIS_ID' => data_get($response, "data.MANTIS_ID"),

                    'update_file' => 0,
                    'update_hbs' => 0,
                    'updated_user' => Auth::user()->id,
                    'created_user' => Auth::user()->id,
                    'notify_renew' => 0,
                    'reason_renew' => null,
                    'claim_id' => $id_claim,
                ]);
                DB::commit();
            } catch (Exception $e) {
                Log::error(generateLogMsg($e));
                DB::rollback();
            }
        }
        return $response;
    }

    public static function setDebt($debt_id){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'username'    => Auth::user()->name
        ];
        
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'set_debt/'. $debt_id , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        return $response;
    }

    public static function payDebt($request , $paid_amt){
        $token = getTokenCPS();
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            'access_token' => $token,
            'paid_amt' => $paid_amt,
            'username'    => Auth::user()->name,
            'cl_no' => $request->cl_no,
            'memb_name' => $request->memb_name,
        ];
        
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.api_cps').'pay_debt/'. $request->memb_ref_no , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        return $response;
    }

    public function renderEmailProv(Request $request){
        $user = Auth::User();
        $claim_id = $request->claim_id;
        $id = $request->export_letter_id;
        $export_letter = ExportLetter::findOrFail($id);
        $claim  = Claim::itemClaimReject()->findOrFail($claim_id);
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $diag_code = $HBS_CL_CLAIM->HBS_CL_LINE->pluck('diag_oid')->unique()->toArray();
        $match_form_gop = preg_match('/(FORM GOP)/', $export_letter->letter_template->name , $matches);
        $template = $match_form_gop ? 'templateEmail.sendProviderTemplate_input' : 'templateEmail.sendProviderTemplate_output';
        
        $data['diag_text'] = implode(",",$HBS_CL_CLAIM->HBS_CL_LINE->pluck('RT_DIAGNOSIS.diag_desc_vn')->unique()->toArray());
        $incurDateTo = Carbon::parse($HBS_CL_CLAIM->FirstLine->incur_date_to);
        $incurDateFrom = Carbon::parse($HBS_CL_CLAIM->FirstLine->incur_date_from);
        $data['incurDateTo'] = $incurDateTo->format('d-m-Y');
        $data['incurDateFrom'] = $incurDateFrom->format('d-m-Y');
        $data['diffIncur'] =  $incurDateTo->diffInDays($incurDateFrom);
        $data['email_reply'] = $user->email;
        //benifit
        $request2 = new Request([
            'diag_code' => $diag_code,
            'id_claim' => $claim->code_claim
        ]);

        $data['HBS_CL_CLAIM'] = $HBS_CL_CLAIM;
        $data['Diagnosis'] = data_get($claim->hospital_request,'diagnosis',null) ?  data_get($claim->hospital_request,'diagnosis') : $HBS_CL_CLAIM->FirstLine->RT_DIAGNOSIS->diag_desc_vn;
        $html = view($template, compact('data'))->render();
        return response()->json([ 'data' => $html]);
    }

    public function offNotifyFinish(Request $request){
        
        $data = FinishAndPay::findOrFail($request->id);
        $data->notify = 0;
        $data->save();
        return response()->json(['message' => 'success']);
    }

    public function offNotifyExtend(Request $request){
        
        $data = ExtendClaim::findOrFail($request->id);
        $data->notify = 0;
        $data->save();
        return response()->json(['message' => 'success']);
    }


    public function MessageComfirmConract($memb_ref_no){
        
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        
        try {
            $request = $client->request('GET', config('constants.url_query_online').$memb_ref_no, ['connect_timeout' => 3]);
            
            $response = $request->getBody()->getContents();
            $response = json_decode($response,true);
            
            if(data_get($response, 'response_msg.msg_code') == "DLVN0"){
                $client_info = collect($response['client_info'])->whereNotIn('sStatus', ['Not-Taken']);
                $all_lapse_process_date = collect($response['all_lapse_process_date']);
                $all_lapse_effective_date = collect($response['all_lapse_effective_date']);
                $all_reinstate_date = collect($response['all_reinstate_date']);
                $map_ql = $client_info->map(function ($item, $key) {
                    $t = "";
                    switch (substr(trim(data_get($item,'sPlanID')), 3,1)) {
                        case 'O':
                            $t = "OP";
                            break;
                        case 'I':
                            $t = "IP";   
                            break;
                        default:
                            $t = "DT";
                            break;
                    }
                    return  $t ."-" . (int)trim(data_get($item,'dFaceAmount')) / 1000000;
                });
                
                $html = 'Dear DLVN ' . "\n". "\n";
                $html .= 'Vui lòng xác nhận tình trạng hợp đồng.' . "\n";
                $html .= "Quyền lợi: " .implode(", ",$map_ql->toArray()) . "\n";
                $html .= "Hiệu lực: " . Carbon::parse($client_info->first()['sCoverageIssueDate'])->format('d/m/Y') . "\n";
                $html .= "Tình trạng: ". $client_info->first()['sStatus'] . "\n". "\n";
                if($all_lapse_effective_date->count() > 0 ){
                    $html .=  "Lapse effective: ". Carbon::parse($all_lapse_effective_date->first()['sDate'])->format('d/m/Y') . "\n";
                }
                if($all_lapse_process_date->count() > 0 ){
                    $html .=  "Lapse process: ". Carbon::parse($all_lapse_process_date->first()['sDate'])->format('d/m/Y') . "\n";
                }
                if($all_reinstate_date->count() > 0 ){
                    $html .=  "Reinstate: ". Carbon::parse($all_reinstate_date->first()['sDate'])->format('d/m/Y') . "\n";
                }
                $html .=  "\n"."Thanks." . "\n";
                return response()->json(['message' => 'success' ,'data' => $html]);
            }else{
                return response()->json(['message' => 'error' ,'data' => '']);
            }
        } catch ( Exception $e) {
            return response()->json(['message' => 'error' ,'data' => '']);
        }
        
    }

    public function QueryOnline($memb_ref_no){
        
        $headers = [
            'Content-Type' => 'application/json',
        ];
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        try {
            $request = $client->get(config('constants.url_query_online').$memb_ref_no);
            $response = $request->getBody()->getContents();
            return response()->json(['message' => 'success' ,'data' => $response]);
    
        } catch (Exception $e) {
            return response()->json(['message' => 'error' ,'data' => '']);
        }
    }

    public function sendMfile($claim_id){
        $claim  = Claim::itemClaimReject()->findOrFail($claim_id);
        if($claim->url_file_sorted == null ){
            return response()->json(['errorCode' => 999 ,'errorMsg' => 'File không tồn tại']);
        }
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $poho_oids = \App\HBS_MR_POLICYHOLDER::where('poho_ref_no', $HBS_CL_CLAIM->PolicyHolder->poho_ref_no)->pluck('poho_oid')->toArray();
        $pocy_ref_nos =  \App\HBS_MR_POLICY::whereIn('poho_oid',$poho_oids)->pluck('pocy_ref_no')->unique()->toArray();



        $handle = fopen(storage_path("app/public/sortedClaim/{$claim->url_file_sorted}"),'r');
        $treamfile = stream_get_contents($handle);
        $token = getTokenMfile();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'bearer '.$token
        ];
        
        $body = [
            'mode' => config('constants.mode_mfile'),
            'policy_holder' => [
                "policy_holder_name" => strtoupper(Str::slug($HBS_CL_CLAIM->PolicyHolder->poho_name_1,' '))." (".$HBS_CL_CLAIM->PolicyHolder->poho_ref_no.")",
                "policy_holder_no" =>  $HBS_CL_CLAIM->PolicyHolder->poho_ref_no,
                "policy_holder_note" =>  "PO. " . implode(" + ", $pocy_ref_nos),

            ],
            'member' => [
                "member_name" => strtoupper(Str::slug($HBS_CL_CLAIM->member->mbr_last_name. " " .$HBS_CL_CLAIM->member->mbr_first_name,' ')) ." (".$HBS_CL_CLAIM->member->memb_ref_no.")",
                "member_no" =>  $HBS_CL_CLAIM->member->memb_ref_no,
                "is_terminated" => "0",
                "member_notes"=> ""
        
            ],
            'claim' => [
                "claim_info" => [
                    "claim_no" => $claim->code_claim_show,
                    "payee" => $claim->claim_type == "M" ? "Insured" : strtoupper(Str::slug($HBS_CL_CLAIM->Provider->prov_name , ' ')),
                    "claim_note" => "Note something"
                ],
                "claim_file" =>  [
                    "file_extension" => "pdf",
                    "file_content" => $treamfile
                ]
            ]
        ];
        
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.link_mfile').'uploadmfile' , ['form_params'=>$body]);
        $response =  json_decode($response->getBody()->getContents());
        if($response->errorCode == 0){
            \App\LogMfile::updateOrCreate([
                'claim_id' => $claim_id,
            ],[
                'cl_no' => $claim->code_claim_show,
                'm_errorCode' => $response->errorCode,
                'm_errorMsg' => $response->errorMsg,
                'm_policy_holder_id' => $response->info_policy_holder->policy_holder_id,
                'm_policy_holder_latest_version' => $response->info_policy_holder->policy_holder_latest_version,
                'm_member_id' => $response->info_member->member_id,
                'm_member_latest_version' => $response->info_member->member_latest_version,
                'm_claim_id' => $response->info_claim->claim_id,
                'm_claim_latest_version' => $response->info_claim->claim_latest_version,
                'm_claim_file_id' => $response->info_claim->claim_file_id,
                'm_claim_file_latest_version' => $response->info_claim->claim_file_latest_version,
                'have_ca' => 1
            ]);
        }
        return response()->json(['errorCode' => $response->errorCode ,'errorMsg' => $response->errorMsg]);
    }

    public function viewMfile($mfile_claim_id, $mfile_claim_file_id){
        $token = getTokenMfile();
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'bearer '.$token
        ];
        $body = [
            'mode' => config('constants.mode_mfile'),
            'claim_id' => $mfile_claim_id,
            'claim_file_id' => $mfile_claim_file_id
        ];
        $client = new \GuzzleHttp\Client([
            'headers' => $headers
        ]);
        $response = $client->request("POST", config('constants.link_mfile').'downloadfile' , ['form_params'=>$body]);
        $response =  $response->getBody()->getContents();
        header("Content-Type: application/pdf");
        header("Expires: 0");//no-cache
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
        header("content-disposition: attachment;filename=mfile.pdf");
        
        echo $response;
    }
    
}
