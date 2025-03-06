<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderProgressLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'operator_id',
        'status',
        'description',
        'start_time',
        'end_time',
        'duration',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WoManagementModel::class, 'work_order_id');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
