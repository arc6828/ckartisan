<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Fastwork;
use App\Project;
use Illuminate\Http\Request;

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
        $perPage = 25;

        if (!empty($keyword)) {
            $fastwork = Fastwork::where('title', 'LIKE', "%$keyword%")
                ->orWhere('content', 'LIKE', "%$keyword%")
                ->orWhere('deadline', 'LIKE', "%$keyword%")
                ->orWhere('reserve_date', 'LIKE', "%$keyword%")
                ->orWhere('accept_date', 'LIKE', "%$keyword%")
                ->orWhere('complete_date', 'LIKE', "%$keyword%")
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

        return view('fastwork.create', compact('projects'));
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

        $requestData = $request->all();
                if ($request->hasFile('photo')) {
            $requestData['photo'] = $request->file('photo')
                ->store('uploads/fastwork', 'public');
        }

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
        return view('fastwork.edit', compact('fastwork','projects'));
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

        $requestData = $request->all();
                if ($request->hasFile('photo')) {
            $requestData['photo'] = $request->file('photo')
                ->store('uploads/fastwork', 'public');
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