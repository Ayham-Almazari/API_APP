<?php

namespace App\Http\Controllers\API\FactoryControllers;

use App\Http\Resources\FactoryCollection;
use App\Models\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FactoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth:owner','jwt.verify:owner'])->except('index');
        Auth::shouldUse('owner');
    }

    public function index()
    {
       $ee= Factory::query()->select(['*'])->leftJoin('owners','id','=','owner_id')->get();

        return (new FactoryCollection($ee));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      return  auth()->user()->factories()->create(
          $request->all()
      );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function show(Factory $factory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factory $factory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Factory  $factory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factory $factory)
    {
        //
    }
}
