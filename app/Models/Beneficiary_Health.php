<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary_Health extends Model
{
    use HasFactory;
    protected $fillable = [
       'beneficiaries_id',
       'healths_id',
       'charities_id',
       'status',
       'active'
   ];
}
