<div class="d-flex flex-column flex-shrink-0 p-3 shadow-lg vh-100 sticky-top" style="width: 280px;">
    <a href="/admin" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="fs-4">Admin Control</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item row">
            <a href="/admin" class="nav-link link-dark {{ Request::is('admin') ? 'active' : '' }}">
                <i class="fa-solid fa-book col-2"></i>
                Course
            </a>
        </li>
        <li class="nav-item row">
            <a href="/admin/quiz" class="nav-link link-dark {{ Request::is('admin/quiz') ? 'active' : '' }}">
                <i class="fa-solid fa-file-pen col-2"></i>
                Quiz
            </a>
        </li>
        <li class="nav-item row">
            <a href="/admin/certificate" class="nav-link link-dark {{ Request::is('admin/certificate') ? 'active' : '' }}">
                <i class="fa-solid fa-certificate col-2"></i>
                Certificate
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-user rounded-circle bg-dark m-2 p-2 text-center" style="color: #fff;width: 32px;height: 32px"></i>
            <strong>Muhammad Nizar Ramli</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item" href="/logout">Sign out</a></li>
        </ul>
    </div>
</div>
