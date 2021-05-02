<?php

namespace App\Http\Controllers\API\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnderVerificationDeleteOwnerFactoryController extends Controller
{
    private $factories ;
    public function __construct()
    {
        $this->factories= new UnderVerificationFactoryController();
        $this->middleware(['auth:admin']);
    }

    public function index(){
        return $this->factories->index(1);
    }

    public function DeleteFactory($id) {
        return $this->factories->destroy($id,1);
    }

    public function RestoreFactory($id) {
        return $this->factories->show($id,1);
    }
}
