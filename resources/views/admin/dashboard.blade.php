@extends('layouts.admin')

@section('content')
<div class="container mt-3">
    <h1>Admin Dashboard</h1>
    <div class="row mb-5">
        <!-- Total Product Views Card -->
        <div class="d-flex justify-content-around">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h4 class="card-title">Total Product Views</h4>
                    <p class="card-text display-4">{{ $totalViews }}</p>
                </div>
            </div>
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h4 class="card-title">Total Product Sales</h4>
                    <p class="card-text display-4">{{ $totalSales }}</p>
                </div>
            </div>
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h4 class="card-title">Total Users</h4>
                    <p class="card-text display-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Charts -->
    <div class="mb-5">
        <h2>Sales Analytics</h2>
        <div class="row">
            <div class="col-md-4">
                <canvas id="dailySalesChart"></canvas>
            </div>
            <div class="col-md-4">
                <canvas id="monthlySalesChart"></canvas>
            </div>
            <div class="col-md-4">
                <canvas id="yearlySalesChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data for the charts (replace with dynamic data via AJAX or Blade variables)
    const dailySalesData = @json($dailySales);
    const monthlySalesData = @json($monthlySales);
    const yearlySalesData = @json($yearlySales);

    // Chart configurations
    new Chart(document.getElementById('dailySalesChart'), {
        type: 'line',
        data: {
            labels: dailySalesData.labels,
            datasets: [{
                label: 'Daily Sales',
                data: dailySalesData.values,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
            }],
        },
    });

    new Chart(document.getElementById('monthlySalesChart'), {
        type: 'bar',
        data: {
            labels: monthlySalesData.labels,
            datasets: [{
                label: 'Monthly Sales',
                data: monthlySalesData.values,
                backgroundColor: '#28a745',
            }],
        },
    });

    new Chart(document.getElementById('yearlySalesChart'), {
        type: 'pie',
        data: {
            labels: yearlySalesData.labels,
            datasets: [{
                label: 'Yearly Sales',
                data: yearlySalesData.values,
                backgroundColor: ['#007bff', '#ffc107', '#dc3545', '#17a2b8', '#28a745'],
            }],
        },
    });
</script>
@endsection