<?php

namespace App\Http\Controllers\Admin\Room;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $models = Room::orderBy('created_at', 'DESC')->paginate();
        return view('admin.rooms.index', compact('models'));
    }
    public function create()
    {
        try {
            return view('admin.rooms.edit');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function store(Request $request)
    {
        try {
            $model = new Room();
            $model->name = $request->name;
            $model->uuid = Str::uuid();
            $model->save();
            $roomRef = $this->firebase->getReference('room' . $model->uuid);
            $roomRef->getChild('uuid')->set($model->uuid);
            $roomRef->getChild('status')->set(0);
            $roomRef->getChild('reset')->set(0);
            $roomRef->getChild('name')->set($request->name);
            return redirect(route('room.index'))->with('success');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function update($id, Request $request)
    {
        try {
            $model = Room::find($id);
            $model->name = $request->name;
            $model->save();
            $roomRef = $this->firebase->getReference('room' . $model->uuid);
            $roomRef->getChild('name')->set($request->name);
            return redirect()->back()->with('success');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function edit($id)
    {
        try {
            $model = Room::find($id);
            return view('admin.rooms.edit', compact('model'));
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    ///
    public function addOption(Request $request)
    {
        $roomId = $request->roomId;
        $roomRef = $this->firebase->getReference('room' . $roomId . '/options');
        $userData = [
            'name' => $request->name,
            'vote' => 0,
            'avatar' => $request->avatar
        ];
        $roomRef->push($userData);
        return response()->json(['message' => 'success']);
    }
    public function removeOption(Request $request)
    {
        $roomId = $request->roomId;
        $option = $this->firebase->getReference('room' . $roomId . '/options' . '/' . $request->key);
        $option->remove();
        return response()->json(['message' => 'success']);
    }
    public function startVote(Request $request)
    {
        $roomId = $request->roomId;
        $room = $this->firebase->getReference('room' . $roomId);
        $room->getChild('status')->set(1);
        return response()->json(['message' => 'success']);
    }
    public function resetRound(Request $request)
    {
        $roomId = $request->roomId;
        $room = $this->firebase->getReference('room' . $roomId);
        $room->getChild('reset')->set(1);
        $room->getChild('reset')->set(0);
        foreach ($room->getValue()['options'] as $key => $option) {
            $vote = $this->firebase->getReference('room' . $roomId . '/options' . '/' . $key);
            $vote->getChild('vote')->set(0);
        };
        return response()->json(['message' => 'success']);
    }
    public function disableVote(Request $request)
    {
        $roomId = $request->roomId;
        $room = $this->firebase->getReference('room' . $roomId);
        $room->getChild('status')->set(0);
        return response()->json(['message' => 'success']);
    }
    ///
    public function destroy($id)
    {
        $model = Room::find($id);
        try {
            $model->delete();
            $option = $this->firebase->getReference('room' . $model->uuid);
            $option->remove();
            session()->flash('success', 'Destroy successfully.');
            return response(['message' => 'asdsd'], 200);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
