<?php

namespace App\Http\Controllers\API\Admin\ViewsAJax;

use App\Http\Controllers\Controller;
use App\Models\Factory;
use Illuminate\Http\Request;

class UnderVerificationFactoryViews extends Controller
{
    public function index(Request $r) {

        $factories= Factory::onlyTrashed()->where('deleted_at','=','1998-12-30 23:00:00')->with('owner.profile')->get();
        return view('pages.unverified-factories.index',compact('factories'));
    }

}
