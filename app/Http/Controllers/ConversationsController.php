<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationsController extends Controller   // return all conversation when all user auth
{

    public function index()
    {
        $user  = Auth::user();
        return $user->conversations()->paginate();
    }

    public function show(Conversation $conversation)
    {
        return $conversation->load('participants');
    }

    public function addParticipants(Request $request , Conversation $conversation)
    {
        $request->validate([
            'user_id' => ['required' , 'int' ,  'exists:users,id'],
        ]);

        $conversation->participants()->attach($request->post('user_id'),[
            'joined_at' => Carbon::now(),
        ]);
    }

    public function removeParticipants(Request $request , Conversation $conversation)
    {
        $request->validate([
            'user_id' => ['required' , 'int' ,  'exists:users,id'],
        ]);

        $conversation->participants()->detach($request->post('user_id'));
    }

}


