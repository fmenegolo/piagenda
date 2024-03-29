<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index(){

        $search = request('search');

        if($search){
            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();

        } else {
            $events = Event::all();
        }        

        return view('welcome', ['events' => $events, 'search' => $search ]);

    }

    public function create(){
        
        return view('events.create');

    }

    public function store(Request $request){

        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
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

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/events/create')->with('msg', 'Aula cadastrada com sucesso!');
    }

    public function show($id) {

        $event = Event::findOrfail($id);

        $user = auth()->user();
        $hasUserJoined = false;
      
        if($user){

            $userEvents = $user->eventsAsParticipant->toArray();
            //fazer loop para correr o array todo não é um boa pratica (item a melhorar)
            foreach($userEvents as $userEvent) {
                if($userEvent['id'] == $id) {
                    $hasUserJoined = true;
                }
            }
        }

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show',
            ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined]);
        
    }

    public function dashboard() {

        $user = auth()->user();
        
        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard',
            ['events' => $events, 'eventsasparticipant' => $eventsAsParticipant]);

    }

    public function destroy($id) {

        $event = Event::findOrfail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Aula excluida com sucesso!');
    }

    public function edit($id) {

        $user = auth()->user();

        $event = Event::findOrfail($id);

        if($user->id != $event->user_id){
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request) {
        
        $data = $request->all(); 
        
        //Image Upload
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            
            $request->image->move(public_path('assets/imgEvents'), $imageName);

            $data['image'] = $imageName;
        
        }

        Event::findOrfail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Aula editada com sucesso!');
    }

    public function joinEvent($id) {

        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id);

        $event = Event::findOrfail($id);

        return redirect('/dashboard')->with('msg', 'Presença confirmada na aula de ' . $event->title);

    }

    public function leaveEvent($id) {

        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id);

        $event = Event::findOrfail($id);

        return redirect('/dashboard')->with('msg', 'Você saiu com sucesso da aula de ' . $event->title);

    }
}

