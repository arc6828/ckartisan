<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FastworkStatus;
use Illuminate\Http\Request;

class FastworkStatusController extends Controller
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
            $fastworkstatus = FastworkStatus::where('title', 'LIKE', "%$keyword%")
                ->orWhere('fastwork_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $fastworkstatus = FastworkStatus::latest()->paginate($perPage);
        }

        return view('fastwork-status.index', compact('fastworkstatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('fastwork-status.create');
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
        
        FastworkStatus::create($requestData);

        return redirect('fastwork-status')->with('flash_message', 'FastworkStatus added!');
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
        $fastworkstatus = FastworkStatus::findOrFail($id);

        return view('fastwork-status.show', compact('fastworkstatus'));
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
        $fastworkstatus = FastworkStatus::findOrFail($id);

        return view('fastwork-status.edit', compact('fastworkstatus'));
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
        
        $fastworkstatus = FastworkStatus::findOrFail($id);
        $fastworkstatus->update($requestData);

        return redirect('fastwork-status')->with('flash_message', 'FastworkStatus updated!');
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
        FastworkStatus::destroy($id);

        return redirect('fastwork-status')->with('flash_message', 'FastworkStatus deleted!');
    }
}
