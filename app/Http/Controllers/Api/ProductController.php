<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $responseError = ['success' => false, 'message' => 'Something went wrong', 'code' => STATUS_BAD_REQUEST];
    public $responseSuccess = ['success' => true, 'message' => 'Success', 'code' => STATUS_OK];

    // for product listing with pagination
    public function index()
    {
        $products = Product::orderBy("id","desc")->simplePaginate(10);
        $this->responseSuccess['data'] = $products;
        $this->responseSuccess['message'] = 'product listing';
        return response()->json($this->responseSuccess, $this->responseSuccess['code']);
    }

     // for getting single product details
    public function getProductDetils(Request $request)
    {
        // product id
        $id = $request->id;
        $product = Product::find($id);
        $this->responseSuccess['data'] = $product;
        $this->responseSuccess['message'] = 'product detail';
        return response()->json($this->responseSuccess, $this->responseSuccess['code']);
    }

    // searching product based on name ,description, brand
    public function seachProduct(Request $request){
        $products = Product::orderBy("id","desc");

        if(!empty($request->search)){
            $products = $products->where("name","like","%". $request->search ."%")
            ->orWhere("description","like","%". $request->search ."%")
            ->orWhere("brand","like","%". $request->search ."%");
        }
        $products = $products->simplePaginate(10);
        $this->responseSuccess['data'] = $products;
        $this->responseSuccess['message'] = 'product listing';
        return response()->json($this->responseSuccess, $this->responseSuccess['code']);
    }
    }
