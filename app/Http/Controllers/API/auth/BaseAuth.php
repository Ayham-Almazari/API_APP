<?php


namespace App\Http\Controllers\API\auth;


use App\Http\Traits\auth\Auth as Locally_Auth;
use App\Http\Traits\Responses_Trait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BaseAuth
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,Responses_Trait,Locally_Auth;
}
