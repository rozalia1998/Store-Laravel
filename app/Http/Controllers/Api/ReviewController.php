<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    use ApiResponse;

    public function addReview(ReviewRequest $request,$id){
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

    public function deleteReview($rid,$pid){
        $review= Review::where('id', $rid)->where('product_id', $pid)->firstOrFail();
        if(Auth::id()==$review->user_id){
            $review->delete();
            return $this->SuccessResponse('Your Review deleted successfully');
        }else {
            return $this->errorResponse('You are not authorized to delete this review');
        }
    }

    public function updateReview(ReviewRequest $request,$rid,$pid){
        $review= Review::where('id', $rid)->where('product_id', $pid)->firstOrFail();
        if(Auth::id()==$review->user_id){
           $review->update([
                'rate'=>$request->rate ?? $review->rate,
                'comment'=>$request->comment ?? $review->comment
            ]);
            return $this->SuccessResponse('Your Review updated successfully');
        }
        else{
            return $this->errorResponse('You are not authorized to update this review');
        }
    }
}
