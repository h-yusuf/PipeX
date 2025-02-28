@extends('layouts.admin')

@section('content')
<div class="mb-lg-4 container-fluid">
    <h2 class="mb-3">{{$title}}</h2>
    <div class="row">
        <div class="col-3">
            <div class="card border-left-primary shadow-sm h-75 py-2 border-12">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Main Power</div>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"> Total PM Monthly </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h3 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $total_plan_wo }}
                                    </div>
                                </div>
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
                                Total WO Completed</div>
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
                                Total WO Pending</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800">{{ $total_wo_pending }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-gray shadow-sm" style="margin-top:-4px">
        <!-- <div class="card-header h4">{{ $title}}</div> -->

        <!-- First Chart (Single Column at the Top) -->
        <div class="row pb-4 bg-gray">
            <div class="col-4">
                <div id="chart-yearly" class="border-12" style="height: 350px;"></div>
            </div>
            <div class="col-md-4">
                <div id="chart-monthly" class="border-12" style="height: 350px;"></div>
            </div>
            <div class="col-md-4">
                <div id="chart-weekly" class="border-12" style="height: 350px;"></div>
            </div>
        </div>


        <!-- Calendar Section -->
        <div class="row">
            <div class="py-2 px-4 border-12" style="background-color:white;">
                <div>
                    <div id="calendar"></div>
                    <div class="px-4">
                        <!-- Status Legend Section -->
                        <!-- <h4 class="pt-2">Status Legend</h4> -->
                        <div class="d-flex justify-content-end flex-wrap py-3" style="gap: 20px;">
                            <div class="agenda-item">
                                <div class="agenda-color fc-1-month"></div>
                                <span>1 Month</span>
                            </div>
                            <div class="agenda-item">
                                <div class="agenda-color fc-3-months"></div>
                                <span>3 Months</span>
                            </div>
                            <div class="agenda-item">
                                <div class="agenda-color fc-6-months"></div>
                                <span>6 Months</span>
                            </div>
                            <div class="agenda-item">
                                <div class="agenda-color bg-info"></div>
                                <span>1 Year</span>
                            </div>
                            <div class="agenda-item">
                                <div class="agenda-color bg-primary"></div>
                                <span>Corrective</span>
                            </div>
                            <div class="agenda-item">
                                <div class="agenda-color fc-close"></div>
                                <span>Close</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection