<x-email-layout
:image="asset($image)"
    title="Thanks for uploading!"
>
   Hi {{$user->name}}, <br/>
    Your Tenant: {{app('currentTenant')->name}}
</x-email-layout>
