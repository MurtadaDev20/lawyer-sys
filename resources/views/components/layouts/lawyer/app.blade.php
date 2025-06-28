@include('components.layouts.lawyer.body.head')
@persist('player')
@include('components.layouts.lawyer.body.sidebar')
@endpersist
        {{ $slot }}
        
    
@include('components.layouts.lawyer.body.footer')