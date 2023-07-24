<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($uuid)
    {
        $model = Room::where('uuid', $uuid)->first();
        return view('frontend.room', compact('model'));
    }
    public function submitVote(Request $request)
    {
        $roomId = $request->roomId;
        $option = $this->firebase->getReference('room' . $roomId . '/options' . '/' . $request->key);
        $option->getChild('vote')->set($option->getChild('vote')->getValue() + 1);
        return response()->json(['success' => 'success']);
    }
}
