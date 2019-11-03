<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use Auth;

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
        $data['title'] = $request->input('title');
        $data['content'] = $request->input('content');
        $data['user'] = $request->input('user');
        
        $pusher = new Pusher(
            config('broadcasting.connections.pusher.key'),
            config('broadcasting.connections.pusher.secret'),
            config('broadcasting.connections.pusher.app_id'),
            config('broadcasting.connections.pusher.options')
        );
        
        //dd(config('broadcasting.connections.pusher'));
        $pusher->trigger('Notify', 'send-message-'.$data['user'], $data);

        return redirect('/admin/home/');
    }
}