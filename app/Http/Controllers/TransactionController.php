<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(){
        $transactions = Transaction::with("user")->get();
        return $this->Ok($transactions);
    }

    public function store(Request $request){
        $validator = validator()->make($request->all(), [
            "cart" => "required|array",
            "cart.*" => "required|array",
            "cart.*.id" => "required|exists:products,id",
            "cart.*.quantity" => "required|min:1|max:1000000|int"
        ]);

        if ($validator->fails()){
            return $this->BadRequest($validator);
        }

        $transaction = $request->user()->transactions()->create();
        $products = Product::all();

        $array = [];
        $cart = $validator->validated()["cart"];


        foreach($cart as $value){
            $array[$value["id"]] = [
                "quantity" => $value["quantity"],
                "price" => $products->find($value["id"])->price
            ];
        }

        $transaction->products()->sync($array);

        $transaction->products;

        return $this->Created($transaction);
    }

    public function show(Transaction $transaction){
        $transaction->products;

        return $this->Ok($transaction,"Retrieved!");
    }


}
