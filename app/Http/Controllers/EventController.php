<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

class EventController extends Controller
{
    public function index(){

        $events = Event::all();

        return view('welcome', ['events' => $events ]);

    }

    public function create(){
        
        return view('events.create');

    }

    public function store(Request $request){

        $event = new Event;

        $event->title = $request->title;
        $event->classroom = $request->classroom; 
        $event->private = $request->private; 
        $event->description = $request->description;
        $event->items = $request->items;
                
        //Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            
            $request->image->move(public_path('assets/imgEvents'), $imageName);

            $event->image = $imageName;
        
        }

        $event->save();

        return redirect('/events/create')->with('msg', 'Aula cadastrada com sucesso!');
    }

    public function show($id) {

        $event = Event::findOrfail($id);

        return view('events.show', ['event' => $event]);
        
    }
}
