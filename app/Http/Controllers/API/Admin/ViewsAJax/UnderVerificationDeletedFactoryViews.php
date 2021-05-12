<?php

namespace App\Http\Controllers\API\Admin\ViewsAJax;

use App\Http\Controllers\Controller;
use App\Http\Resources\FactoryCollection;
use App\Models\Factory;
use Illuminate\Http\Request;

class UnderVerificationDeletedFactoryViews extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //factories created and waiting to verify or canceled
        $factories= Factory::onlyTrashed()->where('deleted_at','<>','1998-12-30 23:00:00')->with('owner.profile')->get();
        return view('pages.deleted-factories.index',compact('factories'));
    }
}
