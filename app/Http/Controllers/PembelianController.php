<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pelanggan;
use App\Models\produk;
use App\Models\detailpembelian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class PembelianController extends Controller
{
    public function index (){
        $data = pelanggan::all();
        return view('petugas.pembelian', compact('data'));
    }


    public function pembelianbarang(){
        $id=request('id');
        $pelanggan= pelanggan::find($id);
        $data = produk::all();
        return view ('petugas.pembelianbarang', compact('data','pelanggan'));
    }

    public function pelanggan(){
        return view ('petugas.pelanggan');
    }

    public function store()
    {
        $pelanggan = new pelanggan();
        $pelanggan->namapelanggans = request('namapelanggans');
        $pelanggan->alamats = request('alamats');
        $pelanggan->nomortelepons = request('nomortelepons');
        $pelanggan->save();
        return redirect()->route('pembelian')->with('message','Operation Successful !');
    }

    public function buying()
    {

        $id = request('pelanggan_id');
        $pelanggan = pelanggan::where('id', $id)
        ->with('detailpembelian')
        ->get();
        
    //   dd($pelanggan->toArray());
       
            $price = produk::where('namaproduk', request('produk'))->first();
            $pembelian = new detailpembelian();
            $pembelian->pelanggan_id = request('pelanggan_id');
            $pembelian->produk = request('produk');
            $pembelian->date = Carbon::now()->format('Y-m-d');
            $pembelian->jumlah = request('jumlah');
            $pembelian->harga = $price->harga * request('jumlah');
            $pembelian->save();
            return Redirect::back()->with('message','Operation Successful !',compact('pelanggan'));


}

public function destroy()
{
    // dd(request()->all());
    $del=detailpembelian::find(request('id'));
    // dd($del);
    $del->delete();
    $id = request('pelanggan_id');
    $pelanggan = pelanggan::where('id', $id)
    ->with('detailpembelian')
    ->get();
    // dd($pelanggan->toArray());
    return Redirect::back()->with('message','Operation Successful !',compact('pelanggan'));
    
}

public function destroypembeli(){
    $del=pelanggan::find(request('id'));
    $del->delete();
    return Redirect::back()->with('message','Operation Successful !');
}

    }



