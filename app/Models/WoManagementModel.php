<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WoManagementModel extends Model
{
    use HasFactory;

    protected $table = 'work_orders';

    protected $fillable = [
        'work_order_number',
        'product_id',
        'qty_progress',
        'quantity',
        'start_production',
        'finish_production',
        'due_date',
        'status',
        'operator_id',
    ];

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }
    public function progressLogs()
    {
        return $this->hasMany(WorkOrderProgressLog::class, 'work_order_id');
    }

}
