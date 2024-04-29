<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
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
        DB::beginTransaction();
        try {
            $request->validate([
                'usertext' => 'required|string',
            ]);

            $feedback = new Feedback();
            $feedback->users_id = Auth::id(); // assumes user is authenticated
            $feedback->usertext = $request->usertext;
            $feedback->save();

            // Assuming you want to return all feedback from the current user
            $paginatedFeedback = Feedback::where('users_id', Auth::id())->latest()->paginate(10);

            DB::commit();
            return response()->json([
                'message' => 'You have submitted feedback successfully',
                'data' => $feedback,
                'pagination' => $paginatedFeedback
            ], 201);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error processing your request: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        //
    }
}
