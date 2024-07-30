<?php

namespace App\Http\Controllers\Api;
use App\Models\Fan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;


class FanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fan= Fan::with('klub')->latest->get();
        return response()->json([
            'succes' => true,
            'message' => 'Daftar Fans',
            'data' => $fan,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate= Validator::make($request->all(),[
            'nama_fan' => 'required',
            'klub' => 'required|array',
            
        ]);
        if($validate->fails()){
            return response()->json([
                'succes' => false,
                'massage' => 'data tidak valid',
                'errors' => $validator->errors(),
            ], 422);
        }
        try{
            $fan = new Fan;
            $fan -> nama_fan = $request -> nama_fan;
            $fan -> save();
            $fan -> klub()->attach($request->klub);
            return response()->json([
                'succes' => true,
                'massage' => 'data berhasil di buat',
                'data' => $fan,
            ],201);

        }catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'massage' => 'data tidak valid',
                'errors' => $e->getMessage(),
            ], 500);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate= Validator::make($request->all(),[
            'nama_fan' => 'required',
            'klub' => 'required|array',
            
        ]);
        if($validate->fails()){
            return response()->json([
                'succes' => false,
                'massage' => 'data tidak valid',
                'errors' => $validator->errors(),
            ], 422);
        }
        try{
            $fan =Fan::findOrFile($id);
            $fan -> nama_fan = $request -> nama_fan;
            $fan -> save();
            $fan -> klub()->sync($request->klub);
            return response()->json([
                'succes' => true,
                'massage' => 'data berhasil di buat',
                'data' => $fan,
            ],201);

        }catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'massage' => 'data tidak valid',
                'errors' => $e->getMessage(),
            ], 500);

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $fan =Fan::findOrFile($id);
            $fan -> delete();
            $fan -> klub()->detach();
            return response()->json([
                'succes' => true,
                'massage' => 'data berhasil di Hapus',
                'data' => $fan,
            ],201);

        }catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'massage' => 'Terjadi Kesalahan',
                'errors' => $e->getMessage(),
            ], 500);

        }
    }
}
