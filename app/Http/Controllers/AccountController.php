<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Exception;

class AccountController extends Controller
{
    //
    public function getAccounts()
    {
        try {
            $status = request('status', 3);
            $fullname = request('fullname');

            $query = Account::with('customers')->where('is_admin', 0);
            if ($status == 1 || $status == 0) {
                $query = $query->where('status', $status);
            }
            if (!empty($fullname)) {
                $query = $query->whereHas('customers', function ($query) use ($fullname) {
                    $query->where('fullname', 'LIKE', '%' . $fullname . '%');
                });
            }
            $page = request('page', 1);
            $per_page = request('per_page', 4);
            $total = $query->count();
            $last_page = ceil($total / $per_page);
            $query = $query->skip(($page - 1) * $per_page)->take($per_page);

            return response()->json([
                'status' => true,
                'data' => $query->get(),
                'page' => [
                    'current_page' => (int)$page,
                    'last_page' => $last_page,
                    'per_page' => (int)$per_page,
                    'total' => $total,
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    //
    public function updateAccountStatus()
    {
        try {
            $list_id = request('list_id');
            $status = request('status');
            $list_id = array_diff($list_id, [1]);

            if (empty($list_id) || !is_array($list_id) || ($status !== 1 && $status !== 0)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Request invalid',
                ], 400);
            }

            $updated_rows = Account::whereIn('id', $list_id)->update(['status' => $status]);

            if ($updated_rows > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Update successful',
                ], 200);
            }

            return response()->json([
                'status' => true,
                'message' => '0 row updated',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
