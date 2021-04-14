<div style="text-align: center">
    <div>
        <input wire:model="search" type="text" placeholder="Search users..."/>

        <ul style="background-color: black;color: #cbd5e0;list-style-type: none;width: 80px;position: absolute;top: 50%;left:50%;transform: translate(-50%,-50%)">
            @forelse($users as $user)
                <li>{{ $user->username }}</li>
                <li>{{ $user->profile->first_name . '  ' .$user->profile->last_name}}</li>
                <li><img src="{{ $user->property_file }}" alt="photo"></li>
                <hr>
            @empty
                <h1>NOooO</h1>
            @endforelse
        </ul>
    </div>

</div>
