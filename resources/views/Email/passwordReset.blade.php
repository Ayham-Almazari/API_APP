@component('mail::message')
    <h1 style="letter-spacing: 5px;font-weight: bold;text-align: center">Reset password Code</h1>
    <div style="text-align: center;padding: 20px;background: darkgreen">
    <span style="letter-spacing: 25px;font-weight: bold;font-size: 20px;color: black">
        @foreach(explode(',',$code) as $char)
            <span>{{$char}}</span>
        @endforeach
    </span>
    </div>
@component('mail::button', [ 'url' => null,'color' => 'success'])
reset password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
