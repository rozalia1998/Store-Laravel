<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        return $this->apiResponse(ProductResource::collection($products),'All Products',200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('public/images');
        }
        $product=Product::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'img_url'=>$imagePath,
            'in_stock'=>$request->in_stock,
            'category_id'=>$request->category_id,
            'subcat_id'=>$request->subcat_id
        ]);

        return $this->SuccessResponse('Added product successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::findOrFail($id);
        return $this->apiResponse($product,'About this product',200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::findOrFail($id);

        $res=$product->update([
            'name'=>$request->name ?? $product->name,
            'description'=>$request->description ?? $product->description,
            'price'=>$request->price ?? $product->price,
            'in_stock'=>$request->in_stock ?? $product->in_stock,
            'category_id'=>$request->category_id ?? $product->category_id,
            'subcat_id'=>$request->subcat_id ?? $product->subcat_id
        ]);

        return $this->SuccessResponse('Updated product successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $product->delete();

        return $this->SuccessResponse('Deleted Product Successfully');
    }

    public function search(Request $request,$subcat){
        $scat=SubCategory::findOrFail($subcat);
        $product=Product::where('subcat_id',$scat->id)->where('name','like','%'.$request->name.'%')->get();

        return $this->apiResponse($product,'About this product',200);

    }

    public function FilterPrice(Request $request){
        $product=Product::where('price','>',$request->min)->where('price','<',$request->max)->get();
        return $this->apiResponse($product,'Filter About Price',200);
    }

}
