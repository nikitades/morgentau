@if ($errors->any())
    <ul class="alert alert-danger alert-nice">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif