<?php

namespace App\Http\Controllers;

use App\Income;
use App\Graphs;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'money' => 'required|gt:0|lte:2147483647',
        ]);
        $user = auth()->user();
        $spendings = Income::where('user_id', $user->id)->get();
        $connecting = Graphs::where('user_id',$user->id)->get();
        $addedmoney = 0;



        $money = new Income;
        $money->graphs_id = $user->id;
        $money->month = request('month');
        $money->money = request('money');
        $money->user_id = $user->id;
        foreach ($spendings as $list1) {
            $addedmoney += $list1->money;
        }
        if ($addedmoney +$money->money < 2147483647) {
            $money->save();
           return redirect()->action('GraphController@edit',[$user->id]);
        }
        return redirect('money')->with('message', 'insificent money');

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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $delete = Income::find($id);
        $delete->delete();
        return redirect()->action('GraphController@edit',[$user->id]);
    }
}
