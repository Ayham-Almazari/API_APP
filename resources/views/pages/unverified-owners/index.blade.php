@extends('layouts.admin')
@section('css',asset("css/under_verification_factories.css"))
@section('title',"UnderVerificationFactories")
@section('content')
    <!--__CONTENT__-->
    <h1 style="border-bottom-left-radius: 10px;border-bottom-right-radius:10px;font-weight: bold;border-bottom:2px solid #01356C;margin: 9% auto 3%;width: fit-content"><i>Owners Under Verification</i> </h1>
    <div class="container">
        <div class="row">
            @forelse($owners as $owner)
                <div class="card bg-dark text-white col-lg-6 mt-1" id="factory_view_{{$owner->id}}">
                    <a  id="{{$owner->id}}" class="property_file_container" href="#image">
                        <img class="property_file" id="property_file_{{$owner->id}}" src="{{$owner->property_file}}"  width="300px"  height="200px" alt="..."
                             style="margin-left: -13px">
                    </a>
                    <div class="card-img-overlay" style="margin-left: 300px">
                        <a href="" class="chip">
                            <img src="{{$owner->profile->picture}}"  alt="Person" width="96" height="96"/>
                            <span class="owner-name" style="font-size: 1vw"> {{$owner->profile->first_name . " " . $owner->profile->last_name }}</span>
                        </a>
                        <h2 class="factory-name" style="font-size: 1vw">{{$owner->email}}</h2>
                        <a factory_id="{{$owner->id}}" href=""
                           class="btn btn-success confirm_factory"> Confirm </a>

                        <a  factory_id="{{$owner->id}}" href=""
                            class="btn btn-danger cancel_factory"> Force Delete </a>
                    </div>
                </div>
            @empty
                <div class="alert alert-success mt-5" role="alert">
                    <h4 class="alert-heading">No owners To verify</h4>
                    <p>This page show the owners under verify , when the owner built account the account will appear here .</p>
                    <hr>
                    <p class="mb-0">Be accurate and sure of the ownership file that the owner has uploaded before making the decision to confirm or delete .</p>
                </div>
            @endforelse

        </div>
    </div>
    <script src="{{asset('js/under_verification_owner.js')}}"></script>
    <!--END__CONTENT__-->
@stop

