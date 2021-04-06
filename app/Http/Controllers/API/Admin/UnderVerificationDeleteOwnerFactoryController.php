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
        $this->middleware(['auth:admin','jwt.verify:admin']);
    }

    public function index(){
        return $this->factories->index();
    }

    public function DeleteFactory($id) {
        return $this->factories->destroy($id,1);
    }

    public function RestoreFactory($id) {
        return $this->factories->update($id,1);
    }
}
