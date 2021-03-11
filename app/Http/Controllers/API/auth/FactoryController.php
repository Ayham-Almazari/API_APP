<?php

namespace App\Http\Controllers\API\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\Login_buyer;
use App\Http\Requests\auth\Register_buyer;
use App\Http\Traits\auth\{ChangePassword,PasswordResetRequest};
use App\Http\Traits\Responses_Trait;
use App\Models\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class FactoryController extends Controller
{

}
