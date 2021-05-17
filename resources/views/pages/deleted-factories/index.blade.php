@extends('layouts.admin')
@section('title','deleted factories')
@section('content')
    <!--__CONTENT__-->
    <h1 style="border-bottom-left-radius: 10px;border-bottom-right-radius:10px;font-weight: bold;border-bottom:2px solid #01356C;margin: 9% auto 3%;width: fit-content"><i><span style="color:darkblue ">Deleted</span> Factories Under Verification</i> </h1>
    <div class="container">
        <div class="row">
            <table class="table table-hover">
                <div class="badge bg-dark" style="height: 50px;width: 100%">
                    <h1 style="font-size: large;font-weight: bold;margin-top: 5px">All Factories</h1>
                </div>
                <tr class="">
                    <th>Logo</th>
                    <th>Factory Name</th>
                    <th style="text-indent: 22%">Owner</th>
                    <th style="text-indent: 22%">Actions</th>
                </tr>
                @forelse($factories as $factory)
                        <tr class="table-row" id="factory_view_{{$factory->id}}">
                    <td class=""><img src="{{$factory->logo}}" alt="..." width="50px" height="50px"></td>
                    <td class=""><h2>{{$factory->factory_name}}</h2></td>
                    <td class=""><h2>{{$factory->owner->profile->first_name . ' ' . $factory->owner->profile->last_name}}</h2></td>
                    <td class="">
                   <span class="">
                      <a href="" class="btn btn-danger cancel_factory" factory_id="{{$factory->id}}">Force Delete</a>
                       <a href="" class="btn btn-success confirm_factory" factory_id="{{$factory->id}}"> Restore </a>
                    </span>
                    </td>
                </tr>
                 @empty
                    <div class="alert alert-success mt-5 "  role="alert">
                        <h4 class="alert-heading">No Factories to verify</h4>
                        <p>This page show the deleted factories under verify , when the owner delete factory the factory will appear here .</p>
                        <hr>
                        <p class="mb-0">Be accurate and sure of the ownership file that the owner has uploaded before making the decision to confirm or delete .</p>
                    </div>
                @endforelse

            </table>
        </div>
    </div>
    <script async src="{{mix('js/under_verification_deleted_factories.js')}}"></script>
    <!--END__CONTENT__-->
@endsection
