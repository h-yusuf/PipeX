<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    use HasFactory;
    protected $table = 'employee';

    protected $fillable = [
        'name',
        'npk',
        'username',
        'password',
        'password_hash',
        'status',
        'updated_at',
        'created_at',
    ];
}
