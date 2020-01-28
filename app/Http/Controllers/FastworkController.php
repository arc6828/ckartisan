<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Fastwork;
use App\FastworkStatus;
use App\Project;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;

class FastworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 10;

        if (!empty($keyword)) {
            $fastwork = Fastwork::where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->orWhere('deadline', 'LIKE', "%$keyword%")
                ->orWhere('reserved_at', 'LIKE', "%$keyword%")
                ->orWhere('paid_at', 'LIKE', "%$keyword%")
                ->orWhere('completed_at', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orWhere('developer_id', 'LIKE', "%$keyword%")
                ->orWhere('project_id', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->orWhere('remark', 'LIKE', "%$keyword%")
                ->orWhere('photo', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $fastwork = Fastwork::latest()->paginate($perPage);
        }

        return view('fastwork.index', compact('fastwork'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $projects = Project::all();
        $profiles = Profile::whereIn('role',['user','admin'])->get();

        return view('fastwork.create', compact('projects','profiles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'photo' => 'image'
        ]);

        $requestData = $request->all();
        if ($request->hasFile('photo')) {
            //SAVE FILE
            $requestData['photo'] = $request->file('photo')->store('uploads/fastwork', 'public');

            //RESIZE 50% FILE IF IMAGE LARGER THAN 1 MB
            $image = Image::make(storage_path("app/public")."/".$requestData['photo']);
            $size = $image->filesize();            
            if($size > 1024000 ){
                $image->resize(
                    intval($image->width()/2) , 
                    intval($image->height()/2)
                )->save();        
            }            

        }
        $requestData['status'] = "created";        

        Fastwork::create($requestData);

        return redirect('fastwork')->with('flash_message', 'Fastwork added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $fastwork = Fastwork::findOrFail($id);    
        
        if($fastwork->created_at){
            $fastwork->status = 'created';
        }
        if($fastwork->reserved_at){
            $fastwork->status = 'reserved';
        }
        if($fastwork->completed_at){
            $fastwork->status = 'completed';
        }
        if($fastwork->paid_at){
            $fastwork->status = 'paid';
        }
        $fastwork->save();

        /*
        //CHECK CREATE EXIST
        $fastwork_status = FastworkStatus::firstOrCreate(
            ['fastwork_id' => $fastwork->id],
            ['title' => 'created_at' , 'created_at' => $fastwork->created_at]
        );
        //CHCEK RESERVE EXIST
        //echo isset($fastwork->reserve_date);
        if(isset($fastwork->reserve_date)){
            //echo 555;
            $fastwork_status = FastworkStatus::firstOrCreate(
                ['title' => 'reserved_at'],
                ['fastwork_id' => $fastwork->id, 'created_at' => $fastwork->reserve_date]
            );
        }
        */
        
        return view('fastwork.show', compact('fastwork'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $fastwork = Fastwork::findOrFail($id);
        $projects = Project::all();
        $profiles = Profile::whereIn('role',['user','admin'])->get();

        return view('fastwork.edit', compact('fastwork','projects','profiles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'photo' => 'image'
        ]);

        $requestData = $request->all();
        if ($request->hasFile('photo')) {
            //SAVE FILE
            $requestData['photo'] = $request->file('photo')->store('uploads/fastwork', 'public');

            //RESIZE 50% FILE IF IMAGE LARGER THAN 1 MB
            $image = Image::make(storage_path("app/public")."/".$requestData['photo']);
            $size = $image->filesize();            
            if($size > 1024000 ){
                $image->resize(
                    intval($image->width()/2) , 
                    intval($image->height()/2)
                )->save();        
            }  
        }
        
        //$requestData['status'] = "created";
        $status = $requestData['status'];
        switch( $status ){
            case "reserved" : 
                $requestData['reserved_at'] = date('Y-m-d H:i:s');
                break;
            case "completed" : 
                $requestData['completed_at'] = date('Y-m-d H:i:s');
                break;
            case "paid" : 
                $requestData['paid_at'] = date('Y-m-d H:i:s');
                break;
        }

        $fastwork = Fastwork::findOrFail($id);
        $fastwork->update($requestData);

        return redirect('fastwork')->with('flash_message', 'Fastwork updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Fastwork::destroy($id);

        return redirect('fastwork')->with('flash_message', 'Fastwork deleted!');
    }
}
