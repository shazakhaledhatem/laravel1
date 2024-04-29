<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Health;
use App\Models\Beneficiary_Health;
use App\Models\Education;
use App\Models\beneficiary_education;
use App\Models\Relief;
use App\Models\Beneficiary_Relief;
use App\Models\Life_hood;
use App\Models\beneficiary_lifehood;
use Auth;
use Illuminate\Support\Facades\Validator;
class BeneficiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function show(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function edit(Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Beneficiary $beneficiary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beneficiary  $beneficiary
     * @return \Illuminate\Http\Response
     */

    public function destroy(Beneficiary $beneficiary)
    {
        //
    }


   public function beneficiaryorderfromhealthsection(Request $request) {
    // Check if user is logged in

    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized - Login required'], 401);
    }

    $existingHealth = Health::where('typeofdisease', $request->typeofdisease)
           ->where('operation', $request->operation)
           ->where('doctorcheck', $request->doctorcheck)
           ->where('medicine', $request->medicine)
           ->where('medicaldevice', $request->medicaldevice)
           ->where('typeofdevice', $request->typeofdevice)
           ->where('milkanddiaper', $request->milkanddiaper)
           ->first();

           $user=Beneficiary::where('users_id', Auth::id());
           if ($existingHealth&&$user) {

               DB::commit();  // Assuming you might have other operations before that need committing
               return response()->json(['message' => 'You have already made a similar order.'], 409);
           }

    // Assuming you have validated other data as needed
    try {


        DB::beginTransaction();

        $beneficiary = Beneficiary::create([
            'male' => $request->input('male', false),  // default to false if not provided
            'female' => $request->input('female', false),
            'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
            'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
            'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
            'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
            'orphans' => $request->input('orphans', false),
            'injured' => $request->input('injured', false),
            'users_id' => Auth::id(),  // This will set users_id to the id of the logged-in user
            'displacedpeople' => $request->input('displacedpeople', false),
            'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
            'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
            'phone' => $request->input('phone'),
            'Discription' => $request->input('Discription')
        ]);
$health=Health::create([
  'typeofdisease' => $request->input('typeofdisease'),
  'operation'=> $request->input('operation', false),
  'doctorcheck'=> $request->input('doctorcheck', false),
  'medicine'=> $request->input('medicine', false),
  'medicaldevice'=> $request->input('medicaldevice', false),
  'typeofdevice'=> $request->input('typeofdevice'),
  'milkanddiaper'=> $request->input('milkanddiaper', false)
]);


//dd($beneficiaries_id);

$beneficiary__health=Beneficiary_Health::create([
  'beneficiaries_id' => $beneficiary->id,
      'healths_id' => $health->id,
      'charities_id' => NULL,
      'status' => $request->input('status'),
      'active' => $request->input('active',0)
]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
        DB::commit();
        return response()->json([
                  'message' => 'you request a health order successfully',
                   'data' => [$beneficiary,$beneficiary__health,$health],
                   'pagination' => $paginatedBeneficiaries
               ], 201);    }
                catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Error processing your request: ' . $e->getMessage()], 500);
    }
}


   public function beneficiaryorderfromhealthcharity(Request $request, $id) {
    // Check if user is logged in

    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized - Login required'], 401);
    }

    // Assuming you have validated other data as needed
    try {
        DB::beginTransaction();

        $beneficiary = Beneficiary::create([
            'male' => $request->input('male', false),  // default to false if not provided
            'female' => $request->input('female', false),
            'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
            'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
            'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
            'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
            'orphans' => $request->input('orphans', false),
            'injured' => $request->input('injured', false),
            'users_id' => Auth::id(),  // This will set users_id to the id of the logged-in user
            'displacedpeople' => $request->input('displacedpeople', false),
            'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
            'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
            'phone' => $request->input('phone'),
            'Discription' => $request->input('Discription')
        ]);


$existingHealth = Health::where('typeofdisease', $request->typeofdisease)
       ->where('operation', $request->operation)
       ->where('doctorcheck', $request->doctorcheck)
       ->where('medicine', $request->medicine)
       ->where('medicaldevice', $request->medicaldevice)
       ->where('typeofdevice', $request->typeofdevice)
       ->where('milkanddiaper', $request->milkanddiaper)
       ->first();
       if ($existingHealth) {

           DB::commit();  // Assuming you might have other operations before that need committing
           return response()->json(['message' => 'You have already made a similar order.'], 409);
       }
//dd($beneficiaries_id);
$health=Health::create([
  'typeofdisease' => $request->input('typeofdisease'),
  'operation'=> $request->input('operation', false),
  'doctorcheck'=> $request->input('doctorcheck', false),
  'medicine'=> $request->input('medicine', false),
  'medicaldevice'=> $request->input('medicaldevice', false),
  'typeofdevice'=> $request->input('typeofdevice'),
  'milkanddiaper'=> $request->input('milkanddiaper', false)
]);

$beneficiary__health=Beneficiary_Health::create([
  'beneficiaries_id' => $beneficiary->id,
      'healths_id' => $health->id,
      'charities_id' => $id,
      'status' => $request->input('status'),
      'active' => $request->input('active',0)
]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
        DB::commit();
        return response()->json([
                  'message' => 'you request a health order successfully',
                   'data' => [$beneficiary,$beneficiary__health,$health],
                   'pagination' => $paginatedBeneficiaries
               ], 201);    }
                catch (\Exception $e) {
        DB::rollback();
        return response()->json(['message' => 'Error processing your request: ' . $e->getMessage()], 500);
    }
}








public function beneficiaryorderfromeducationsection(Request $request) {
 // Check if user is logged in
 if (!Auth::check()) {
     return response()->json(['message' => 'Unauthorized - Login required'], 401);
 }

 // Assuming you have validated other data as needed
 try {
     DB::beginTransaction();

     $beneficiary = Beneficiary::create([
         'male' => $request->input('male', false),  // default to false if not provided
         'female' => $request->input('female', false),
         'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
         'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
         'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
         'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
         'orphans' => $request->input('orphans', false),
         'injured' => $request->input('injured', false),
         'users_id' => Auth::id(),  // This will set users_id to the id of the logged-in user
         'displacedpeople' => $request->input('displacedpeople', false),
         'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
         'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
         'phone' => $request->input('phone'),
         'Discription' => $request->input('Discription')
     ]);

$existingEducation = Education::where('typeofeducation', $request->typeofeducation)
       ->where('clothes', $request->clothes)
       ->where('booksandpens', $request->booksandpens)
       ->where('courses', $request->courses)
       ->where('bags', $request->bags)
       ->first();
       if ($existingEducation) {

           DB::commit();  // Assuming you might have other operations before that need committing
           return response()->json(['message' => 'You have already made a similar order.'], 409);
       }


       $education=Education::create([
       'typeofeducation' => $request->input('typeofeducation'),
       'clothes'=> $request->input('clothes', false),
       'booksandpens'=> $request->input('booksandpens', false),
       'courses'=> $request->input('courses', false),
       'bags'=> $request->input('bags', false)

       ]);
$beneficiary__education=beneficiary_education::create([
'beneficiaries_id' => $beneficiary->id,
   'education_id' => $education->id,
   'charities_id' => NULL,
   'status' => $request->input('status'),
   'active' => $request->input('active',0)
]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
                'message' => 'you request a education order successfully',
                   'data' => [$beneficiary,$beneficiary__education,$education],
                'pagination' => $paginatedBeneficiaries
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json(['message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}



public function beneficiaryorderfromeducationcharity(Request $request, $id) {
 // Check if user is logged in
 if (!Auth::check()) {
     return response()->json(['message' => 'Unauthorized - Login required'], 401);
 }

 // Assuming you have validated other data as needed
 try {
     DB::beginTransaction();

     $beneficiary = Beneficiary::create([
         'male' => $request->input('male', false),  // default to false if not provided
         'female' => $request->input('female', false),
         'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
         'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
         'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
         'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
         'orphans' => $request->input('orphans', false),
         'injured' => $request->input('injured', false),
         'users_id' => Auth::id(),  // This will set users_id to the id of the logged-in user
         'displacedpeople' => $request->input('displacedpeople', false),
         'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
         'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
         'phone' => $request->input('phone'),
         'Discription' => $request->input('Discription')
     ]);
$existingEducation = Education::where('typeofeducation', $request->typeofeducation)
       ->where('clothes', $request->clothes)
       ->where('booksandpens', $request->booksandpens)
       ->where('courses', $request->courses)
       ->where('bags', $request->bags)
       ->first();
       if ($existingEducation) {

           DB::commit();  // Assuming you might have other operations before that need committing
           return response()->json(['message' => 'You have already made a similar order.'], 409);
       }


       $education=Education::create([
       'typeofeducation' => $request->input('typeofeducation'),
       'clothes'=> $request->input('clothes', false),
       'booksandpens'=> $request->input('booksandpens', false),
       'courses'=> $request->input('courses', false),
       'bags'=> $request->input('bags', false)

       ]);

$beneficiary__education=beneficiary_education::create([
'beneficiaries_id' => $beneficiary->id,
   'education_id' => $education->id,
   'charities_id' => $id,
   'status' => $request->input('status'),
   'active' => $request->input('active',0)
]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
                'message' => 'you request a education order successfully',
                   'data' => [$beneficiary,$beneficiary__education,$education],
                'pagination' => $paginatedBeneficiaries
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json(['message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}





public function beneficiaryorderfromreliefsection(Request $request) {
 // Check if user is logged in
 if (!Auth::check()) {
     return response()->json(['message' => 'Unauthorized - Login required'], 401);
 }

 // Assuming you have validated other data as needed
 try {
     DB::beginTransaction();

     $beneficiary = Beneficiary::create([
         'male' => $request->input('male', false),  // default to false if not provided
         'female' => $request->input('female', false),
         'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
         'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
         'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
         'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
         'orphans' => $request->input('orphans', false),
         'injured' => $request->input('injured', false),
         'users_id' => Auth::id(),  // This will set users_id to the id of the logged-in user
         'displacedpeople' => $request->input('displacedpeople', false),
         'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
         'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
         'phone' => $request->input('phone'),
         'Discription' => $request->input('Discription')
     ]);


$existingRelief = Relief::where('home', $request->home)
       ->where('housefurniture', $request->housefurniture)
       ->where('food', $request->food)
       ->where('clothes', $request->clothes)
       ->where('money', $request->money)
       ->where('psychologicalaid', $request->psychologicalaid)
       ->first();
       if ($existingRelief) {

           DB::commit();  // Assuming you might have other operations before that need committing
           return response()->json(['message' => 'You have already made a similar order.'], 409);
       }
       $relief=Relief::create([
       'home' => $request->input('home', false),
       'housefurniture'=> $request->input('housefurniture', false),
       'food'=> $request->input('food', false),
       'clothes'=> $request->input('clothes', false),
       'money'=> $request->input('money', false),
       'psychologicalaid'=> $request->input('psychologicalaid', false)
       ]);
$beneficiary__relief=Beneficiary_Relief::create([
'beneficiaries_id' => $beneficiary->id,
   'reliefs_id' => $relief->id,
   'charities_id' => NULL,
   'status' => $request->input('status'),
   'active' => $request->input('active',0)
]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
                'message' => 'you request a relief order successfully',
                   'data' => [$beneficiary,$beneficiary__relief,$relief],
                'pagination' => $paginatedBeneficiaries
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json(['message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}

public function beneficiaryorderfromreliefcharity(Request $request, $id) {
 // Check if user is logged in
 if (!Auth::check()) {
     return response()->json(['message' => 'Unauthorized - Login required'], 401);
 }

 // Assuming you have validated other data as needed
 try {
     DB::beginTransaction();

     $beneficiary = Beneficiary::create([
         'male' => $request->input('male', false),  // default to false if not provided
         'female' => $request->input('female', false),
         'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
         'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
         'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
         'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
         'orphans' => $request->input('orphans', false),
         'injured' => $request->input('injured', false),
         'users_id' => Auth::id(),  // This will set users_id to the id of the logged-in user
         'displacedpeople' => $request->input('displacedpeople', false),
         'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
         'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
         'phone' => $request->input('phone'),
         'Discription' => $request->input('Discription')
     ]);


$existingRelief = Relief::where('home', $request->home)
       ->where('housefurniture', $request->housefurniture)
       ->where('food', $request->food)
       ->where('clothes', $request->clothes)
       ->where('money', $request->money)
       ->where('psychologicalaid', $request->psychologicalaid)
       ->first();
       if ($existingRelief) {

           DB::commit();  // Assuming you might have other operations before that need committing
           return response()->json(['message' => 'You have already made a similar order.'], 409);
       }
       $relief=Relief::create([
       'home' => $request->input('home', false),
       'housefurniture'=> $request->input('housefurniture', false),
       'food'=> $request->input('food', false),
       'clothes'=> $request->input('clothes', false),
       'money'=> $request->input('money', false),
       'psychologicalaid'=> $request->input('psychologicalaid', false)
       ]);
$beneficiary__relief=Beneficiary_Relief::create([
'beneficiaries_id' => $beneficiary->id,
   'reliefs_id' => $relief->id,
   'charities_id' => $id,
   'status' => $request->input('status'),
   'active' => $request->input('active',0)
]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
                'message' => 'you request a relief order successfully',
                   'data' => [$beneficiary,$beneficiary__relief,$relief],
                'pagination' => $paginatedBeneficiaries
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json(['message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}


public function beneficiaryorderfromlifehoodsection(Request $request) {
 // Check if user is logged in
 if (!Auth::check()) {
     return response()->json(['message' => 'Unauthorized - Login required'], 401);
 }

 // Assuming you have validated other data as needed
 try {
     DB::beginTransaction();

     $beneficiary = Beneficiary::create([
         'male' => $request->input('male', false),  // default to false if not provided
         'female' => $request->input('female', false),
         'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
         'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
         'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
         'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
         'orphans' => $request->input('orphans', false),
         'injured' => $request->input('injured', false),
         'users_id' => Auth::id(),  // This will set users_id to the id of the logged-in user
         'displacedpeople' => $request->input('displacedpeople', false),
         'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
         'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
         'phone' => $request->input('phone'),
         'Discription' => $request->input('Discription')
     ]);



$existingLifeHood = Life_hood::where('learningaprofession', $request->learningaprofession)
       ->where('gainmoreexperienceinspecificfield', $request->gainmoreexperienceinspecificfield)
       ->where('typeofworkthatyouwanttogain', $request->typeofworkthatyouwanttogain)
       ->where('jobapportunity', $request->jobapportunity)
       ->first();

  if ($existingLifeHood) {

      DB::commit();  // Assuming you might have other operations before that need committing
      return response()->json(['message' => 'You have already made a similar order.'], 409);
  }
  $lifehood=Life_hood::create([
  'learningaprofession' => $request->input('learningaprofession', false),
  'gainmoreexperienceinspecificfield'=> $request->input('gainmoreexperienceinspecificfield', false),
  'typeofworkthatyouwanttogain'=> $request->input('typeofworkthatyouwanttogain'),
  'jobapportunity'=> $request->input('jobapportunity', false)

  ]);
$beneficiary__lifehood=Beneficiary_Lifehood::create([
'beneficiaries_id' => $beneficiary->id,
   'lifehoods_id' => $lifehood->id,
   'charities_id' => NULL,
   'status' => $request->input('status'),
   'active' => $request->input('active',0)
]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
                'message' => 'you request a lifehood order successfully',
                   'data' => [$beneficiary,$beneficiary__lifehood,$lifehood],
                'pagination' => $paginatedBeneficiaries
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json(['message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}

public function beneficiaryorderfromlifehoodcharity(Request $request, $id) {
 // Check if user is logged in
 if (!Auth::check()) {
     return response()->json(['message' => 'Unauthorized - Login required'], 401);
 }

 // Assuming you have validated other data as needed
 try {
     DB::beginTransaction();

     $beneficiary = Beneficiary::create([
         'male' => $request->input('male', false),  // default to false if not provided
         'female' => $request->input('female', false),
         'malebreadwinnerforthefamily' => $request->input('malebreadwinnerforthefamily', false),
         'femalebreadwinnerforthefamily' => $request->input('femalebreadwinnerforthefamily', false),
         'Youthwithoutfamily' => $request->input('Youthwithoutfamily', false),
         'girlwithoutfamily' => $request->input('girlwithoutfamily', false),
         'orphans' => $request->input('orphans', false),
         'injured' => $request->input('injured', false),
         'users_id' => Auth::id(),  // This will set users_id to the id of the logged-in user
         'displacedpeople' => $request->input('displacedpeople', false),
         'totalnumberofchildern' => $request->input('totalnumberofchildern', 0),
         'numberofdiablechildern' => $request->input('numberofdiablechildern', 0),
         'phone' => $request->input('phone'),
         'Discription' => $request->input('Discription')
     ]);



$existingLifeHood = Life_hood::where('learningaprofession', $request->learningaprofession)
       ->where('gainmoreexperienceinspecificfield', $request->gainmoreexperienceinspecificfield)
       ->where('typeofworkthatyouwanttogain', $request->typeofworkthatyouwanttogain)
       ->where('jobapportunity', $request->jobapportunity)
       ->first();

  if ($existingLifeHood) {

      DB::commit();  // Assuming you might have other operations before that need committing
      return response()->json(['message' => 'You have already made a similar order.'], 409);
  }
  $lifehood=Life_hood::create([
  'learningaprofession' => $request->input('learningaprofession', false),
  'gainmoreexperienceinspecificfield'=> $request->input('gainmoreexperienceinspecificfield', false),
  'typeofworkthatyouwanttogain'=> $request->input('typeofworkthatyouwanttogain'),
  'jobapportunity'=> $request->input('jobapportunity', false)

  ]);

$beneficiary__lifehood=Beneficiary_Lifehood::create([
'beneficiaries_id' => $beneficiary->id,
   'lifehoods_id' => $lifehood->id,
   'charities_id' => $id,
   'status' => $request->input('status'),
   'active' => $request->input('active',0)
]);
$paginatedBeneficiaries = Beneficiary::latest()->paginate(10);
     DB::commit();
     return response()->json([
                'message' => 'you request a lifehood order successfully',
                   'data' => [$beneficiary,$beneficiary__lifehood,$lifehood],
                'pagination' => $paginatedBeneficiaries
            ], 201);    }
             catch (\Exception $e) {
     DB::rollback();
     return response()->json(['message' => 'Error processing your request: ' . $e->getMessage()], 500);
 }
}

}
