@extends('layouts.admin')

@section('content')
    <div class="mb-lg-4 container-fluid">
        <h2 class="mb-3">{{ $title }}</h2>
        <div class="row">
            @php
                $cards = [
                    ['title' => 'Main Power', 'value' => $jumlah_user, 'icon' => 'fas fa-bolt', 'color' => 'primary'],
                    ['title' => 'Total WO Planning', 'value' => $total_plan_wo, 'icon' => 'fas fa-calendar-check', 'color' => 'warning'],
                    ['title' => 'Total WO Completed', 'value' => $total_wo_completed, 'icon' => 'fas fa-check-circle', 'color' => 'success'],
                    ['title' => 'Total WO Canceled', 'value' => $total_wo_canceled, 'icon' => 'fas fa-times-circle', 'color' => 'danger'],
                ];
            @endphp


            @foreach($cards as $card)
                <div class="col-3">
                    <div class="card border-left-{{ $card['color'] }} shadow-sm h-75 py-2 border-12">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-{{ $card['color'] }} text-uppercase mb-1">
                                        {{ $card['title'] }}
                                    </div>
                                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $card['value'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="{{ $card['icon'] }} fa-2x text-{{ $card['color'] }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @php
            $chartGroups = [
                ['yearly', 'monthly', 'weekly'],
                ['completed', 'in-progress', 'canceled']
            ];
        @endphp

        @foreach ($chartGroups as $group)
            <div style="background-color: #F3F8FF !important;" class="card shadow-none  mt-3 p-3">
                <div class="row g-3 bg-gray"> 
                    @foreach ($group as $chart)
                        <div class="col-12 col-md-4 ">
                            <div id="chart-{{ $chart }}"  class="border-12" style="height: 350px;"></div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const yearlyStatuses = ['Pending', 'In Progress', 'Completed', 'Canceled'];
            const statusColors = {
                'Pending': '#f6c23e',       // Kuning
                'In Progress': '#4e73df',   // Biru
                'Completed': '#1cc88a',     // Hijau
                'Canceled': '#e74a3b'       // Merah
            };

            const createChart = (id, title, categories, series) => {
                Highcharts.chart(id, {
                    chart: { type: 'column' },
                    title: { text: title },
                    xAxis: { categories: categories, title: { text: 'Product Name' } },
                    yAxis: { title: { text: 'Total WO' } },
                    plotOptions: {
                        column: {
                            borderRadius: 5
                        }
                    },
                    series: series
                });
            };

            // Yearly
            const yearlyData = @json($yearly);
            const yearlyCategories = Object.keys(yearlyData);
            const yearlySeries = yearlyStatuses.map(status => ({
                name: status,
                color: statusColors[status],
                data: yearlyCategories.map(year => {
                    const item = yearlyData[year].find(d => d.status === status);
                    return item ? item.total : 0;
                })
            }));
            createChart('chart-yearly', 'Yearly WO', yearlyCategories, yearlySeries);

            // Monthly
            const monthlyData = @json($monthly);
            const monthlyCategories = Object.keys(monthlyData);
            const monthlySeries = yearlyStatuses.map(status => ({
                name: status,
                color: statusColors[status],
                data: monthlyCategories.map(month => {
                    const item = monthlyData[month].find(d => d.status === status);
                    return item ? item.total : 0;
                })
            }));
            createChart('chart-monthly', 'Monthly WO ({{ date('Y') }})', monthlyCategories, monthlySeries);

            // Weekly
            const weeklyData = @json($weekly);
            const weeklyCategories = Object.keys(weeklyData);
            const weeklySeries = yearlyStatuses.map(status => ({
                name: status,
                color: statusColors[status],
                data: weeklyCategories.map(week => {
                    const item = weeklyData[week].find(d => d.status === status);
                    return item ? item.total : 0;
                })
            }));
            createChart('chart-weekly', 'Weekly WO ({{ date('Y') }})', weeklyCategories, weeklySeries);

            // Completed WO
            createChart('chart-completed', 'Completed WO', @json($completedKeys), @json($completedChartData));

            // In Progress WO
            createChart('chart-in-progress', 'In Progress WO', @json($inProgressKeys), @json($inProgressChartData));

            // Canceled WO
            createChart('chart-canceled', 'Canceled WO', @json($canceledKeys), @json($canceledChartData));

        });
    </script>
@endsection