<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Coupon;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    use ApiResponse;

    public function addOrder(OrderRequest $request){
        $data=$request->validated();
        $totalPrice = 0;
        $res = Coupon::where('code', $data['coupon_code'])->first();
        foreach ($data['products'] as $productData) {
            $product = Product::findOrFail($productData['product_id']);
            $totalPrice += $productData['quantity'] * $product->price;
        }
        if($res){
            $totalPrice *=$res->discount;
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

        return $this->apiResponse(new OrderResource($order),'Order Added Successfully');

    }
}
