<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
    // cap nhat thong tin
    public function updateCustomer()
    {
        try {
            /** @var \App\Models\Account $account */
            $account = auth()->user();
            $account = $account->load('customers');
            $customer_id = $account->customers[0]->id;

            $address = request('address');
            $phone = request('phone');
            $fullname = request('fullname');

            Customer::where('id', $customer_id)->update([
                'address' => $address,
                'phone' => $phone,
                'fullname' => $fullname,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Updated successful.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
