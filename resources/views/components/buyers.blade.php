<div class="col-md-4 buyerCount" >
    <div class="card text-white bg-dark">
        <div class="card-header">Buyers</div>
        <div class="card-body">{{$buyersCount}}</div>
    </div>
</div>
<div class="container" id="BuyersTable" style="display: none">
    <div class="row">
        <table class="table table-hover">
            <div class="badge bg-dark" style="margin-top: 20%;height: 50px;width: 100%">
                <h1 style="font-size: large;font-weight: bold;margin-top: 5px">All Buyers</h1>
            </div>
            <tr class="">
                <th>Picture</th>
                <th>Owner Name</th>
                <th style="text-indent: 22%">Email</th>
                <th style="text-indent: 22%">Actions</th>
            </tr>
            @forelse($buyers as $buyer)
                <tr class="table-row" id="factory_view_{{$buyer->id}}">
                    <td class=""><img src="{{$buyer->profile->picture}}" alt="..." width="50px" height="50px"></td>
                    <td class=""><h2>{{$buyer->profile->first_name . " " . $buyer->profile->last_name }}</h2></td>
                    <td class=""><h2 class="factory-name" style="font-size: 1.5vw">{{$buyer->email}}</h2></td>
                    <td class="">
                   <span class="">
                      <a href="" class="btn btn-danger cancel_factory" buyer_id="{{$buyer->id}}">Force Delete</a>
                       <a href="" class="btn btn-success confirm_factory" buyer_id="{{$buyer->id}}"> Restore </a>
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
