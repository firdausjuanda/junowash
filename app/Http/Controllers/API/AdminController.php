<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUser()
    {
        $user = User::all();
        if ($user != null) {
            return ApiFormatter::createApi('200', 'Success', $user);
        } else {
            return ApiFormatter::createApi('400', 'User is empty');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivateUser(Request $request, $id)
    {
        $admin = User::find($request->user_id);
        if ($admin == null) {
            return ApiFormatter::createApi('400', 'Admin not found');
        } else {
            if ($admin->role == 'admin') {
                $user = User::find($id);
                if ($user != null) {
                    if ($user->active == 1) {
                        $user->update([
                            'active' => 0,
                        ]);
                    } else {
                        return ApiFormatter::createApi('400', 'User has been deactivated');
                    }
                    return ApiFormatter::createApi('200', 'Success');
                } else {
                    return ApiFormatter::createApi('400', 'User not found');
                }
            } else {
                return ApiFormatter::createApi('400', 'Authorization error');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activateUser(Request $request, $id)
    {
        $admin = User::find($request->user_id);
        if ($admin == null) {
            return ApiFormatter::createApi('400', 'Admin not found');
        } else {
            if ($admin->role == 'admin') {
                $user = User::find($id);
                if ($user->active == 0) {
                    if ($user != null) {
                        $user->update([
                            'active' => 1,
                        ]);
                        return ApiFormatter::createApi('200', 'Success');
                    } else {
                        return ApiFormatter::createApi('400', 'User not found');
                    }
                } else {
                    return ApiFormatter::createApi('400', 'User has been activated');
                }
            } else {
                return ApiFormatter::createApi('400', 'Authorization error');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setAdmin(Request $request, $id)
    {
        $admin = User::find($request->user_id);
        if ($admin == null) {
            return ApiFormatter::createApi('400', 'Admin not found');
        } else {
            if ($admin->role == 'admin') {
                $user = User::find($id);
                if ($user != null) {
                    if ($user->role == 'user') {
                        $user->update([
                            'role' => 'admin',
                        ]);
                        return ApiFormatter::createApi('200', 'Success');
                    } else {
                        return ApiFormatter::createApi('400', 'User has been an admin');
                    }
                } else {
                    return ApiFormatter::createApi('400', 'User not found');
                }
            } else {
                return ApiFormatter::createApi('400', 'Authorization error');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unsetAdmin(Request $request, $id)
    {
        $admin = User::find($request->user_id);
        if ($admin == null) {
            return ApiFormatter::createApi('400', 'Admin not found');
        } else {
            if ($admin->role == 'admin') {
                $user = User::find($id);
                if ($user != null) {
                    if ($user->role == 'admin') {
                        $user->update([
                            'role' => 'user',
                        ]);
                        return ApiFormatter::createApi('200', 'Success');
                    } else {
                        return ApiFormatter::createApi('400', 'User hasn\'t been an admin');
                    }
                } else {
                    return ApiFormatter::createApi('400', 'User not found');
                }
            } else {
                return ApiFormatter::createApi('400', 'Authorization error');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteUser(Request $request, $id)
    {
        $admin = User::find($request->user_id);
        if ($admin == null) {
            return ApiFormatter::createApi('400', 'Admin not found');
        } else {
            if ($admin->role == 'admin') {
                $user = User::find($id);
                if ($user != null) {
                    $user->delete();
                    return ApiFormatter::createApi('200', 'Success');
                } else {
                    return ApiFormatter::createApi('400', 'User not found');
                }
            } else {
                return ApiFormatter::createApi('400', 'Authorization error');
            }
        }
    }
}
