@extends('layouts.admin')
@section('css',asset("css/under_verification_factories.css"))
@section('title',"UnderVerificationFactories")
@section('content')
    <!--__CONTENT__-->
    <h1 style="border-bottom-left-radius: 10px;border-bottom-right-radius:10px;font-weight: bold;border-bottom:2px solid #01356C;margin: 9% auto 3%;width: fit-content"><i>Factories Under Verification</i> </h1>
    <div class="container">
        <div class="row">
            @forelse($factories as $factory)
                <div class="card bg-dark text-white col-lg-6 mt-1" id="factory_view_{{$factory->id}}">
                    <a  id="{{$factory->id}}" class="property_file_container" href="#image">
                        <img class="property_file" id="property_file_{{$factory->id}}" src="{{$factory->property_file}}"  width="300px"  height="200px" alt="..."
                                style="margin-left: -13px">
                    </a>
                    <div class="card-img-overlay" style="margin-left: 300px">
                        <a href="{{--{{route('users.show',$post->user->id)}}--}}" class="chip">
                            <img src="{{$factory->owner->profile->picture}}"  alt="Person" width="96" height="96"/>
                            <span class="owner-name"> {{$factory->owner->profile->first_name . " " . $factory->owner->profile->last_name }}</span>
                        </a>
                        <h2 class="factory-name">{{$factory->factory_name}}</h2>
                        <a factory_id="{{$factory->id}}" href=""
                           class="btn btn-success confirm_factory"> Confirm </a>
                        <a  factory_id="{{$factory->id}}" href=""
                            class="btn btn-danger cancel_factory"> Remove </a>
                    </div>
                </div>
                @empty
                    <div class="alert alert-success mt-5" role="alert">
                        <h4 class="alert-heading">No Factories To verify</h4>
                        <p>This page show the factories under verify , when the owner built factory the factory will appear here .</p>
                        <hr>
                        <p class="mb-0">Be accurate and sure of the ownership file that the owner has uploaded before making the decision to confirm or delete .</p>
                    </div>
            @endforelse

          {{--  <div class="container">
                    {{$factories->links()}}
                </div>--}}
        </div>
    </div>
    <script src="{{mix('js/shared pages.js')}}"></script>
    <script src="{{asset('js/under_verification_factories.js')}}"></script>
    <!--END__CONTENT__-->
@stop

