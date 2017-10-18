<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function bookUnit(Request $request) 
    {
    DB::beginTransaction();
    
    try 
    {
    $this->validate($request, [
    'kamar_id' => 'required',
    'pelanggan_id' => 'required',
    'tanggal_masuk' => 'required',
    'tanggal_keluar' => 'required'
    ]);
    $kamarID = $request->input('kamar_id');
    $pelangganID = $request->input('pelanggan_id');
    $tanggalMasuk = $request->input('tanggal_masuk');
    $tanggalKeluar = $request->input('tanggal_keluar');
    
    DB::table('transactions')->insert([
    ['kamar_id' => $kamarID, 'pelanggan_id' => $pelangganID,
    'tanggal_masuk' => $tanggalMasuk, 'tanggal_keluar' => $tanggalKeluar]
    ]);
    
    
    $rent = DB::table('transactions')->select(transactions.rent_id, transactions.pelanggan_id, transactions.kamar_id, 
    transactions.tanggal_masuk, transactions.tanggal_keluar, kamar.status)->get();
    
    DB::commit();
    return response()->json($rent, 200);
    }
    
    catch(\Exception $e) 
    {
    DB::rollBack();
    return response()->json(["message" => $e->getMessage()], 500);
    } 
    }
    }

