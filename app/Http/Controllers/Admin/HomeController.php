<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PcdMasterUserModel;
use App\Models\ScheduleMaintenance;
use App\Models\ScheduleMaster;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       return view('admin.home', ['title'=>'Dashboard','jumlah_user'=>'16','total_plan_wo'=>'100','total_wo_completed'=>'60','total_wo_pending'=>'5']);
    }
}
