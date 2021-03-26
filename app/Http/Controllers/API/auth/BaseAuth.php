<?php


namespace App\Http\Controllers\API\auth;


use App\Http\Traits\auth\Auth as Locally_Auth;
use App\Http\Traits\Responses_Trait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
class BaseAuth extends Controller
{
    use Locally_Auth;
}
