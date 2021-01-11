<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Expenses;
use App\Graphs;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'money' => 'required|gt:-1|lte:2147483647',
            'goal' => 'required|gt:-1|lte:2147483647',
        ]);
        $user = auth()->user();
        $list = Expenses::where('user_id', $user->id)->get();
        $income = Graphs::where('user_id', $user->id)->first('money');
        $endmoney = 0;
        foreach ($list as $list1) {
            $endmoney += $list1->money;
        }
        
        $money = new Expenses;
        $money->expenses = request('expenses');
        $money->money = request('money');
        $money->goal = request('goal');
        $money->user_id = $user->id;
        if ($endmoney + $money->money >$income->money ) {
            return redirect('money')->with('message','insificent money');
        } else {
            $money->save();
            return redirect('money');
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Expenses::find($id);
        $delete->delete();
        return redirect('money')->with('Deleted','Deletion sucesfull');
    }
}
