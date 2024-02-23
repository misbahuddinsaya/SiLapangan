<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseServices;

class PemesananController extends Controller
{
    protected $database;
    public function __cunstruct(FirebaseService $firebaseService){
        
        $this->database = $firebaseService->connect();
    }
    public function Gor() {
        return view('page-pemesanan.pemesanan-gor');
    }
    public function Lapangan() {
        return view('page-pemesanan.pemesanan-lapangan');
    }
    public function simpanPemesanan(Request $request)
    {
        $reference = $this->database->getReference('tb_pemesanan');

        // Get the latest kode_produk from tb_produk
        $datakodeTerahir = $reference->orderByKey()->limitToLast(1)->getValue();

        $lastKode = null;
        if ($datakodeTerahir !== null) {
            $lastEntry = end($datakodeTerahir);
            $lastKode = $lastEntry['kode_pemesanan'];
        }
        $newKode = $this->generateNewCodeDaftarUmkm($lastKode);
        $newData = [
            $newKode => [
                'kode_pemesanan' => $newKode,
                'nama_pemesan' => $request->namaPemesan,
                'nama_lapangan' => $request->namaLapangan,
                'tanggal' => $request->tanggalPemesan,
                'jam_mulai' => $request->jamMulai,
                'jam_selesai' => $request->jamSelesai,
                'total_pembayaran' => $request->totalPembayaran,
            ]
        ];

        // Use push method to add a new product with a generated key
        $reference->update($newData);
        return redirect('/pemesanan-lapangan');
    }
    protected function generateNewCodeDaftarUmkm($lastKode)
{
    if (!$lastKode) {
        return 'TRX1';
    }
    $number = (int) substr($lastKode, 3);
    $newNumber = $number + 1;
    $newKode = 'TRX' . $newNumber; 

    return $newKode;
}
}
