<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use App\User;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        //its just a dummy data object.
        // Sharing is caring
        
        $this->middleware(function ($request, $next) {
            $user = Auth::user()  ;
            $listUser = User::pluck('email', 'id');
            $vision = 15;
            if($user){
                $messages = $user->messagesReceiver;
                View::share('messages', $messages);
                View::share('listUser', $listUser);
                View::share('vision', $vision);
            }
            
            return $next($request);
        });
        
        
        
    }
}
