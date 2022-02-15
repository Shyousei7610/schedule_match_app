<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCompositePrimaryKey;

class Schedule extends Model
{
    use HasFactory;
    use HasCompositePrimaryKey;

    protected $primaryKey = ['schedule_id', 'schedule_number'];

    public $incrementing = false;

    protected $guarded =[];
}
