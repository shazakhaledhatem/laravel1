<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Health extends Model
{
    use HasFactory;
    protected $fillable = [
       'typeofdisease',
       'operation',
       'doctorcheck',
       'medicine',
       'medicaldevice',
       'typeofdevice',
       'milkanddiaper'
   ];

   public function beneficiaries() {
        return $this->belongsToMany(Beneficiary::class, 'beneficiaries_healths')
                    ->withPivot('status', 'active', 'charities_id');
    }
}
