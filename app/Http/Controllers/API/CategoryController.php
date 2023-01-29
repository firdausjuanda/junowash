<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return ApiFormatter::createApi('200', 'Success', $category);
    }

    /**s
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!$request->user_id) {
            return ApiFormatter::createApi('400', 'Admin is required');
        }
        $admin = User::find($request->user_id);
        if ($admin == null) {
            return ApiFormatter::createApi('400', 'Admin not found');
        }
        if ($admin->role == 'admin') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:category',
            ]);
            if (!$validator->fails()) {
                $category = Category::create([
                    'name' => $request->name,
                ]);
                return ApiFormatter::createApi('200', 'Success', $category);
            } else {
                return ApiFormatter::createApi('400', 'Invalid input', $validator->errors());
            }
        } else {
            return ApiFormatter::createApi('400', 'Authorization error');
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
        $category = Category::find($id);
        if ($category != null) {
            return ApiFormatter::createApi('200', 'Success', $category);
        } else {
            return ApiFormatter::createApi('400', 'Not found');
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
        if ($admin->role == 'admin') {
            $category = Category::find($id);
            if ($category != null) {
                $category->update([
                    'name' => $request->name,
                    'active' => $request->active,
                ]);
                return ApiFormatter::createApi('200', 'Success', $category);
            } else {
                return ApiFormatter::createApi('400', 'Not found');
            }
        } else {
            return ApiFormatter::createApi('400', 'Authorization error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request, $id)
    {

        if (!$request->user_id) {
            return ApiFormatter::createApi('400', 'Admin is required');
        }
        $admin = User::find($request->user_id);
        if ($admin->role == 'admin') {
            $category = Category::find($id);
            if ($category != null) {
                if ($category->active == 1) {
                    return ApiFormatter::createApi('400', 'Category has already been activated');
                } else {
                    $category->update([
                        'active' => 1,
                    ]);
                    return ApiFormatter::createApi('200', 'Success', $category);
                }
            } else {
                return ApiFormatter::createApi('400', 'Not found');
            }
        } else {
            return ApiFormatter::createApi('400', 'Authorization error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request, $id)
    {
        if (!$request->user_id) {
            return ApiFormatter::createApi('400', 'Admin is required');
        }
        $admin = User::find($request->user_id);
        if ($admin->role == 'admin') {
            $category = Category::find($id);
            if ($category != null) {
                if ($category->active == 0) {
                    return ApiFormatter::createApi('400', 'Category has already been deactivated');
                } else {
                    $category->update([
                        'active' => 0,
                    ]);
                    return ApiFormatter::createApi('200', 'Success', $category);
                }
            } else {
                return ApiFormatter::createApi('400', 'Not found');
            }
        } else {
            return ApiFormatter::createApi('400', 'Authorization error');
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
        if ($admin->role == 'admin') {
            $category = Category::find($id);
            if ($category != null) {
                $category->delete();
                return ApiFormatter::createApi('200', 'Success', $category);
            } else {
                return ApiFormatter::createApi('400', 'Not found');
            }
        } else {
            return ApiFormatter::createApi('400', 'Authorization error');
        }
    }
}
