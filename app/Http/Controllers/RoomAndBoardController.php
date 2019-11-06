<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoomAndBoardRequest;
use App\Http\Requests\UpdateRoomAndBoardRequest;
use App\Repositories\RoomAndBoardRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class RoomAndBoardController extends AppBaseController
{
    /** @var  RoomAndBoardRepository */
    private $roomAndBoardRepository;

    public function __construct(RoomAndBoardRepository $roomAndBoardRepo)
    {
        $this->roomAndBoardRepository = $roomAndBoardRepo;
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
        $roomAndBoards = $this->roomAndBoardRepository->all();

        return view('room_and_boards.index')
            ->with('roomAndBoards', $roomAndBoards);
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
        $input = $request->all();

        $roomAndBoard = $this->roomAndBoardRepository->create($input);

        Flash::success('Room And Board saved successfully.');

        return redirect(route('roomAndBoards.index'));
    }

    /**
     * Display the specified RoomAndBoard.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $roomAndBoard = $this->roomAndBoardRepository->find($id);

        if (empty($roomAndBoard)) {
            Flash::error('Room And Board not found');

            return redirect(route('roomAndBoards.index'));
        }

        return view('room_and_boards.show')->with('roomAndBoard', $roomAndBoard);
    }

    /**
     * Show the form for editing the specified RoomAndBoard.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $roomAndBoard = $this->roomAndBoardRepository->find($id);

        if (empty($roomAndBoard)) {
            Flash::error('Room And Board not found');

            return redirect(route('roomAndBoards.index'));
        }

        return view('room_and_boards.edit')->with('roomAndBoard', $roomAndBoard);
    }

    /**
     * Update the specified RoomAndBoard in storage.
     *
     * @param int $id
     * @param UpdateRoomAndBoardRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoomAndBoardRequest $request)
    {
        $roomAndBoard = $this->roomAndBoardRepository->find($id);

        if (empty($roomAndBoard)) {
            Flash::error('Room And Board not found');

            return redirect(route('roomAndBoards.index'));
        }

        $roomAndBoard = $this->roomAndBoardRepository->update($request->all(), $id);

        Flash::success('Room And Board updated successfully.');

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
    public function destroy($id)
    {
        $roomAndBoard = $this->roomAndBoardRepository->find($id);

        if (empty($roomAndBoard)) {
            Flash::error('Room And Board not found');

            return redirect(route('roomAndBoards.index'));
        }

        $this->roomAndBoardRepository->delete($id);

        Flash::success('Room And Board deleted successfully.');

        return redirect(route('roomAndBoards.index'));
    }
}
