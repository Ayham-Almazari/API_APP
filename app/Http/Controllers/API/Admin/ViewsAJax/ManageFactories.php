<?php

namespace App\Http\Controllers\API\Admin\ViewsAJax;

use App\Http\Controllers\Controller;
use App\Models\Factory;

class ManageFactories extends Controller
{
    public function index()
    {
/*        try {*/
            return view('pages.Manage_Factories.index')->withFactories(Factory::all()->each(function (Factory $factory){
                $factory->load('F_permissions');
            }));
       /* }catch (\ErrorException $e){
            return $e->getMessage();
        }*/

    }
}
