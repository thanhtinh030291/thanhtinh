<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClaimWordSheetRequest;
use App\Http\Requests\UpdateClaimWordSheetRequest;
use App\ClaimWordSheet;
use App\HBS_MR_MEMBER;
use Auth;
use App\User;
use App\Claim;
use App\HBS_CL_CLAIM;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Arr;

class ClaimWordSheetController extends Controller
{
    /** @var  ClaimWordSheetRepository */
    private $claimWordSheetRepository;

    public function __construct()
    {
        //$this->authorizeResource(ClaimWordSheet::class);
        parent::__construct();
    }

    /**
     * Display a listing of the ClaimWordSheet.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $search_params = [
            'created_user' => $request->get('created_user'),
            'created_at' => $request->get('created_at'),
            'updated_user' => $request->get('updated_user'),
            'updated_at' => $request->get('updated_at'),
        ];
        $admin_list = User::getListIncharge();
        $limit_list = config('constants.limit_list');
        $limit = $request->get('limit');
        $per_page = !empty($limit) ? $limit : Arr::first($limit_list);

        $claimWordSheets =  ClaimWordSheet::findByParams($search_params)->orderBy('id', 'desc');
        $claimWordSheets  = $claimWordSheets->paginate($per_page);

        return view('claim_word_sheets.index', compact('search_params', 'admin_list', 'limit', 'limit_list', 'claimWordSheets' ));           
    }

    /**
     * Show the form for creating a new ClaimWordSheet.
     *
     * @return Response
     */
    /**
     * Store a newly created ClaimWordSheet in storage.
     *
     * @param CreateClaimWordSheetRequest $request
     *
     * @return Response
     */
    public function store(CreateClaimWordSheetRequest $request)
    {
        $userId = Auth::User()->id;
        $data = $request->except([]);
        $data['created_user'] = $userId;
        $data['updated_user'] = $userId;
        ClaimWordSheet::create($data);
        $request->session()->flash('status', 'Claim Word Sheet saved successfully.');

        return redirect(route('claim.show',['claim'=>$request->claim_id]));
    }

    /**
     * Display the specified ClaimWordSheet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(ClaimWordSheet $claimWordSheet)
    {
        $claim  = Claim::itemClaimReject()->findOrFail($claimWordSheet->claim_id);
        $HBS_CL_CLAIM = HBS_CL_CLAIM::IOPDiag()->findOrFail($claim->code_claim);
        $member = HBS_MR_MEMBER::where('MEMB_REF_NO',$claimWordSheet->mem_ref_no)->first();
        $claim_line = $member->CL_LINE;
        $log_history = $claimWordSheet->log;
        //dd($member->MR_MEMBER_EVENT->where('scma_oid_event_code', 'EVENT_CODE_EXPL')->first());
        return view('claim_word_sheets.show', compact('claimWordSheet', 'claim', 'HBS_CL_CLAIM', 'member','claim_line', 'log_history'));
    }

    /**
     * Show the form for editing the specified ClaimWordSheet.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(ClaimWordSheet $claimWordSheet)
    {
        
        return view('claim_word_sheets.edit',  compact('claimWordSheet'));
    }

    /**
     * Update the specified ClaimWordSheet in storage.
     *
     * @param int $id
     * @param UpdateClaimWordSheetRequest $request
     *
     * @return Response
     */
    public function update(ClaimWordSheet $claimWordSheet, UpdateClaimWordSheetRequest $request)
    {
        $data = $request->except([]);
        $userId = Auth::User()->id;
        $data['updated_user'] = $userId;
        ClaimWordSheet::updateOrCreate(['id' => $claimWordSheet->id], $data);

        $request->session()->flash('status', 'Claim Word Sheet updated successfully.'); 
        return redirect(route('claimWordSheets.index'));
    }

    /**
     * Remove the specified ClaimWordSheet from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(ClaimWordSheet $claimWordSheet)
    {
        $claimWordSheet->delete();
        return redirect(route('claimWordSheets.index'))->with('status', 'Claim Word Sheet deleted successfully.');
    }
}
