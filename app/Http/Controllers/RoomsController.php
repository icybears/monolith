<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;

class RoomsController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth');
        $this->middleware('room')->only('edit','update');
    }


    public function index()
    {
        $rooms = Room::orderBy('posts_count','desc')->paginate(15);

        return view('rooms.index', compact('rooms'));
    }

    public function show (Room $room) {

        return view('rooms.show', compact('room'));

    }

    public function edit (Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Room $room)
    {
        $this->validate(request(),
        [
            'name' => 'min:1|max:25',
            'description' => 'min:3|max:120'
        ]);

        $room->update([
            'name' => trim(request('name')),
            'description' => trim(request('description'))
        ]);


        return redirect()->route('room', ['room' => $room->id]);

    }

    public function subscribe(Room $room)
    {
        $room->users()->attach(auth()->id());

        return back();
    }

    public function unsubscribe(Room $room)
    {
        $room->users()->detach(auth()->id());

        return back();
    }

    public function search()
    {
        $this->validate(request(),
        ['query' => 'required|min:4| max:120']);

        $rooms = Room::where('name','like','%' . request('query') . '%')
            ->orWhere('description','like','%' . request('query') . '%')
            ->paginate(15);

        return view('rooms.index', compact('rooms'));
    }
   


}
