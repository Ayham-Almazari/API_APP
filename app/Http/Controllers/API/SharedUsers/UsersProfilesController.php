<?php

namespace App\Http\Controllers\API\SharedUsers;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\UpdateUsersProfilesRequest;
use App\Jobs\UpdateBuyer__OWNEROrdersJob;
use App\Models\BuyerOrder;
use App\Models\OwnerOrder;
use App\Models\UsersProfiles;
use Arr;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersProfilesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param UsersProfiles $usersProfiles
     * @return JsonResponse
     */
    public function show()
    {
        return $this->returnData(auth()->user()->load('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param UsersProfiles $usersProfiles
     * @return JsonResponse
     */
    public function update(UpdateUsersProfilesRequest $request)
    {
        authorization_issues:
        if (auth()->user()->phone !== $request->phone) $request->validate(['phone' => ["unique:buyers", 'unique:admins', 'unique:owners']]);
        if (auth()->user()->username !== $request->username) $request->validate(['username' => 'unique:buyers|unique:admins|unique:owners']);
        if (auth()->user()->email !== $request->email) $request->validate(['email' => 'unique:buyers|unique:admins|unique:owners']);
        if (!(auth()->attempt(['email' => auth()->user()->email, 'password' => $request->password]))) return $this->returnErrorMessage('Invalid Password .');

        prepare_data_for_update:
        $user_info = $request->only(['email', 'phone', 'username']);
        $user_profile = Arr::only($request->validated(), ['first_name', 'last_name', 'picture', 'instagram', 'facebook', 'address']);

        update_image:
        if ($request->has('picture')):
            $update_image = $this->update_image($request->user()->profile->picture,
                auth()->user()->getJWTCustomClaims()['role'] . 's/profile-images', $user_profile['picture']);
            $user_profile['picture'] = $update_image ? $update_image->uploaded_image : null;
        endif;
        update_user_info:
        auth()->user()->profile()->update($user_profile);
        auth()->user()->update($user_info);
        update_users_profiles_for_orders:
        UpdateBuyer__OWNEROrdersJob::dispatch($request->user(), $user_profile, $request->picture)->delay(Carbon::now()->addSeconds(15));
        response:
        return $this->returnData(auth()->user()->load('profile'), msg: "User Information Updated Successfully .", HTTP: 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param UsersProfiles $usersProfiles
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        if (!(auth()->attempt(['email' => auth()->user()->email, 'password' => $request->password]))) return $this->returnErrorMessage('Invalid Password .');
        if ($request->user()->isBuyer() || $request->user()->isOwner()) {
            $request->user()->delete();
            return $this->returnSuccessMessage("User Deleted Successfully . Wait to confirm your request from admin .");
        } elseif ($request->user()->isAdmin()) return $this->returnErrorMessage(msg: "back to your supervisor");
    }
}
