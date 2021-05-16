@extends('layouts.admin')
@section('css',asset("css/users.css"))
@section('title',"Users")
@section('content')
    <!--__CONTENT__-->
<div class="container" style="margin-top: 10%">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-8">
            <div class="row text-center">
             <x-admins></x-admins>
             <x-buyers></x-buyers>
             <x-owners></x-owners>
            </div>
        </div>
    </div>
</div>
<script async src="{{asset('js/users.js')}}"></script>
<!--END__CONTENT__-->
@endsection
