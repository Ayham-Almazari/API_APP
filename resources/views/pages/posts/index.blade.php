@extends('layouts.admin')
@section('title','under-verification-factories')
@section('content')
    <!--__CONTENT__-->
    <h1 style=";font-weight: bold;border-bottom:2px solid #01356C;margin: 9% auto 3%;width: fit-content"><i>Deleted Factories Under Verification</i> </h1>
    <div class="container">
        <div class="row">
            <table class="table table-hover {{-- {{url()->current()==route('trashed.index')?'table-danger':'table-success'}}--}}">
                <div class="badge bg-dark" style="height: 50px;width: 100%">
                    <h1 style="font-size: large;font-weight: bold;margin-top: 5px">All Posts
                        {{-- @if (url()->current()!=route('trashed.index'))--}}
                        <a href="{{--{{route('posts.create')}}--}}" class="btn btn-success float-end">Add Post</a>
                        {{--@endif--}}
                    </h1>
                </div>
                <tr class="">
                    <th>Image</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
                @forelse($factories as $factory)
                <tr class="{{--{{session()->has('created') && (session()->get('created')==$post->title)?'C_A':''}}--}}">
                    <td class=""><img src="{{--{{ asset('storage/'.$post->image) }}--}}" alt="..." width="50px" height="50px"></td>
                    <td class=""><h2>{{--{{$post->title}}--}}</h2></td>
                    <td class="">
                   <span class="">
                        <form action="{{--{{route('posts.destroy',$post->id)}}--}}" method="post" class="btn btn-danger">
                            @method('Delete')--}}
                        <input type="submit" class="btn btn-danger" value="{{--{{$post->trashed()?'Remove':'Trash'}}--}}" style="padding: 0">
                        </form>
                           <a href="{{--{{route('posts.edit',['post'=>$post->id])}}--}}" class="btn btn-primary"> Edit </a>
                           <a href="{{--{{route('trashed.restore',['post'=>$post->id])}}--}}" class="btn btn-success"> Restore </a>
                    </span>
                    </td>
                </tr>
                 @empty
                    <div class="alert alert-success mt-5" role="alert">
                        <h4 class="alert-heading">No Factories To verify</h4>
                        <p>This page show the factories under verify , when the owner built factory the factory will appear here .</p>
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
