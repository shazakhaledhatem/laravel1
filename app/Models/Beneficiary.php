<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;
    protected $fillable = [
       'male',
       'female',
       'malebreadwinnerforthefamily',
       'femalebreadwinnerforthefamily',
       'Youthwithoutfamily',
       'girlwithoutfamily',
       'orphans',
       'injured',
       'users_id',
       'displacedpeople',
       'totalnumberofchildern',
       'numberofdiablechildern',
       'phone',
       'Discription'
   ];
   public function healths() {
          return $this->belongsToMany(Health::class, 'beneficiaries_healths')
                      ->withPivot('status', 'active', 'charities_id');
      }
      public function education() {
             return $this->belongsToMany(Education::class, 'beneficiaries_educations')
                         ->withPivot('status', 'active', 'charities_id');
         }

         public function reliefs() {
                return $this->belongsToMany(Relief::class, 'beneficiaries__reliefs')
                            ->withPivot('status', 'active', 'charities_id');
            }

            public function lifehoods() {
                   return $this->belongsToMany(Life_hood::class, 'beneficiary__lifehoods')
                               ->withPivot('status', 'active', 'charities_id');
               }

   public function user() {
       return $this->belongsTo(User::class, 'user_id');
   }

}
