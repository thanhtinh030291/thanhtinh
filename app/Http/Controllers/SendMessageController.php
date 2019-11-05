<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use Auth;
use App\Message;
use App\Events\Notify;

class SendMessageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        return view('pusherManagement/send_mesage');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'content' => 'required'
        ]);
        $user = Auth::user();
        
        $user->messagesSent()->create([
            'user_to' => $request->input('user'),
            'message' => $request->input('content')
        ]);
        $data['title'] = $user->name;
        $data['content'] = $request->input('content');
        $data['user'] = $request->input('user');
        
        
        event(new Notify($data));
        return redirect('/admin/home/');
    }

    public function readAll(Request $request){
        
        $user = Auth::user();
        Message::where('is_read' , 0)->where('user_to',$user->id)->update(['is_read' => 1]);
    }
}