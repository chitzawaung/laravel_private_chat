<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Support\Facades\Redis;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function user_list(){
        $users = User::latest()->where('id', '!=', auth()->user()->id)->get();

        if( \Request::ajax()){

            return response()->json($users, 200);
        }
        return abort(404);
    }

    public function user_message($id=null){

        if(!\Request::ajax()){
            return abort(404);
        }
        // $message = Message::where('to', $id)->get();

        $user= User::findOrFail($id);
        $messages = $this->user_message_by_id($id);
        // $messages = Message::where(function($q) use($id) {
        //     $q->where('from', auth()->user()->id);
        //     $q->where('to', $id);
        //     $q->where('type', 0);
        // })->orwhere(function($q) use($id) {
        //     $q->where('from', $id);
        //     $q->where('to', auth()->user()->id);
        //     $q->where('type', 1);
        // })->with('user')->get();

        // return response()->json($messages, 200);
        return response()->json([
            'messages' =>$messages,
            'user' => $user
        ]);
    }

    public function send_message(Request $request){
        if(!$request->ajax()){
            abort(404);
        }
       $messages = Message::create([
           'message'=>$request->message,
           'from'=>auth()->user()->id,
           'to'=>$request->user_id,
           'type'=>0
       ]);
    //    $messages = Message::create([
    //     'message'=>$request->message,
    //     'from'=>auth()->user()->id,
    //     'to'=>$request->user_id,
    //     'type'=>1
    // ]);

        return response()->json($messages, 201);
    }

    public function delete_single_message($id=null) {
        // if(\Request::ajax()){
        //     return abort(404);
        // }
        Message::findOrFail($id)->delete();
        return response()->json('deleted', 200);
    }

    public function delete_all_message($id=null){
       $messages = $this->user_message_by_id($id);

       foreach($messages as $msg) {
           Message::findOrFail($msg->id)->delete();
       }

       return response()->json('all deleted message', 200);
    }

    public function user_message_by_id($id) {
        $messages = Message::where(function($q) use($id) {
            $q->where('from', auth()->user()->id);
            $q->where('to', $id);
            // $q->where('type', 0);
        })->orwhere(function($q) use($id) {
            $q->where('from', $id);
            $q->where('to', auth()->user()->id);
            // $q->where('type', 1);
        })->with('user')->get();

        return $messages;
    }

}
