<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Liga;

use Validator;

class LigaController extends Controller
{
    public function index()
    {
        $liga = Liga::latest()->get();
        $res = [
            'succes' => true,
            'massage' => 'Daftar Liga Sepak Bola',
            'data' =>$liga,
        ];
        return response()->json($res, 200);
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
        'nama_liga' => 'required|unique:ligas',
        'negara' => 'required',


        ]);
        if($validate->fails()){
            return response()->json([
            'succes' => false,
            'massage' => 'Validasi gagal',
            'data' =>$validate->errors(),
            ], 422);
        }
        
        try{
            $liga= new Liga;
            $liga->nama_liga = $request->nama_liga;
            $liga->negara= $request->negara;
            $liga->save();
            return response()->json([
            'succes' => true,
            'massage' => 'Data Liga Berhasil Dibuat',
            'data' =>$liga,
            ], 201);
            
        }catch (\Exception $e){
            return response()->json([
            'succes' => false,
            'massage' => 'Terjadi Kesalahan',
            'data' => $e->getMessage(),   
            ],500);
        }
    }


public function show($id)
    {
        try {
            $liga = Liga::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Detail Liga',
                'data' => $liga,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'data tidak ada',
                'errors' => $e->getMessage(),
            ], 404);
}
}

public function update(Request $request , $id)
    {
        $validate = Validator::make($request->all(),[
        'nama_liga' => 'required',
        'negara' => 'required',


        ]);
        if($validate->fails()){
            return response()->json([
            'succes' => false,
            'massage' => 'Validasi gagal',
            'data' =>$validate->errors(),
            ], 422);
        }
        
        try{
            $liga=Liga::findOrFail($id);
            $liga->nama_liga = $request->nama_liga;
            $liga->negara= $request->negara;
            $liga->save();
            return response()->json([
            'succes' => true,
            'massage' => 'Data Liga Berhasil Diperbaharui',
            'data' =>$liga,
            ], 201);
            
        }catch (\Exception $e){
            return response()->json([
            'succes' => false,
            'massage' => 'Terjadi Kesalahan',
            'data' => $e->getMessage(),   
            ],500);
        }
    }

    public function destroy($id)
    {
        try {
            $liga = Liga::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Data' .$liga->nama_liga . 'berhasil Di hapuss'
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