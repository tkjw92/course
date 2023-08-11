<nav class="navbar bg-primary">
    <div class="container">
        <h5 class="text-white" style="opacity: 0">Course</h5>
        <div class="dropdown">
            <button class="bg-transparent border-0 dropdown-toggle text-white text-capitalize" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ $name }}
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
{{-- <div class="bg-primary container-fluid">
    <div class="container p-2 d-flex align-items-center justify-content-between">
        <h5 class="text-white" style="opacity: 0">Course</h5>
        <div class="dropdown">
            <button class="bg-transparent border-0 dropdown-toggle text-white text-capitalize" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ $name }}
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</div> --}}
