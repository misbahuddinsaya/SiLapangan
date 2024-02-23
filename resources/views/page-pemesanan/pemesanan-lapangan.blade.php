@extends('main.main')
@section('title', 'Pemesanan Lapangan')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pemesanan Lapangan</h1>
    
</div>
<section>
    <div class="row">
        <div class="col-lg-6">
        <div class="card">
        <div class="card-header bg-primary text-white">
            Pemesanan Lapangan
        </div>
        <div class="card-body">
        <form id="sewaForm" action="{{ route('simpan') }}" method="POST">
          @csrf
            <div class="input-group mb-4">
              <span class="input-group-text" id="basic-addon1">Nama</span>
              <input type="text" class="form-control" placeholder="Masukan Nama" aria-label="Username" aria-describedby="basic-addon1" id="nama" name="namaPemesan">
            </div>

            <div class="input-group mb-3">
              <label class="input-group-text" for="inputGroupSelect01">Lapangan</label>
              <select class="form-select col-lg-9" id="lapangan" name="namaLapangan">
                <option selected>--Pilih Lapangan--</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="basic-url" class="form-label">Tanggal Sewa Lapangan</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon3">Tanggal</span>
                <input type="date" class="form-control" id="tanggal" aria-describedby="" name="tanggalPemesan">
              </div>
            </div>
            <div class="mb-3">
              <label for="basic-url" class="form-label">Jam Mulai Sewa Lapangan</label>
              <div class="input-group mb-3">
                <span class="input-group-text">Jam Mulai Sewa</span>
                <input type="time" class="form-control" id="jamMulai" aria-label="" name="jamMulai">  
              </div>
            </div>

            <div class="mb-3">
              <label for="basic-url" class="form-label">Jam Selesai Sewa Lapangan</label>
              <div class="input-group mb-3">
                <span class="input-group-text">Jam Selesai Sewa</span>
                <input type="time" class="form-control" id="jamSelesai" aria-label="" name="jamSelesai">  
              </div>
            </div>
            <div class="mb-3">
              <label for="basic-url" class="form-label">Total</label>
              <div class="input-group mb-3">
                <span class="input-group-text">Total</span>
                <input type="number" class="form-control" id="jamSelesai" aria-label="" name="totalPembayaran">  
              </div>
            </div>
            <div class="mb-3">
              <button type="submit" class="btn btn-primary" id="hitungTotal">Total Pesanan</button>
            </div>
          </form>
        </div>
    </div>
        </div>
        <div class="col-lg-4">
        <div class="card">
          <div class="card-header bg-primary text-white">Total pemesanan</div>
        <div class="card-body">
          <h5 class="card-title"></h5>
          <div id="hasilPesanan"></div>
          <div class="d-grid gap-2 d-md-block mt-4">
  <button class="btn btn-primary" type="submit">Pesan Lapangan</button>
  <button class="btn btn-primary" type="submit" id="batalButton">Batal</button>
</div>
        </div>
      </div>
        </div>
    </div>
    
</section>
<!-- JS -->
<script>
  document.getElementById('hitungTotal').addEventListener('click', function() {
    // Ambil nilai dari input
    var nama = document.getElementById('nama').value;
    var lapangan = document.getElementById('lapangan').value;
    var tanggal = document.getElementById('tanggal').value;
    var jamMulai = document.getElementById('jamMulai').value;
    var jamSelesai = document.getElementById('jamSelesai').value;

    // Di sini Anda bisa melakukan pengolahan nilai input dan menghitung total pesanan
    // Misalnya:
    var hargaPerJam = 10000; // Harga lapangan per jam

    // Pisahkan jam dan menit dari input jam mulai dan jam selesai
    var jamMulaiArray = jamMulai.split(":");
    var jamSelesaiArray = jamSelesai.split(":");

    // Konversi jam mulai dan jam selesai menjadi objek Date dengan tanggal yang sama
    var tanggalObj = new Date("2000-01-01");
    var jamMulaiObj = new Date(tanggalObj.getTime() + (parseInt(jamMulaiArray[0]) * 3600000) + (parseInt(jamMulaiArray[1]) * 60000));
    var jamSelesaiObj = new Date(tanggalObj.getTime() + (parseInt(jamSelesaiArray[0]) * 3600000) + (parseInt(jamSelesaiArray[1]) * 60000));

    // Jika jam selesai sebelum jam mulai, tambahkan 1 hari pada jam selesai
    if (jamSelesaiObj < jamMulaiObj) {
        jamSelesaiObj.setDate(jamSelesaiObj.getDate() + 1);
    }

    // Hitung selisih jam dalam milidetik
    var selisihJam = jamSelesaiObj - jamMulaiObj;

    // Konversi selisih jam dari milidetik menjadi jam
    var selisihJamHours = selisihJam / (1000 * 60 * 60);

    // Hitung total pembayaran
    var totalPembayaran = hargaPerJam * selisihJamHours;

    // Format total pembayaran menjadi mata uang rupiah
    var formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    });
    var totalPembayaranFormatted = formatter.format(totalPembayaran);

    // Tampilkan total pesanan pada card
    var totalPesanan = "Nama: " + nama + "<br>Lapangan: " + lapangan + "<br>Tanggal: " + tanggal + "<br>Jam Mulai: " + jamMulai + "<br>Jam Selesai: " + jamSelesai + "<br>Total Pembayaran: " + totalPembayaranFormatted;
    document.getElementById('hasilPesanan').innerHTML = totalPesanan;
    document.getElementById('cardTotal').style.display = "block"; // Tampilkan card total
});
  document.getElementById('batalButton').addEventListener('click', function() {
    // Reset nilai input
    document.getElementById('nama').value = "";
    document.getElementById('lapangan').value = "--Pilih Lapangan--";
    document.getElementById('tanggal').value = "";
    document.getElementById('jamMulai').value = "";
    document.getElementById('jamSelesai').value = "";

    // Sembunyikan card total
    document.getElementById('cardTotal').style.display = "none";
  });
</script>
@endsection
