<x-mail::message>
# Welcome
Create a new website!

- **Username:** {{ $user['name'] }}
- **E-Mail:** {{ $user['email'] }}
- **Password:** {{ $user['password'] }}

<x-mail::button :url="$url">
    Login
</x-mail::button>

Link çalışmaz ise burayı deneyiniz. [{{ $url }}]({{ $url }})

Thanks, {{ config('app.name') }}
</x-mail::message>
