<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">商品列表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact-us">聯絡我們</a>
                </li>
            </ul>
        </div>
        <div>
            <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#notifications" value="通知">
        </div>
    </div>
</nav>

@include('layouts.modal')
