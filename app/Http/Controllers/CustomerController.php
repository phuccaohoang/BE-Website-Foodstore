<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // lay danh sach khach hang 
    public function getCustomers()
    {
        try {
            $query = Customer::whereHas('account', function ($query) {
                $query->where('status', 1);
            });
            return response()->json([
                'status' => true,
                'data' => $query->get(),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
