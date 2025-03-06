@extends('layouts.admin')

@section('content')
    <div class="mb-lg-4 container-fluid">
        <h2 class="mb-3">{{$title}}</h2>
        <div class="row">
            <!-- Kartu statistik -->
            <div class="col-3">
                <div class="card border-left-primary shadow-sm h-75 py-2 border-12">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Main Power
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $jumlah_user }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card border-left-warning shadow-sm h-75 py-2 border-12">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total WO Planning
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800">
                                    {{ $total_plan_wo }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tools fa-2x text-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card border-left-info shadow-sm h-75 py-2 border-12">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total WO Completed
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $total_wo_completed }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-3">
                <div class="card border-left-success shadow-sm h-75 py-2 border-12">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total WO Canceled
                                </div>
                                <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $total_wo_canceled }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="card bg-gray shadow-sm mt-3">
            <div class="row pb-4">
                <div class="col-4">
                    <div id="chart-yearly" class="border-12" style="height: 350px;"></div>
                </div>
                <div class="col-4">
                    <div id="chart-monthly" class="border-12" style="height: 350px;"></div>
                </div>
                <div class="col-4">
                    <div id="chart-weekly" class="border-12" style="height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <!-- <div class="card bg-gray shadow-sm mt-3">
            <div class="row pb-4">
                <div class="col-4">
                    <div id="chart-completed" class="border-12" style="height: 350px;"></div>
                </div>
                <div class="col-4">
                    <div id="chart-in-progress" class="border-12" style="height: 350px;"></div>
                </div>
                <div class="col-4">
                    <div id="chart-cancled" class="border-12" style="height: 350px;"></div>
                </div>
            </div>
        </div> -->

@endsection

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                // Menyiapkan data Yearly
                const yearlyData = {!! json_encode($yearly) !!};
                const yearlyCategories = Object.keys(yearlyData);
                const yearlySeries = [];

                const yearlyStatuses = ['Pending', 'In Progress', 'Completed', 'Canceled'];
                yearlyStatuses.forEach(status => {
                    yearlySeries.push({
                        name: status,
                        data: yearlyCategories.map(year => {
                            const dataByStatus = yearlyData[year].find(item => item.status === status);
                            return dataByStatus ? dataByStatus.total : 0;
                        })
                    });
                });

                Highcharts.chart('chart-yearly', {
                    chart: { type: 'column' },
                    title: { text: 'Yearly WO' },
                    xAxis: { categories: yearlyCategories },
                    yAxis: { title: { text: 'Total WO' } },
                    series: yearlySeries
                });

                // Menyiapkan data Monthly
                const monthlyData = {!! json_encode($monthly) !!};
                const monthlyCategories = Object.keys(monthlyData);
                const monthlySeries = [];

                yearlyStatuses.forEach(status => {
                    monthlySeries.push({
                        name: status,
                        data: monthlyCategories.map(month => {
                            const dataByStatus = monthlyData[month].find(item => item.status === status);
                            return dataByStatus ? dataByStatus.total : 0;
                        })
                    });
                });

                Highcharts.chart('chart-monthly', {
                    chart: { type: 'column' },
                    title: { text: 'Monthly WO ({{ date('Y') }})' },
                    xAxis: { categories: monthlyCategories },
                    yAxis: { title: { text: 'Total WO' } },
                    series: monthlySeries
                });

                // Menyiapkan data Weekly
                const weeklyData = {!! json_encode($weekly) !!};
                const weeklyCategories = Object.keys(weeklyData);
                const weeklySeries = [];

                yearlyStatuses.forEach(status => {
                    weeklySeries.push({
                        name: status,
                        data: weeklyCategories.map(week => {
                            const dataByStatus = weeklyData[week].find(item => item.status === status);
                            return dataByStatus ? dataByStatus.total : 0;
                        })
                    });
                });

                Highcharts.chart('chart-weekly', {
                    chart: { type: 'column' },
                    title: { text: 'Weekly WO ({{ date('Y') }})' },
                    xAxis: { categories: weeklyCategories },
                    yAxis: { title: { text: 'Total WO' } },
                    series: weeklySeries
                });
// Completed chart
Highcharts.chart('chart-completed', {
    chart: { type: 'column' }, // Ganti jadi column untuk lebih jelas
    title: { text: 'Completed WO' },
    xAxis: {
        categories: {!! json_encode($completed->keys()) !!}, // Nama produk sebagai kategori
        title: { text: 'Product Name' }
    },
    yAxis: { 
        title: { text: 'Total WO Completed' }
    },
    series: {!! json_encode($completedChartData) !!}
});

// In Progress chart
Highcharts.chart('chart-in-progress', {
    chart: { type: 'column' },
    title: { text: 'In Progress WO' },
    xAxis: {
        categories: {!! json_encode($inProgress->keys()) !!}, // Nama produk sebagai kategori
        title: { text: 'Product Name' }
    },
    yAxis: { 
        title: { text: 'Total WO In Progress' }
    },
    series: {!! json_encode($inProgressChartData) !!}
});

// Canceled chart
Highcharts.chart('chart-canceled', {
    chart: { type: 'column' },
    title: { text: 'Canceled WO' },
    xAxis: {
        categories: {!! json_encode($canceled->keys()) !!}, // Nama produk sebagai kategori
        title: { text: 'Product Name' }
    },
    yAxis: { 
        title: { text: 'Total WO Canceled' }
    },
    series: {!! json_encode($canceledChartData) !!}
});

            });
        </script>
    @endsection