<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    use ApiResponse;

    public function addOrder(OrderRequest $request){
        $data=$request->validated();
        $totalPrice = 0;
        foreach ($data['products'] as $productData) {
            $product = Product::findOrFail($productData['product_id']);
            $totalPrice += $productData['quantity'] * $product->price;
        }
        $order=Order::create([
            'user_id'=>auth()->user()->id,
            'totalprice'=>$totalPrice
        ]);
        foreach($data['products'] as $productData){
            $product=Product::findOrFail($productData['product_id']);
            $order->products()->attach($product, [
                'quantity' => $productData['quantity'],
                'price' => $product->price,
            ]);
        }

        return $this->apiResponse('Order Added Successfully');


    }
}
