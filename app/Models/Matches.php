<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;

    protected $table = 'matches';

    protected $primaryKey = ['match_id', 'match_partner_id'];

    public $incrementing = false;

    protected $guarded =[];

}
