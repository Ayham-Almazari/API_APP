<div class="container-fluid aside admin-aside">
    <div class="row min-vj-100 flex-column flex-md-row admin-aside">
        <aside class="col-12 col-md-3 col-xl-2 p-0 bg-dark flex-shrink-1 admin-aside">
            <nav id="sidebar"
                 class="navbar-expand-md navbar-dark bd-dark flex-md-column flex-row algin-items-center py-2 text-center">
                <button type="button" class="navbar-toggler border-0 oder-1"
                        data-bs-target="#nav" aria-controls="nav"
                        aria-expanded="false" aria-label="Toggle navigation" data-bs-toggle="collapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-last" id="nav">
                    <ul class="navbar-nav flex-column w-100 justify-content-center">
                        @php
                            const count_btn="<span class='badge bg-primary badge-pill'> </span>";
                            $nav_items=[
                            "Factories Under Verification"=>[
                            "class"=>"nav-link justify-content-between ",
                            "id"=>"Under_Verification_Factories",
                            "loading-id"=>1
                            ],
                            "Owners Under Verification"=>[
                            "class"=>"nav-link justify-content-between",
                            "id"=>"Under_Verification_Owners",
                            "loading-id"=>2
                            ],
                            "Deleted Factories Under Verification"=>[
                            "class"=>"nav-link justify-content-between",
                            "id"=>"Under_Verification_Deleted_Factories",
                            "loading-id"=>3
                            ],
                            "Manage Factories"=>[//
                            "class"=>"nav-link justify-content-between",
                            "id"=>"Manage_Factories",
                            "loading-id"=>5
                            ],
                            "Statistics"=>[
                            "class"=>"nav-link justify-content-between",
                            "id"=>"Under_Verification_Deleted_Factories",
                            "loading-id"=>null
                            ],
                            "Manage Users"=>[
                            "class"=>"nav-link justify-content-between",
                            "id"=>"users",
                            "loading-id"=>4
                            ]
                            ];
                        @endphp
                        @foreach($nav_items as $nav_item => $nav_detail)
                            <li  class="nav-item" for="{{$nav_detail['loading-id']}}">
                                <a href=""
                                   class="{{$nav_detail['class']}} ayham"
                                   id="{{$nav_detail['id']}}">
                                    {{$nav_item}}
                                </a>
                                <i style='display: none;color:white'
                                   id="{{'loading-id-'.$nav_detail['loading-id']}}"
                                       class='fas fa-cog fa-spin faa-fast' >
                                </i>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </aside>
    </div>
</div>
<script src="{{mix('js/aside-nav-bar.js')}}"></script>
