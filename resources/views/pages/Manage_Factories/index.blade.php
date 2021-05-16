@extends('layouts.admin')
@section('title','Factories Manage')
@section('content')
    <!--__CONTENT__-->
    <x-factories/>
    <div class="row row-cols-1 row-cols-md-3 g-4" id="component" style="margin-top: 20%;z-index: -1">
        @foreach($factories as $factory)
            <div class="col">
                <div class="card">
                    <img src="{{$factory->cover_photo}}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <img  src="{{$factory->logo}}" class="card-title" alt="..." width="50px" height="50px">
                        <h4 class="card-title">{{$factory->factory_name}}</h4>
                        <span style="position: absolute;right: 0;bottom:30% ">
                    <a href="{{$factory->facebook}}"><i class="fab fa-facebook-square" style="color: #0a53be;font-size: 35px"></i></a>
                    <a href="{{$factory->instagram}}"><i class="fab fa-instagram" style="  color: #fff;
                    background: #d6249f;
  background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%,#d6249f 60%,#285AEB 90%);
  box-shadow: 0px 3px 10px rgba(0,0,0,.25);font-size: 35px;
 "></i></a>
                    </span>
                        <p class="card-text">
                        {{--Modals--}}
                        <div class="modal fade" id="description{{$factory->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalToggleLabel">{{$factory->factory_name}} Description </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{$factory->description}}.
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="contact{{$factory->id}}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalToggleLabel">Contact</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Phone : <span style="color: #0d0d0d">{{$factory->phone}}</span><br/>
                                        Email : <span style="color: #0d0d0d">{{$factory->email}}</span>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="permissions{{$factory->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Factory {{$factory->factory_name}} Permissions</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                     <div class="modal-body">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="CanAddCategory{{$factory->id}}" {{$factory->canAddCategory()?"checked":null}}>
                                            <label class="form-check-label" for="CanAddCategory{{$factory->id}}">Can add new Categories .</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="CanUpdateCategory{{$factory->id}}" {{$factory->CanUpdateCategory()?"checked":null}}>
                                            <label class="form-check-label" for="canUpdateCategory{{$factory->id}}">Can update existing categories .</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="CanAddProduct{{$factory->id}}" {{$factory->CanAddProduct()?"checked":null}}>
                                            <label class="form-check-label" for="canAddProduct{{$factory->id}}">Can add new products .</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="CanUpdateProduct{{$factory->id}}" {{$factory->CanUpdateProduct()?"checked":null}}>
                                            <label class="form-check-label" for="canUpdateProduct{{$factory->id}}">Can update existing products .</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary ChangePermissions" forfactory="{{$factory->id}}">Save changes <i style='display: none' class='fas fa-cog fa-spin faa-fast loading-btn'></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Button trigger modal -->
                        <a class="btn btn-primary" data-bs-toggle="modal" href="#description{{$factory->id}}" role="button">Description</a>
                        <a class="btn btn-primary" data-bs-toggle="modal" href="#contact{{$factory->id}}" role="button">Contact</a>
                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#permissions{{$factory->id}}">
                            Permissions
                        </button>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <script async src="{{asset('js/manage_factories.js')}}"></script>
    <!--END__CONTENT__-->
@endsection
