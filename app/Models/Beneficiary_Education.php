<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary_Education extends Model
{
    use HasFactory;
    protected $fillable = ['beneficiaries_id', 'education_id', 'charities_id', 'active', 'status'];
}
