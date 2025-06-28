@include('components.layouts.edara.body.head')
@persist('player')
@include('components.layouts.edara.body.sidebar')
@endpersist
        {{ $slot }}
        
    
@include('components.layouts.edara.body.footer')