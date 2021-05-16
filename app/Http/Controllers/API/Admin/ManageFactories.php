<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Responses_Trait;
use App\Models\Factory;
use Illuminate\Http\Request;

class ManageFactories extends Controller
{
    use Responses_Trait;
    public function UpdateFactoryPermissions(Request $request,Factory $factory)
    {
        $factory->CanAddCategory_Control($request->CanAddCategory);
        $factory->CanUpdateCategory_Control($request->CanUpdateCategory);
        $factory->CanAddProduct_Control($request->CanAddProduct);
        $factory->CanUpdateProduct_Control($request->CanUpdateProduct);

        return $this->returnSuccessMessage("Permissions Updated Successfully .");
    }
}
