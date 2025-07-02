@extends('layouts.app')

@section('content')
@auth
    

    <div class="hero-section py-5 mb-4 text-center text-white" style="background: linear-gradient(90deg, #1976d2 0%, #43a047 100%); border-radius: 1rem;">
        <div class="container">
            <i class="bi bi-speedometer2" style="font-size:3rem;"></i>
            <h1 class="display-5 fw-bold mt-2">Selamat Datang di Dashboard</h1>
            <p class="lead">Pantau statistik produk dan info penting di sini</p>
        </div>
    </div>
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card p-4 text-center shadow border-0 card-stat h-100" style="background: linear-gradient(135deg, #1976d2 60%, #2196f3 100%); color: #fff; border-radius: 1rem; transition: transform .2s;">
                    <div class="mb-2"><i class="bi bi-box" style="font-size:2.5rem;"></i></div>
                    <h5 class="mb-1">Total Produk</h5>
                    <h2 class="fw-bold">{{ $data->count() }}</h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card p-4 text-center shadow border-0 card-stat h-100" style="background: linear-gradient(135deg, #43a047 60%, #66bb6a 100%); color: #fff; border-radius: 1rem; transition: transform .2s;">
                    <div class="mb-2"><i class="bi bi-cash-stack" style="font-size:2.5rem;"></i></div>
                    <h5 class="mb-1">Total Harga</h5>
                    <h2 class="fw-bold">Rp {{ number_format($data->sum('price'), 0, ',', '.') }}</h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card p-4 text-center shadow border-0 card-stat h-100" style="background: linear-gradient(135deg, #fbc02d 60%, #fff176 100%); color: #333; border-radius: 1rem; transition: transform .2s;">
                    <div class="mb-2"><i class="bi bi-person" style="font-size:2.5rem;"></i></div>
                    <h5 class="mb-1">Developer Terdaftar</h5>
                    <h2 class="fw-bold">{{ $data->unique('developer')->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card p-4 shadow border-0" style="border-radius: 1rem;">
                    <h4 class="mb-4 fw-bold">Statistik Produk Bulanan</h4>
                    <canvas id="productChart" height="120"></canvas>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card p-4 shadow border-0" style="border-radius: 1rem;">
                    <h5 class="mb-3 fw-bold">Info Singkat</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">Harga Tertinggi: <span class="badge bg-danger fw-bold">Rp {{ number_format($data->max('price'), 0, ',', '.') }}</span></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">Harga Terendah: <span class="badge bg-primary fw-bold">Rp {{ number_format($data->min('price'), 0, ',', '.') }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endauth
    @guest
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Halaman Login</h1>
                </div>
            </div>
        </div>
    @endguest
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('productChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(25, 118, 210, 0.4)');
    gradient.addColorStop(1, 'rgba(25, 118, 210, 0.05)');
    const productChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Produk Masuk',
                data: @json($produkPerBulan),
                borderColor: '#1976d2',
                backgroundColor: gradient,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointBackgroundColor: '#1976d2',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 5 }
                }
            }
        }
    });
</script>
@endpush

@push('styles')
<style>
.card-stat:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 8px 32px rgba(25, 118, 210, 0.15);
}
.hero-section {
    background-size: cover;
    background-position: center;
}
</style>
@endpush