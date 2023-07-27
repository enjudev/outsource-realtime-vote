<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($id)
    {
        $model = Room::where('id', $id)->first();
        return view('frontend.room', compact('model'));
    }
    public function submitVote(Request $request)
    {
        $roomId = $request->roomId;
        $room = Room::where('uuid', $roomId)->first();
        $votes[] = $request->vote;
        foreach ($votes as $vote) {
            $option = $this->firebase->getReference('room' . $roomId . '/options' . '/' . $vote);
            $option->getChild('vote')->set($option->getChild('vote')->getValue() + 1);
        }
        return response()->json(['url' => route('room.view', $room->id)]);
    }
    public function score($id)
    {
        $model = Room::where('id', $id)->first();
        return view('frontend.vote', compact('model'));
    }
}
