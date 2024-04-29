<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary_Lifehood extends Model
{
    use HasFactory;
    protected $fillable = [
       'beneficiaries_id',
       'lifehoods_id',
       'charities_id',
       'status',
       'active'
   ];
   public function lifehood()
   {
       return $this->belongsTo(Life_hood::class, 'lifehoods_id');
   }

   // Define relationship to Beneficiary
   public function beneficiary()
   {
       return $this->belongsTo(Beneficiary::class, 'beneficiaries_id');
   }
}
