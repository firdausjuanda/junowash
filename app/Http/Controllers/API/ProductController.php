<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $list_product = [];
        foreach ($products as $key => $product) {
            $category = Category::find($product->category_id);
            if ($category == null) {
                $cat = null;
            } else {
                $cat = $product->category;
            }
            $list_product[$key] = $product;
            $list_product[$key]['category'] = $cat;
            $list_product[$key]['price'] = $product->price;
        }
        return ApiFormatter::createApi('200', 'Success', $list_product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'brand' => 'required',
            'uom' => 'required',
            'price' => 'required|numeric',
        ]);
        $category = Category::find($request->category_id);
        if ($category == null) {
            $cat = 0;
        } else {
            $cat = $request->category_id;
        }
        if (!$validator->fails()) {
            $product = Product::create([
                'name' => $request->name,
                'brand' => $request->brand,
                'category_id' => $cat,
                'model' => $request->model,
                'img' => $request->img,
                'uom' => $request->uom,
                'price' => $request->price,
            ]);
            return ApiFormatter::createApi('200', 'Success', $product);
        } else {
            return ApiFormatter::createApi('400', 'Invalid input!', $validator->errors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product != null) {
            $category = Category::find($product->category_id);
            if ($category == null) {
                $product['category'] = null;
            } else {
                $product['category'] = $product->category;
            }
            return ApiFormatter::createApi('200', 'Success', $product);
        } else {
            return ApiFormatter::createApi('400', 'Not Found');
        }
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
        if (!$request->user_id) {
            return ApiFormatter::createApi('400', 'Admin is required');
        }
        $admin = User::find($request->user_id);
        if ($admin != null) {
            if ($admin->role == 'admin') {
                $validator = Validator::make(
                    $request->all(),
                    [
                        // 'name' => 'required',
                        // 'category_id' => 'required',
                        // 'brand' => 'required',
                        // 'uom' => 'required',
                    ]
                );

                if (!$validator->fails()) {
                    $product = Product::find($id);
                    $category = Category::find($request->category_id);
                    if ($category == null) {
                        $cat = 0;
                    } else {
                        $cat = $request->category_id;
                    }
                    $product->update([
                        'name' => $request->name,
                        'brand' => $request->brand,
                        'category_id' => $cat,
                        'model' => $request->model,
                        'img' => $request->img,
                        'uom' => $request->uom,
                        'cc' => $request->cc,
                        'price' => $request->price,
                        'category_id' => $request->category_id,
                    ]);
                    $product['category'] = $product->category;
                    return ApiFormatter::createApi('200', 'Success', $product);
                } else {
                    return ApiFormatter::createApi('400', 'Invalid input!', $validator->errors());
                }
            } else {
                return ApiFormatter::createApi('400', 'Authorization error');
            }
        } else {
            return ApiFormatter::createApi('400', 'Admin not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$request->user_id) {
            return ApiFormatter::createApi('400', 'Admin is required');
        }
        $admin = User::find($request->user_id);
        if ($admin != null) {
            if ($admin->role == 'admin') {
                $product = Product::find($id);
                $product->delete();
                return ApiFormatter::createApi('200', 'Success', $product);
            } else {
                return ApiFormatter::createApi('400', 'Authorization error');
            }
        } else {
            return ApiFormatter::createApi('400', 'Admin not found');
        }
    }
}
