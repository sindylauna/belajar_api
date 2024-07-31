<?php

namespace App\Http\Controllers\Api;
use App\Models\Klub;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;


class KlubController extends Controller
{
    
    public function index()
    {
        $klub= Klub::latest()->get();
        return response()->json([
            'succes' => true,
            'message' => 'Daftar Klub',
            'data' => $klub,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'nama_klub' => 'required',
            'logo' => 'required|image|max:2048',
            'id_liga' =>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'succes' => false,
                'massage' => 'data tidak valid',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        try{
            $path = $request->file('logo')->store('public/logo');
            $klub = new Klub;
            $klub -> nama_klub = $request -> nama_klub;
            $klub ->logo = $path;
            $klub ->id_liga = $request->id_liga;
            $klub -> save();
            return response()->json([
                'succes' => true,
                'massage' => 'data berhasil di buat',
                'data' => $klub,
            ],201);


        }catch (\Throwable $th) {

        }
    }

    
    public function show(string $id)
    {
        {
            try {
                $klub = Klub::findOrFail($id);
                return response()->json([
                    'success' => true,
                    'message' => 'Detail Liga',
                    'data' => $klub,
                ], 200);
            } catch (\Exception $th) {
                return response()->json([
                    'success' => false,
                    'message' => 'data tidak ada',
                    'errors' => $th->getMessage(),
                ], 404);
    }
    }
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
        $klub = Klub::findOrFail($id);
       $validator = Validator::make($request->all(), [
        'nama_klub' => 'required',
        'logo' => 'required|image|max:2048',
        'id_liga' => 'required',
    ]);
    
    if ($validator->fails()){
        return response()->json([
            'success' => false,
            'message' => 'Data tidak valid',
            'errors' => $validator->errors(),
        ],422);
    }

    try {
        $klub = Klub::findOrFail($id);

        if ($request->hasFile('logo')) {
            // delete foto / logo lama
            Storage::delete($klub->logo);
            $path = $request->file('logo')->store('public/logo');
            $klub->logo = $path;
        }
        $klub->nama_klub = $request->nama_klub;
        $klub->id_liga = $request->id_liga;
        $klub->save();
        return response()->json([
            'success' => true,
            'message' => 'Data berhassil diperbarui',
            'data' => $klub,
        ], 200);
    } catch (Exception $e) {
         return response()->json([
                'success' => false,
                'message' => 'terjadi kesalahan',
                'errors' => $e->getMessage(),
        ], 500);
    }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $klub = Klub::findOrFail($id);
            Storage::delete($klub->logo);
            $klub->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data' .$klub->nama_klub . 'berhasil Di hapuss'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ada',
                'errors' => $e->getMessage(),
            ], 404);
        } 
    }
}


