<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Expenses;
use App\Graphs;
use App\Income;
use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\Session;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $curentTime = \Carbon\Carbon::now()->isoFormat('Y-M-D');
        $user = auth()->user();
        $income = Graphs::where('user_id', $user->id)->first('money');
        $spendings = Expenses::where('user_id', $user->id)->get();
        $listincome = Income::where('user_id', $user->id)->get();
        $monthleyEarnings = Income::where('user_id', $user->id)->get();
        $endmoney = 0;
        foreach ($spendings as $x) {
            $endmoney += $x->money;
        }
        $endmoney = $income->money - $endmoney;


        $options = [
            'curentTime' => $curentTime,
            'user' => $user,
            'income' => $income,
            'spendings' => $spendings,
            'listincome' => $listincome,
            'monthleyEarnings' => $monthleyEarnings,
            'endmoney' => $endmoney,
        ];
        return view('mainpage', $options);
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
        //
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
    public function edit(Request $request, $id)
    {
        $spendings = Income::where('user_id', $id)->get();

        $addedmoney = 0;
        foreach ($spendings as $x) {
            $addedmoney += $x->money;
        }
        $data = Graphs::find($id);
        $data->money = $addedmoney;
        $data->save();


        return redirect('money');
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
        $data = Expenses::find($id);
        $add = Expenses::find($id);

        $data->money = request('money') + $add->money;

        $data->save();
        return redirect('money');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function goal(Request $request)
    {
        $user = auth()->user();
        $monthleyEarnings = Income::where('user_id', $user->id)->get();
        $result = 0;
        $goal = (int)$request->input('goal');
        $goal_money = $request->input('goal_money');
        foreach ($monthleyEarnings as $x) {
            $result = $result + $x->money;
        }
        $results = (round($goal_money / $goal));


        return redirect('money')->with('goal', $results);
    }
}
