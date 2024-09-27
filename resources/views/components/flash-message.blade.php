@if (session()->has('Message'))
    <div class="alert alert-success alert-dismissible fade show text-center w-50 mx-auto" style="left: 0; right: 0;">
        <p class="mb-0">
            {{ session('Message') }}
        </p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
