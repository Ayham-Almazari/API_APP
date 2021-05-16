<div class="col-md-4 adminCount" >
    <div class="card text-white bg-dark">
        <div class="card-header">Admins</div>
        <div class="card-body" id="countaminstodecrease">{{$AdminsCount}}</div>
    </div>
</div>
<div class="container" id="AdminsTable" style="display: none">
    <div class="row">
        <table class="table table-hover">
            <div class="badge bg-dark" style="margin-top: 20%;height: 50px;width: 100%">
                <h1 style="font-size: large;font-weight: bold;margin-top: 5px">All Admins<a href="" class="btn btn-success float-end" id="btn-add-admin">Add Admin</a>
                </h1>
            </div>
            <tr class="">
                <th>Picture</th>
                <th>Owner Name</th>
                <th style="text-indent: 22%">Email</th>
                <th style="text-indent: 22%">Actions</th>
            </tr>
            @forelse($Admins as $admins)
                <tr class="table-row" id="admin_view_{{$admins->id}}">
                    <td class=""><img src="{{$admins->profile->picture}}" alt="..." width="50px" height="50px"></td>
                    <td class=""><h2>{{$admins->profile->first_name . " " . $admins->profile->last_name }}</h2></td>
                    <td class=""><h2 class="factory-name" style="font-size: 1.5vw">{{$admins->email}}</h2></td>
                    <td class="">
                   <span class="">
                      <a href="" class="btn btn-danger remove_admin" admin_id="{{$admins->id}}">Force Delete</a>
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
<div class="container bg-dark" id="AddAdminRequest">
    <i class="close-alert fas fa-times"></i>
    <label for="Username" style="margin-right: 5px">username : </label>
    <input autocomplete="off" type="text" class="form-controller" id="searchforadmins" name="search" style="width:140px ;margin: 2px auto;border: none;border-bottom: 1px solid blue"/>
    <table border="0" class="table table-hover" style="width: fit-content ;margin: 2px auto">
        <tbody id="tabledata" style="color: white">
        </tbody>
    </table>
</div>
