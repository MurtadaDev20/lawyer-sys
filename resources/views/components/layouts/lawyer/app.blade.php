@include('components.layouts.lawyer.body.head')
@persist('sidebar-lawyer')
@include('components.layouts.lawyer.body.sidebar')
@endpersist
        {{ $slot }}
        
    
@include('components.layouts.lawyer.body.footer')