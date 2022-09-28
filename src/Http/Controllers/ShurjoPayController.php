<?php

namespace Yahrdy\Shurjopay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yahrdy\Shurjopay\Shurjopay;

class ShurjoPayController extends Controller
{
    public function initiate(Request $request)
    {
        $ruels = [
            'amount' => 'required|numeric',
            'order_id' => 'required|integer',
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|regex:/^(\+88)?(01)[0-9]{9}$/',
        ];
        $validator = Validator::make($request->all(), $ruels);
        if ($validator->fails()) {
            return response()->json([$validator->errors(),], 422);
        }
        $client = new Shurjopay();
        return $client
            ->checkout($request->amount, $request->order_id, $request->name, $request->address, $request->phone, $request->post_code, $request->value1, $request->value2, $request->value3, $request->value4)
            ->json();
    }

    public function verify()
    {
        $client = new Shurjopay();
        $rules = ['id' => 'required'];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return response()->json([$validator->errors(),], 422);
        }

        return $client->verify(\request()->id);
    }

    public function check()
    {
        $client = new Shurjopay();
        $rules = ['id' => 'required'];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return response()->json([$validator->errors(),], 422);
        }
        return $client->check(\request()->id);
    }
}
