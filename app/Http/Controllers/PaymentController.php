<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Payment;
use App\Fastwork;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $withdraw = null;
        $perPage = 25;


        //ADMIN        
        if(Auth::user()->profile->role == "admin"){       
            $withdraw = Payment::whereNull('paid_at')->sum('total');
            $payment = Payment::latest()->paginate($perPage);
        }else{
            $payment = Payment::where('user_id',Auth::id())->latest()->paginate($perPage);
        }

        return view('payment.index', compact('payment','withdraw'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $payment = null;
        
        $user_id = $request->get('user_id');
        $user = User::find($user_id);
        if($user){
            $payment = new Payment;
            $payment->total = $user->profile->completed_part_time_fastworks->sum('price');
            $payment->user_name = $user->name;
            $payment->user_id = $user->id;

        }
        return view('payment.create',compact('user','payment'));
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
        if ($request->hasFile('receipt')) {
            $requestData['receipt'] = $request->file('receipt')
                ->store('uploads', 'public');
            $requestData['paid_at'] = date("Y-m-d H:i:s");
        }

        $payment = Payment::create($requestData);

        //UPDATE status, paid_at of Fastwork
        $user_id = $requestData['user_id'];
        if( $user_id ){
            $data = [
                'payment_id' => $payment->id ,
                'fastworks.status' => "paid" ,
                'paid_at' => date("Y-m-d H:i:s") ,
            ];
            $fastworks = Fastwork::join('projects','fastworks.project_id','=','projects.id')
                ->where('type','part-time')
                ->where('fastworks.status','completed')
                ->where('developer_id', $requestData['user_id'])
                ->select('fastworks.*')
                ->update( $data );
        }
        return redirect('payment')->with('flash_message', 'Payment added!');
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
        $payment = Payment::findOrFail($id);

        return view('payment.show', compact('payment'));
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
        $payment = Payment::findOrFail($id);

        return view('payment.edit', compact('payment'));
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
        if ($request->hasFile('receipt')) {
            $requestData['receipt'] = $request->file('receipt')
                ->store('uploads', 'public');
            $requestData['paid_at'] = date("Y-m-d H:i:s");
        }

        $payment = Payment::findOrFail($id);
        $payment->update($requestData);

        return redirect('payment')->with('flash_message', 'Payment updated!');
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
        Payment::destroy($id);

        return redirect('payment')->with('flash_message', 'Payment deleted!');
    }
}
