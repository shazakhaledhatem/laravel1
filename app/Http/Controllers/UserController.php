<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

  public function export() {
      $data = User::all(); // Fetch data from your model
      return response()->json($data);
  }




  public function createUser(Request $request)
{
  try {
      //Validated
      $validateUser = Validator::make($request->all(), [
          'firstName' => 'required',
          'lastName' => 'required',
          'phone' => 'required',
          'address' => 'required',
          'type' => 'required',
          'email' => 'required|email|unique:users,email',
          'password' => 'required'
      ]);

      if ($validateUser->fails()) {
          return response()->json([
              'status' => false,
              'message' => 'Validation error',
              'errors' => $validateUser->errors()
          ], 401);
      }

      $user = User::create([
          'firstName' => $request->firstName,
          'lastName' => $request->lastName,
          'phone' => $request->phone,
          'address' => $request->address,
          'type' => $request->type,
          'email' => $request->email,
          'password' => Hash::make($request->password)
      ]);

      // Fetch paginated list of users
      $users = User::paginate(10); // Adjust the pagination as needed
  $user=['token' => $user->createToken("API TOKEN")->plainTextToken,'user' =>$user];
      return response()->json([
          'status' => true,
          'message' => 'User Created Successfully',
        //  'token' => $user->createToken("API TOKEN")->plainTextToken,
          'data' => $user,
          'pagination' => [
          'current_page' => $users->currentPage(),
          'total_pages' => $users->lastPage(),
          'total_items' => $users->total(),
          'items_per_page' => $users->perPage(),
          'first_item' => $users->firstItem(),
          'last_item' => $users->lastItem(),
          'has_more_pages' => $users->hasMorePages(),
          'next_page_url' => $users->nextPageUrl(),
          'previous_page_url' => $users->previousPageUrl(),
      ],
      ], 200);

  } catch (\Throwable $th) {
      return response()->json([
          'status' => false,
          'message' => $th->getMessage()
      ], 500);
  }
}

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
              'email' => 'required|email',
              'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();
            $users = User::paginate(10); // Adjust the pagination as needed
           $user=['token' => $user->createToken("API TOKEN")->plainTextToken,'user' =>$user];
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
            //   'token' => $user->createToken("API TOKEN")->plainTextToken,
                'data'=>  $user,
                'pagination' => [
                'current_page' => $users->currentPage(),
                'total_pages' => $users->lastPage(),
                'total_items' => $users->total(),
                'items_per_page' => $users->perPage(),
                'first_item' => $users->firstItem(),
                'last_item' => $users->lastItem(),
                'has_more_pages' => $users->hasMorePages(),
                'next_page_url' => $users->nextPageUrl(),
                'previous_page_url' => $users->previousPageUrl(),
            ],

            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function index() {
      // Fetch all charities and paginate them
      $charities = DB::table('charities')->paginate(10);  // Adjust the pagination as needed

      // Log the output of the query
    //  \Log::debug('Charities data:', ['data' => $charities]);

      // Prepare the response data including pagination details
      return response()->json([
          'status' => true,
          'message' => 'Charities data retrieved successfully',  // Updated message
          'data' => $charities->items(),  // Extracting items from paginator
          'pagination' => [
              'current_page' => $charities->currentPage(),
              'total_pages' => $charities->lastPage(),
              'total_items' => $charities->total(),
              'items_per_page' => $charities->perPage(),
              'first_item' => $charities->firstItem(),
              'last_item' => $charities->lastItem(),
              'has_more_pages' => $charities->hasMorePages(),
              'next_page_url' => $charities->nextPageUrl(),
              'previous_page_url' => $charities->previousPageUrl(),
          ],
      ], 200);
  }


  public function show($id)
{
    $charity = DB::table('charities')->where('id', $id)->first();

    // Handle case where the charity is not found
    if (!$charity) {
        return response()->json([
            'status' => false,
            'message' => 'Charity not found',
            'data' => null,
            'pagination' => (object)[]
        ], 404);
    }

    // Since it's a single charity, pagination does not apply in a traditional sense.
    // However, we can still use a structure for consistency if needed:
    return response()->json([
        'status' => true,
        'message' => 'Charity data retrieved successfully',
        'data' => $charity,
        'pagination' => [
            'current_page' => 1,
            'total_pages' => 1,
            'total_items' => 1,
            'items_per_page' => 1,
            'first_item' => 1,
            'last_item' => 1,
            'has_more_pages' => false,
            'next_page_url' => null,
            'previous_page_url' => null,
        ],
    ], 200);
}



public function userorder($id){
  $userid=Auth::id();
  $orders = DB::table('beneficiaries')->where('users_id', $userid)->paginate(10);

    return response()->json([
        'status' => true,
        'message' => 'you get your orders successfully',  // Updated message
        'data' => $orders->items(),  // Extracting items from paginator
        'pagination' => [
            'current_page' => $orders->currentPage(),
            'total_pages' => $orders->lastPage(),
            'total_items' => $orders->total(),
            'items_per_page' => $orders->perPage(),
            'first_item' => $orders->firstItem(),
            'last_item' => $orders->lastItem(),
            'has_more_pages' => $orders->hasMorePages(),
            'next_page_url' => $orders->nextPageUrl(),
            'previous_page_url' => $orders->previousPageUrl(),
        ],
    ], 200);
}
 public function updateprofile(Request $request,$id){
   if (Auth::id() != $id) {
       return response()->json(['message' => 'Unauthorized - You can only update your own profile'], 403);
   }

   $user = Auth::user();
    // Update email if provided
    if ($request->has('email')) {
        $user->email = $request->email;
    }

    // Update phone if provided
    if ($request->has('phone')) {
        $user->phone = $request->phone;
    }

    // Update password if provided and hash it
    if ($request->has('address')) {
        $user->address = $request->address;
    }

    // Save the changes to the user
    $user->save();
    //  $user->save();
    return response()->json([
        'status' => true,
        'message' => 'your profile information updaeted successfully',
        'data' => $user,
        'pagination' => [
            'current_page' => 1,
            'total_pages' => 1,
            'total_items' => 1,
            'items_per_page' => 1,
            'first_item' => 1,
            'last_item' => 1,
            'has_more_pages' => false,
            'next_page_url' => null,
            'previous_page_url' => null,
        ],
    ], 200);

 }


    }
