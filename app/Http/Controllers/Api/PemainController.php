<?php

namespace App\Http\Controllers\Api;
use App\Models\Pemain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;

class PemainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemain= Pemain::latest()->get();
        return response()->json([
            'succes' => true,
            'message' => 'Daftar Pemain',
            'data' => $klub,
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
        $validator= Validator::make($request->all(),[
            'nama_pemain' => 'required',
            'foto' => 'required|image',
            'tgl_lahir' => 'required',
            'harga_pasar' => 'required',
            'posisi' => 'required|in:gk,df,mf,fw',
            'negara' => 'required',
            'id_klub' =>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'succes' => false,
                'massage' => 'data tidak valid',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        try{
            $path = $request->file('foto')->store('public/foto');
            $pemain = new Pemain;
            $pemain -> nama_pemain = $request -> nama_pemain;
            $pemain -> tgl_lahir = $request -> tgl_lahir;
            $pemain -> harga_pasar = $request -> harga_pasar;
            $pemain -> posisi = $request -> posisi;
            $pemain -> negara = $request -> negara;
            $pemain ->foto = $path;
            $pemain ->id_klub = $request->id_klub;
            $pemain -> save();
            return response()->json([
                'succes' => true,
                'massage' => 'data berhasil di buat',
                'data' => $pemain,
            ],201);


        }catch (\Exception $e) {
            return response()->json([
                'succes' => false,
                'massage' => 'data tidak valid',
                'errors' => $e->getMessage(),
            ]);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
