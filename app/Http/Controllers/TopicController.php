<?php

namespace App\Http\Controllers;

use App\User;
use App\Topic;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Auth;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    function __construct(){
        return $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::latest()->paginate(10);
        return view('topics.index', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('topics.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:10',


        ]);



        // return redirect()->back('/');


        // $topic = new Topic;
        // $topic->title = $request->input('title');
        // $topic->content = $request->input('content');
        // $topic = auth()->user()->topics()->create($request->all());
        $topic = auth()->user()->topics()->create($data);
        return  redirect()->route('topics.index', $topic->id);




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $id;
        // exit();
        // dd($id);
        // exit();
        // $topic = Topic::find($id);
        // dd($topic);
        // return $request->$topic_id;
        // return $topic->title;
        // exit();
        // return $topic_id;
        $topic = Topic::findOrFail($id);
        return view('topics.show')->with('topic', $topic);
    }

    public function showFromNotification(Topic $topic, DatabaseNotification $notification){
        $notification->markAsRead();
        return view('topics.show')->with('topic', $topic);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic, $id)
    {
        $topic = Topic::findOrFail($id);
        $this->authorize('update', $topic);
        return view('topics.edit')->with('topic', $topic);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic,      $id)
    {
            $data = $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:10',

        ]);
        $topic = Topic::findOrFail($id);
        $topic->update($data);
        // $topic = new Topic;
        // $topic->title = $request->input('title');
        // $topic->content = $request->input('content');
        // $topic->update($request->all());
        // $topic = Auth::user()->topics()->save();
        return  redirect()->route('topics.index')->with('topic', $topic);
        // return  redirect('topics.index', compact('topic'));
        // return redirect('topics.show', compact('topic'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function delete(Topic $topic, $id)
    {
        $topic = Topic::findOrFail($id);
        $this->authorize('delete', $topic);
        // dd($topic);
        $topic->delete();

        return  redirect()->route('topics.index')->with('topic', $topic);
    }

        public function markAsSolution()
    {
        $solutionId = Input::get('solutionId');
        $topicId = Input::get('topicId');

        $topic = Topic::find($topicId);
        $topic->solution = $solutionId;
        if ($topic->save()) {
            if (request()->ajax()) {
                return response()->json(['status' => 'success', 'message' => 'marked as solution']);
            }
            return back()->withMessage('Marked as solution');
        }


    }
}
