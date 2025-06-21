<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Exception;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    // xoa danh gia
    public function deleteFeedback()
    {
        try {
            $id = request('id');
            $query = Feedback::find($id);
            if ($query) {
                $deleted_rows = $query->delete();

                if ($deleted_rows) {

                    return response()->json([
                        'status' => true,
                        'message' => 'Delete successful.',
                    ], 200);
                }
            }

            return response()->json([
                'status' => false,
                'message' => 'Request invalid.',
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    // them moi phan hoi 
    public function storeFeedback()
    {
        try {
            $text = request('text');
            $review_id = request('review_id');
            // $id = auth()->user()->administrators[0]->id;
            $id = 1;


            Feedback::create([
                'text' => $text,
                'review_id' => $review_id,
                'administrator_id' => $id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Store successful.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
