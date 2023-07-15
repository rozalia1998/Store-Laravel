<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    use ApiResponse;

    public function addReview(Request $request,$id){
        $review=Review::create([
            'user_id'=>auth()->user()->id,
            'product_id'=>$id,
            'rate'=>$request->rate,
            'comment'=>$request->comment
        ]);

        return $this->SuccessResponse('Review Added Successfully');
    }

    public function showProductRev($id){
        $product=Product::findOrFail($id);
        $res=$product->reviews()->with('user:id,name')->get();

        return $this->apiResponse(ReviewResource::collection($res),'All Reviews For This Product');
    }

    public function ordered($id){
        $product=Product::findOrFail($id);
        $res=$product->reviews()->with('user:id,name')->orderBy('rate','desc')->get();

        return $this->apiResponse(ReviewResource::collection($res),'All Reviews For This Product');
    }

    public function orderAll(){
        $products = Product::withCount('reviews')
        ->withAvg('reviews', 'rate')
        ->orderByDesc('reviews_count')
        ->orderByDesc('reviews_avg_rate')
        ->get();

        return $this->apiResponse($products,'All Reviews For This Product');
    }
}
