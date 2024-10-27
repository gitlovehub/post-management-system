@extends('admin.master')

@section('title')
    Admin | Dashboard
@endsection

@section('h1')
    Dashboard
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-info text-white rounded shadow d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-list fa-3x"></i>
                <div class="ms-3">
                    <h5 class="mb-2">Total Categories</h5>
                    <h6 class="mb-0 fw-bold">{{ $totalCategories }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-danger text-white rounded shadow d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-file-alt fa-3x"></i>
                <div class="ms-3">
                    <h5 class="mb-2">Total Posts</h5>
                    <h6 class="mb-0 fw-bold">{{ $totalPosts }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-success text-white rounded shadow d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-eye fa-3x"></i>
                <div class="ms-3">
                    <h5 class="mb-2">Total Views</h5>
                    <h6 class="mb-0 fw-bold">{{ $totalViews }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary text-white rounded shadow d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-user fa-3x"></i>
                <div class="ms-3">
                    <h5 class="mb-2">Total Users</h5>
                    <h6 class="mb-0 fw-bold">{{ $totalUsers }}</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-light rounded p-4">
        <h4 class="mb-4">Số lượng bài viết trong 1 tuần wa</h4>
        <canvas id="postsChart"></canvas>
    </div>

    <script>
        const postsLabels = {!! $postsLabels !!}; // nhận dữ liệu từ controller
        const postsData = {!! $postsData !!}; // nhận dữ liệu từ controller
    
        const ctx = document.getElementById('postsChart').getContext('2d');
        const postsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: postsLabels,
                datasets: [{
                    label: 'Số lượng bài viết',
                    data: postsData,
                    backgroundColor: 'rgba(255, 105, 180, 0.6)',
                    borderColor: 'rgba(255, 105, 180, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    
@endsection
