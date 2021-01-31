<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $publications  = Publication::get();                
        return $publications;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->all();        
        $requestData["date"] = $request->input("date","1");
        $requestData["month"] = $request->input("month","1");
        $requestData["year"] = $request->input("year","")<2500?$request->input("year",""):$request->input("year","")-543;        

        $publication = Publication::create($requestData);
        return $publication;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publication = Fastwork::findOrFail($id);
        return $publication;
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
        $requestData = $request->all();       
        $publication = Publication::findOrFail($id);
        $publication->update($requestData);
        return $publication;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Publication::destroy($id);        
        return [
            "id"=> $id,
            "status" => "deleted"
        ];
    }
}
