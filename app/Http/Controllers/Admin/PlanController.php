<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Illuminate\Http\Request;
use App\Models\Membership\Plan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanRequest;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        return view('admin.plan.index');
    }

    public function data()
    {
        $plans = Plan::latest()->get();
        return DataTables::of($plans)
                ->addColumn('action', function($cuks){
                    return view('layouts._action',[
                        'url_edit' => route('admin::plan.edit', $cuks->id),
                        'url_destroy' => route('admin::plan.destroy', $cuks->id),
                        'title' => $cuks->name
                    ]);
                })
                ->addIndexColumn()->rawColumns(['action'])->make(true);
    }

    public function create()
    {
        $plan = new Plan();
        return view('admin.plan.form',compact('plan'));
    }

    public function store(PlanRequest $request)
    {
        $plan = Plan::create($request->all());
        return $plan;
    }

    public function edit(Plan $plan)
    {
        return view('admin.plan.form', compact('plan'));
    }

    public function update(PlanRequest $request, Plan $plan)
    {
        $plan->update($request->all());
        return $plan;
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->json([
            'message' => 'Successfully Deleted',
        ], 200);
    }
}
