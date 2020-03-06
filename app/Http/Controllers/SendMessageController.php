<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use Auth;
use App\User;
use App\Message;
use App\Events\Notify;
use App\Notifications\PushNotification;

class SendMessageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('user_to', $user->id)->get();
        $admin_list = User::getListIncharge();
        return view('messageManagement/index',compact('messages','admin_list'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'content' => 'required'
        ]);
        $user = Auth::user();
        $options = array(
            'cluster' => config('constants.PUSHER_APP_CLUSTER'),
            'encrypted' => true
        );
        $data['title'] = $user->name . ' gửi tin cho bạn';
        $data['content'] = $request->input('content');
        $data['avantar'] = config('constants.avantarStorage').'thumbnail/'.$user->avantar;
        $pusher = new Pusher(
            config('constants.PUSHER_APP_KEY'),
            config('constants.PUSHER_APP_SECRET'),
            config('constants.PUSHER_APP_ID'),
            $options
        );
        
        $user->messagesSent()->create([
            'user_to' => $request->input('user'),
            'message' => $request->input('content')
        ]);
        
        $pusher->trigger('NotifyUser-'.$request->input('user'),'Notify' ,$data);
        $user_to = User::findOrfail($request->input('user'));
        $user_to->notify(new PushNotification(
            $data['title'] , $data['content'] , $data['avantar']
        ));
        //event(new Notify($data['content']));
        return redirect('/admin/home/');
    }

    public function readAll(Request $request){
        
        $user = Auth::user();
        Message::where('is_read' , 0)->where('user_to',$user->id)->update(['is_read' => 1]);
    }
}