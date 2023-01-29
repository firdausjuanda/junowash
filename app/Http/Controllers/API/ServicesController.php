<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request) {
            $data = Services::orderBy('id', 'desc')->get();
        } else {
            if ($request->start == $request->end) {
                $data = Services::whereDate('created_at', $request->start)->orderBy('id', 'desc')->get();
            } else {
                $data = Services::whereBetween('created_at', [$request->start, $request->end])->orderBy('id', 'desc')->get();
            }
        }
        // $data = Services::withTrashed()->get();
        if ($data) {
            return ApiFormatter::createApi(200, 'Success', $data);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getServiceAmount(Request $request)
    {
        if ($request->start == $request->end) {
            $data = Services::whereDate('created_at', $request->start)->sum('price');
        } else {
            $data = Services::whereBetween('created_at', [$request->start, $request->end])->sum('price');
        }
        return ApiFormatter::createApi(200, 'Success', $data);
    }

    public function getServiceCount(Request $request)
    {
        if ($request->start == $request->end) {
            $data = Services::whereDate('created_at', $request->start)->count('id');
        } else {
            $data = Services::whereBetween('created_at', [$request->start, $request->end])->count('id');
        }
        return ApiFormatter::createApi(200, 'Success', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'unit_type' => 'required',
                'price' => 'required',
                'user' => 'required',
                'status' => 'required',
            ]);
            $random1 = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
            $random = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 5);
            $trans_code = ($request->vehicle_number != "") ? $request->vehicle_number . "-" . $random : $random1 . "-" . $random;
            $service = Services::create([
                'unit_type' => $request->unit_type,
                'price' => $request->price,
                'user' => $request->user,
                'status' => $request->status,
                'customer' => $request->customer,
                'vehicle_number' => $request->vehicle_number,
                'promo' => $request->promo,
                'transaction_code' => $trans_code,
            ]);

            $data = Services::where('id', '=', $service->id)->get();
            if ($data) {
                return ApiFormatter::createApi(200, 'Success', $data);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (\Exception $e) {
            return ApiFormatter::createApi(400, "Failed: $e");
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
        $data = Services::where('id', '=', $id)->get();
        if ($data) {
            return ApiFormatter::createApi(200, 'Success', $data);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
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
        try {
            $request->validate([
                'unit_type' => 'required',
                'price' => 'required',
                'user' => 'required',
                'status' => 'required',
            ]);

            $service = Services::findOrFail($id);
            $service->update([
                'unit_type' => $request->unit_type,
                'price' => $request->price,
                'user' => $request->user,
                'status' => $request->status,
            ]);

            $data = Services::where('id', '=', $service->id)->get();
            if ($data) {
                return ApiFormatter::createApi(200, 'Success', $data);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (\Exception $e) {
            return ApiFormatter::createApi(400, "Failed: {$e->getMessage()}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Services::findOrFail($id);
        if (!$service) {
            return ApiFormatter::createApi(404, "Failed: Service $service->id not found");
        } else {
            $data = $service->delete();
            if ($data) {
                return ApiFormatter::createApi(200, "Success destroy data id: $service->id");
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        }
    }
}
