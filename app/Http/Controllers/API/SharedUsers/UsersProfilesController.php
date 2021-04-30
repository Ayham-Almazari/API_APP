<?php

namespace App\Http\Controllers\API\SharedUsers;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\UpdateUsersProfilesRequest;
use App\Models\BuyerOrder;
use App\Models\OwnerOrder;
use App\Models\UsersProfiles;
use Illuminate\Http\Request;

class UsersProfilesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UsersProfiles  $usersProfiles
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        return $this->returnData(auth()->user()->load('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UsersProfiles  $usersProfiles
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUsersProfilesRequest $request)
    {
        authorization_issues:
        if (auth()->user()->phone !== $request->phone) $request->validate(['phone'    => ["unique:buyers",'unique:admins','unique:owners']]);
        if (auth()->user()->username !== $request->username) $request->validate(['username' => 'unique:buyers|unique:admins|unique:owners']);
        if (auth()->user()->email !== $request->email) $request->validate(['email'    => 'unique:buyers|unique:admins|unique:owners']);
        if (!(auth()->attempt(['email'=>auth()->user()->email,'password'=>$request->password]))) return $this->returnErrorMessage('Invalid Password .');

        prepare_data_for_update:
        $user_info=$request->only(['email','phone','username']);
        $user_profile=\Arr::only($request->validated(),['first_name','last_name','picture','instagram','facebook','address']);

        update_image:
        $update_image = $this->update_image($request->user()->profile->picture,
            auth()->user()->getJWTCustomClaims()['role'].'s/profile-images', $user_profile['picture']);
        $user_profile['picture'] = $update_image ? $update_image->uploaded_image : null;

        update_user_info:
            auth()->user()->profile()->update($user_profile);
            auth()->user()->update($user_info);
            if ($request->user()->isBuyer())
                BuyerOrder::where('buyer_id', $request->user()->id)->update($user_profile);
            if ($request->user()->isOwner())
                OwnerOrder::where('owner_id', $request->user()->id)->update($user_profile);

        response:
        return $this->returnData(auth()->user()->load('profile'),msg:"User Information Updated Successfully .",HTTP: 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UsersProfiles  $usersProfiles
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        if (!(auth()->attempt(['email'=>auth()->user()->email,'password'=>$request->password]))) return $this->returnErrorMessage('Invalid Password .');
        if ($request->user()->isBuyer() || $request->user()->isOwner()){ $request->user()->delete() ;return $this->returnSuccessMessage("User Deleted Successfully . Wait to confirm your request from admin .");}
        elseif ($request->user()->isAdmin()) return $this->returnErrorMessage(msg: "back to your supervisor");
    }
}
