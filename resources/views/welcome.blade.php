@extends('layouts.app')

@section('content')
<style>
.hero {
    background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('{{ asset('images/hero.jpg') }}');
    background-size: cover;
    background-position: center;
}
</style>
<div class="vh-100 d-flex flex-column justify-content-between hero">
    
<!-- Hero Section -->
<section class=" d-flex align-items-center justify-content-center text-center text-white mt-5 p-5">
    <div class="container mt-5">
        <h1 class="display-4 fw-bold mt-5">Horizon Bank</h1>
        <p class="lead">Your gateway to seamless online banking and financial solutions.</p>
        <div class="d-flex flex-column align-items-center gap-3">
            @guest
            <a href="{{ route('register') }}" class="btn btn-success btn-lg">Register</a>
            @endguest
            @auth
            <a href="{{ route('dashboard') }}" class="btn btn-success btn-lg">Dashboard</a>
            @endauth
            <a href="{{ route('atms') }}" class="btn btn-primary btn-lg">See ATM Locations</a>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">

            <!-- Service 1: Online Banking -->
            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fa-solid fa-laptop fs-1 text-success"></i>
                        </div>
                        <h5 class="card-title fw-bold">Online Banking</h5>
                        <p class="card-text">Manage your accounts and transactions anytime, anywhere.</p>
                    </div>
                </div>
            </div>

            <!-- Service 2: Loans -->
            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="card border-0 shadow-sm w-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fa-solid fa-landmark fs-1 text-success"></i>
                        </div>
                        <h5 class="card-title fw-bold">Loans</h5>
                        <p class="card-text">Flexible loan options to meet your financial needs.</p>
                    </div>
                </div>
            </div>

            <!-- Service 3: Currency Rates -->
            <div class="col-md-4 mb-4 d-flex justify-content-center">
                <div class="card border-0 shadow-sm w-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fa-solid fa-money-bill-wave fs-1 text-success"></i>
                        </div>
                        <h5 class="card-title fw-bold">Currency Rates</h5>
                        <p class="card-text">Stay updated with the latest foreign exchange rates.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer Section -->
<footer class="bg-dark text-white py-4 justify-end">
    <div class="container text-center">
        <p class="mb-1">&copy; {{ date('Y') }} Learn Bank. All Rights Reserved.</p>
        <div>
            <a href="#" class="text-white me-3"><i class="fa-brands fa-facebook fs-4"></i></a>
            <a href="#" class="text-white me-3"><i class="fa-brands fa-twitter fs-4"></i></a>
            <a href="#" class="text-white me-3"><i class="fa-brands fa-instagram fs-4"></i></a>
        </div>
    </div>
</footer>

</div>



@endsection
