<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoomAndBoardRequest;
use App\Http\Requests\UpdateRoomAndBoardRequest;
use App\RoomAndBoard;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Flash;
use Response;
use Illuminate\Support\Arr;

class RoomAndBoardController extends Controller
{
    /** @var  RoomAndBoardRepository */
    private $roomAndBoardRepository;

    public function __construct()
    {
        //$this->authorizeResource(RoomAndBoard::class);
        parent::__construct();
    }

    /**
     * Display a listing of the RoomAndBoard.
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

        $roomAndBoards =  RoomAndBoard::findByParams($search_params)->orderBy('id', 'desc');
        $roomAndBoards  = $roomAndBoards->paginate($per_page);

        return view('room_and_boards.index', compact('search_params', 'admin_list', 'limit', 'limit_list', 'roomAndBoards' ));           
    }

    /**
     * Show the form for creating a new RoomAndBoard.
     *
     * @return Response
     */
    public function create()
    {
        return view('room_and_boards.create');
    }

    /**
     * Store a newly created RoomAndBoard in storage.
     *
     * @param CreateRoomAndBoardRequest $request
     *
     * @return Response
     */
    public function store(CreateRoomAndBoardRequest $request)
    {
        $userId = Auth::User()->id;
        $data = $request->except([]);
        $data['created_user'] = $userId;
        $data['updated_user'] = $userId;

        RoomAndBoard::create($data);
        $request->session()->flash('status', 'Room And Board saved successfully.');

        return redirect(route('roomAndBoards.index'));
    }

    /**
     * Display the specified RoomAndBoard.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(RoomAndBoard $roomAndBoard)
    {
        
        return view('room_and_boards.show', compact('roomAndBoard'));
    }

    /**
     * Show the form for editing the specified RoomAndBoard.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(RoomAndBoard $roomAndBoard)
    {
        
        return view('room_and_boards.edit',  compact('roomAndBoard'));
    }

    /**
     * Update the specified RoomAndBoard in storage.
     *
     * @param int $id
     * @param UpdateRoomAndBoardRequest $request
     *
     * @return Response
     */
    public function update(RoomAndBoard $roomAndBoard, UpdateRoomAndBoardRequest $request)
    {
        $data = $request->except([]);
        $userId = Auth::User()->id;
        $data['updated_user'] = $userId;
        Product::updateOrCreate(['id' => $roomAndBoard->id], $data);

        $request->session()->flash('status', 'Room And Board updated successfully.'); 
        return redirect(route('roomAndBoards.index'));
    }

    /**
     * Remove the specified RoomAndBoard from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(RoomAndBoard $roomAndBoard)
    {
        $roomAndBoard->delete();
        return redirect(route('roomAndBoards.index'))->with('status', 'Room And Board deleted successfully.');
    }
}
