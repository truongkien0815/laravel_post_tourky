<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
class QuestionController extends Controller
{
    public function index()
    {
      
     
        $contact = Question::orderBy('created_at','desc')->get();
       
        return view('admin/question/contact')->with('contact',$contact);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $question = Question::orderBy('created_at','desc')->get();
        return view('admin/question/contact_add')->with('question',$question);
    }
    public function addcontact()
    {
        return view('admin/question/contact_add');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Question;
        $item->question_list = $request->question_list;
        $item->save();
        $contact = Question::orderBy('created_at','desc')->get();
        return view('admin/question/contact')->with('contact',$contact);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Question::find($id);
        $question = Question::orderBy('created_at','desc')->get();
        return view('admin/question/contact_edit')->with('item', $item)->with('question', $question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Question::find($id);
        $item->question_list =  $request->question_list;
        $item->save();
        $contact = Question::orderBy('created_at','desc')->get();
        return view('admin/question/contact')->with('contact',$contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Question::find($id);
        $item->delete();
        return redirect()->back();
    }
}
