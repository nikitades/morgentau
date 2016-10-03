@if ($errors->any())
    <ul class="alert alert-danger alert-nice">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
@if(Session::has('message'))
    <p class="alert alert-info">{{ Session::get('message') }}</p>
@endif
@if(Session::has('success-message'))
    <p class="alert alert-success">{{ Session::get('success-message') }}</p>
@endif