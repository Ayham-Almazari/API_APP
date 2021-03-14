@component('mail::message')
    <h1> Hello {{$user->first_name}} {{$user->last_name}} , </h1><br>
    <h3 style="letter-spacing: 5px;font-weight: bold;text-align: center">Email Verification Code</h3>
    <div style="text-align: center;padding: 20px;background: darkgreen">
    <span style="letter-spacing: 25px;font-weight: bold;font-size: 20px;color: black">
        @foreach(explode(',',$code) as $char)
            <span>{{$char}}</span>
        @endforeach
    </span>
    </div>

@component('mail::button', [ 'url' => null,'color' => 'success'])
Email Verify
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
