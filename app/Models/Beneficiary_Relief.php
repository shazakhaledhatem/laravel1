<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary_Relief extends Model
{
    use HasFactory;
    //protected $table = 'beneficiaries__reliefs';

   protected $fillable = ['beneficiaries_id', 'reliefs_id', 'charities_id', 'active', 'status'];
}
