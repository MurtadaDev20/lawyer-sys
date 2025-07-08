@include('components.layouts.customer.body.head')
@persist('sidebar-customer')
@include('components.layouts.customer.body.sidebar')
@endpersist
        {{ $slot }}
        
    
@include('components.layouts.customer.body.footer')