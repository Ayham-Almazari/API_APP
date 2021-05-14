<?php

namespace App\Http\Controllers\API\Admin\ViewsAJax;

use App\Http\Controllers\Controller;
use App\Models\Factory;
use App\Models\Owner;
use Illuminate\Http\Request;

class UnderVerificationOwnersViews extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners= Owner::with('profile')->onlyTrashed()->get();
        return view('pages.unverified-owners.index',compact('owners'));
    }

}
