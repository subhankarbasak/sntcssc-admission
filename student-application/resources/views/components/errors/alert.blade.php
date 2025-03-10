<!-- Updated component with customization options -->
@props(['title' => 'Something went wrong!!'])

@if ($errors->any())
<div {{ $attributes->merge(['class' => 'alert alert-danger alert-dismissible fade show']) }} role="alert">
    <h5 class="alert-heading mb-3">
        <i class="bi bi-exclamation-octagon-fill"></i> {{ $title }}
    </h5>
    
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif