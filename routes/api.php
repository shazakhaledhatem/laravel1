<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\FeedbackController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



//Route::post('/login','App\Http\Controllers\UserController@login');



Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);
Route::get('/index', [UserController::class, 'index']);
Route::get('/showcharity/{id}', [UserController::class, 'show']);
// Web route
//Route::post('/beneficiary/healthordersection',[BeneficiaryController::class, 'beneficiaryorderfromsection']);

//order from section
Route::middleware('auth:api')->post('/beneficiary/order/health', [BeneficiaryController::class, 'beneficiaryorderfromhealthsection']);
Route::middleware('auth:api')->post('/beneficiary/order/education', [BeneficiaryController::class, 'beneficiaryorderfromeducationsection']);

Route::middleware('auth:api')->post('/beneficiary/order/relief', [BeneficiaryController::class, 'beneficiaryorderfromreliefsection']);
Route::middleware('auth:api')->post('/beneficiary/order/lifehood', [BeneficiaryController::class, 'beneficiaryorderfromlifehoodsection']);
//order from specific charity
Route::middleware('auth:api')->post('/beneficiary/order/health/{id}', [BeneficiaryController::class, 'beneficiaryorderfromhealthcharity']);
Route::middleware('auth:api')->post('/beneficiary/order/education/{id}', [BeneficiaryController::class, 'beneficiaryorderfromeducationcharity']);

Route::middleware('auth:api')->post('/beneficiary/order/relief/{id}', [BeneficiaryController::class, 'beneficiaryorderfromreliefcharity']);
Route::middleware('auth:api')->post('/beneficiary/order/lifehood/{id}', [BeneficiaryController::class, 'beneficiaryorderfromlifehoodcharity']);


Route::post('/feedback', [FeedbackController::class, 'store'])->middleware('auth:api');

Route::get('/userorders/{id}', [UserController::class, 'userorder'])->middleware('auth:api');
Route::post('/updateuserinformation/{id}', [UserController::class, 'updateprofile'])->middleware('auth:api');
Route::get('/export',  [UserController::class, 'export']);

/*
Route::post('/charity/register', [CharityController::class,'register']);
Route::post('/charity/login', [CharityController::class,'login']);
Route::get('/index', [CharityController::class, 'index']);
*/
