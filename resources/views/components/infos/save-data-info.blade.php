@if (session()->has('success'))
    <div class="row mb-3">
        <div class="col">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close fa-solid fa-times" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif
@if (session()->has('failed'))
    <div class="row mb-3">
        <div class="col">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('failed') }}
                <button type="button" class="btn-close fa-solid fa-times" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif