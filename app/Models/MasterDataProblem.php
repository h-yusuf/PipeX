<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDataProblem extends Model
{
    use HasFactory;

    protected $table = 'master_data_problem';
    
    protected $primaryKey = 'ID_NO';

    protected $fillable = ['TYPE_PROBLEM'];
}
