@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.topnav', ['title' => 'Barang'])
@include('sweetalert::alert')

<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <style>
        #barcode-scanner {
            width: 100%; /* Adjust to fit the modal width */
            height: auto; /* Maintain aspect ratio */
            max-width: 500px; /* Limit the maximum width */
            max-height: 300px; /* Limit the maximum height */
            overflow: hidden; /* Hide overflow */
            position: relative; /* Position relative to control its size */
        }

        #barcode-scanner video {
            width: 100%;
            height: auto; /* Maintain aspect ratio */
            object-fit: cover; /* Cover the container while maintaining aspect ratio */
        }
    </style>
</head>

<div class="container-fluid px-0 px-sm-4 py-3">
    <!-- Card Tambah Mutasi Masuk -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center mb-0">
            <h5 class="card-title">Tambah Mutasi Masuk</h5>
        </div>
        <div class="card-body pt-0">
            <form id="formTambahMutasiMasuk" action="{{ route('simpanBarang') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="kodeBarang" class="form-label">Kode: </label>
                    <input type="text" class="form-control" id="kodeBarang" name="kode">
                    @error('kode')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori: </label>
                    <select name="kategori_id" id="kategori" class="form-select">
                        <option value="">Pilih</option>
                        @foreach ($data['kategori'] as $kategori)
                            <option value="{{ $kategori->id }}">
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="serialBarang" class="form-label">SN: </label>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#barcodeScannerModal" class="btn bg-gradient-success btn-sm mb-2">
                        Scan Barcode
                    </a>
                    <input type="text" class="form-control" id="serialBarang" name="serial_number">
                    @error('serial_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="namaBarang" class="form-label">Nama Barang: </label>
                    <input type="text" class="form-control" id="namaBarang" name="nama">
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="gudang">Gudang: </label>
                    <select name="gudang_id" id="gudang" class="form-select">
                        <option value="">Pilih</option>
                        @foreach ($data['gudang'] as $gudang)
                            <option value="{{ $gudang->id }}">
                                {{ $gudang->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('gudang_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="satuan">Satuan: </label>
                    <select name="satuan_id" id="satuan" class="form-select">
                        <option value="">Pilih</option>
                        @foreach ($data['satuan'] as $satuan)
                            <option value="{{ $satuan->id }}">
                                {{ $satuan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('satuan_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="hargaBarang" class="form-label">Harga Satuan: </label>
                    <input type="text" class="form-control" id="hargaBarang" name="harga">
                    @error('harga')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="jumlahBarang" class="form-label">Jumlah: </label>
                    <input type="text" class="form-control" id="jumlahBarang" name="jumlah">
                    @error('jumlah')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <button type="button" class="btn btn-secondary me-2" onclick="window.history.back()">Kembali</button>
            <button type="submit" class="btn btn-primary" form="formTambahMutasiMasuk">Simpan</button>
        </div>
    </div>
</div>

<!-- Barcode Scanner Modal -->
<div class="modal fade" id="barcodeScannerModal" tabindex="-1" aria-labelledby="barcodeScannerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barcodeScannerModalLabel">Scan Barcode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="barcode-scanner" style="width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var barcodeScannerModal = document.getElementById('barcodeScannerModal');
            var serialInput = document.getElementById('serialBarang');

            barcodeScannerModal.addEventListener('shown.bs.modal', function () {
                startBarcodeScanner();
            });

            barcodeScannerModal.addEventListener('hidden.bs.modal', function () {
                Quagga.stop();
            });

            function startBarcodeScanner() {
                Quagga.init({
                    inputStream: {
                        type: "LiveStream",
                        target: document.querySelector('#barcode-scanner'),
                        constraints: {
                            facingMode: "environment" // or user
                        }
                    },
                    decoder: {
                        readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader", "upc_e_reader", "i2of5_reader"]
                    }
                }, function (err) {
                    if (err) {
                        console.log(err);
                        return;
                    }
                    console.log("Initialization finished. Ready to start");
                    Quagga.start();
                });

                Quagga.onDetected(function (data) {
                    if (data.codeResult && data.codeResult.code) {
                        serialInput.value = data.codeResult.code;
                        var modalInstance = bootstrap.Modal.getInstance(barcodeScannerModal);
                        modalInstance.hide();
                    }
                });
            }
        });
    </script>
@endpush

@endsection
