@extends('layouts.admin')
@section('content')
    <!--__CONTENT__-->
    <div class="container mt-5" style="">
        <div class="row">
            @foreach($factories as $factory)
                <div class="card bg-dark text-white col-lg-6 mt-1">
                    <img src="{{$factory->property_file}}"  width="300px"  height="200px" alt="..."
                         style="margin-left: -13px">
                    <div class="card-img-overlay" style="margin-left: 300px">
                        <a href="{{--{{route('users.show',$post->user->id)}}--}}" class="chip">
                            <img src="{{$factory->owner->profile->picture}}" alt="Person" width="96" height="96"/>
                            <span> {{$factory->owner->profile->first_name . " " . $factory->owner->profile->last_name }}</span>
                        </a>
                        <a href="{{--{{route('trashed.restore',['post'=>$post->id])}}--}}" class="btn btn-success"> Confirm </a>
                        <a href="{{--{{route('trashed.restore',['post'=>$post->id])}}--}}" class="btn btn-danger"> Cancel </a>
                        <h2>{{$factory->name}}</h2>
                    </div>
                </div>
            @endforeach
                <div class="container">
                    {{$factories->links()}}
                </div>
        </div>
    </div>
    <!--END__CONTENT__-->
@stop
{{--
@section("css",asset('css/'))
--}}
