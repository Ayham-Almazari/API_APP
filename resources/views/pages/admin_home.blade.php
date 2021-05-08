@extends('layouts.admin')
@section('content')
    <!--__CONTENT__-->
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
                {{-- @forelse($posts as $post)--}}
                <tr class="{{--{{session()->has('created') && (session()->get('created')==$post->title)?'C_A':''}}--}}">
                    <td class=""><img src="{{--{{ asset('storage/'.$post->image) }}--}}" alt="..." width="50px" height="50px"></td>
                    <td class=""><h2>{{--{{$post->title}}--}}</h2></td>
                    <td class="">
                   <span class="">
                        <form action="{{--{{route('posts.destroy',$post->id)}}--}}" method="post" class="btn btn-danger">
                           {{-- @csrf
                            @method('Delete')--}}
                        <input type="submit" class="btn btn-danger" value="{{--{{$post->trashed()?'Remove':'Trash'}}--}}" style="padding: 0">
                        </form>
                      {{-- @if (!$post->trashed())--}}
                           <a href="{{--{{route('posts.edit',['post'=>$post->id])}}--}}" class="btn btn-primary"> Edit </a>
                     {{--  @else--}}
                           <a href="{{--{{route('trashed.restore',['post'=>$post->id])}}--}}" class="btn btn-success"> Restore </a>
                     {{--  @endif--}}
                    </span>
                    </td>
                </tr>
                {{-- @empty--}}
                <div class="card-body">No Posts yet !</div>
                {{--@endforelse--}}

            </table>
        </div>
    </div>
    <!--END__CONTENT__-->
@endsection
@section('scripts')
    <script src="{{asset('js/HomeAdmin.js')}}"></script>
@endsection
{{--
@section("css",asset('css/'))
--}}
