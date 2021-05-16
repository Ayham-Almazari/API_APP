<?php

namespace App\Http\Controllers\API\Admin\ViewsAJax;

use App\Http\Controllers\Controller;
use App\Http\Traits\Responses_Trait;
use App\Models\Admin;
use App\Models\Buyer;
use App\Models\Owner;
use Illuminate\Http\Request;

class UsersViews extends Controller
{
    use Responses_Trait;
    public function index()
    {

        return view('pages.users.index')->withAdmins(Admin::all())->withAdminsCount(Admin::count())
                                        ->withBuyers(Buyer::all())->withBuyersCount(Buyer::count())
                                        ->withOwners(Owner::all())->withOwnersCount(Owner::count());
    }
    //delete admin
    public function deleteadmin(Admin $admin){
        $admin->forceDelete();
        return  $this->returnSuccessMessage("Admin Removed successfully .");
    }
    //srearch for users to make hem admin
    public function search(Request $request)
    {
            $output="";
            $buyers=Buyer::where('username','LIKE','%'.$request->search."%")->take(6)->get();
            if($buyers)
                foreach ($buyers as $key => $buyer) :
                    $picture=$buyer->profile->picture;
                    $output.=<<<HTML
                    <tr class='add-admin-tr' username="$buyer->username">
                    <td><img src="$picture" width="50px" height="50px"></td>
                    <td><span style="font-size: 1.3vw" >$buyer->username</span></td>
        </tr>
HTML;
                endforeach;
            return response($output);
    }
}
