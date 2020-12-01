@component('mail::message')
# Dear user!
Here is your token to reset your password
{{$token}}

Send your email, password, password_confirmation and token fields via API request
@component('mail::button', ['url' => 'http://http://instanter1231233.com/api/reset'])
API Request link
@endcomponent

@endcomponent
