<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publication;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $authors =  $request->input("authors","");
      $year =  $request->input("year","");

      $publications  = Publication::where([
          ["authors", 'like' , "%{$authors}%"],
          ["year" , 'like' , "%{$year}%"],
        ])
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();    
        
      return view('publication/index', compact('publications','authors','year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('publication/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $input = [
        "authors" => $request->input("authors",""),
        "title" => $request->input("title",""),
        "publisher" => $request->input("publisher",""),
        "date" => $request->input("date","1"),
        "month" => $request->input("month","1"),
        "year" => $request->input("year","")<2500?$request->input("year",""):$request->input("year","")-543,
        "pages" => $request->input("pages",""),
        "type" => $request->input("type",""),
        "language" => $request->input("language",""),
        //extension
        "city" => $request->input("city",""),
        "place" => $request->input("place",""),
      ];
      Publication::insert($input);
      return redirect('/publication');
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
      $data = [
        "publication" => Publication::select_by_id($id)
      ];
      return view('publication/edit',$data);
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
      $input = [
        "authors" => $request->input("authors",""),
        "title" => $request->input("title",""),
        "publisher" => $request->input("publisher",""),
        "date" => $request->input("date","1"),
        "month" => $request->input("month","1"),
        "year" => $request->input("year","")<2500?$request->input("year",""):$request->input("year","")-543,
        "pages" => $request->input("pages",""),
        "type" => $request->input("type",""),
        "language" => $request->input("language",""),
        //extension
        "city" => $request->input("city",""),
        "place" => $request->input("place",""),
      ];
      Publication::update_by_id($input,$id);
      return redirect('/publication#title');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Publication::delete_by_id($id);
      return redirect('/publication#title');
    }
}
