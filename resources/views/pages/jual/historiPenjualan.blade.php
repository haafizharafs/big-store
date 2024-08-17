@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.topnav', ['title' => 'Mutasi'])
@include('sweetalert::alert')
<head>
    <style>
        .modal-footer .tombol-selesai {
            margin-left: auto;
        }
    </style>
</head>
<div class="container-fluid px-0 px-sm-4 py-3">
    <div class="card md-3">
        <div class="card-header">
            <h6>Daftar Transaksi</h6>
        </div>
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Menunggu</button>
                  <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Selesai</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card-header d-flex align-items-sm-center justify-content-between gap-1">
                            <div class="d-flex align-items-sm-center flex-column flex-sm-row gap-1">
                                <h6 class="m-0 lh-1">Daftar Menunggu</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table2" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualanTunggu as $penjualan)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$penjualan->created_at->format('Y-m-d H:i:s')}}</td>
                                        <td>
                                            <!-- Button Detail Selesai  -->
                                            <button type="button" class="btn btn-success btn-detail-tunggu" data-penjualan-id="{{$penjualan->id}}" data-bs-toggle="modal" data-bs-target="#modalDetailPenjualanTunggu">
                                                <i class="fas fa-edit"> Lanjut </i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu</th>
                                        <th>Opsi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TABEL SELESAI -->
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card-header d-flex align-items-sm-center justify-content-between gap-1">
                            <div class="d-flex align-items-sm-center flex-column flex-sm-row gap-1">
                                <h6 class="m-0 lh-1">Daftar Selesai</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table2" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu</th>
                                        <th>Total</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualanSelesai as $penjualan)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$penjualan->created_at->format('Y-m-d H:i:s')}}</td>
                                        <td>Rp. {{number_format($penjualan->total_harga, 0, ',', '.')}}</td>
                                        <td>
                                            <!-- Button Detail Selesai  -->
                                            <button type="button" class="btn btn-success btn-detail-selesai" data-penjualan-id="{{$penjualan->id}}" data-bs-toggle="modal" data-bs-target="#modalDetailPenjualanSelesai">
                                                <i class="fas fa-edit"> Detail </i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu</th>
                                        <th>Total</th>
                                        <th>Opsi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- MODAL DETAIL SELESAI -->
                <div class="modal fade" id="modalDetailPenjualanSelesai" tabindex="-1" aria-labelledby="modalDetailPenjualanSelesaiLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDetailPenjualanSelesaiLabel">Detail Penjualan</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="modalBodyContentSelesai">

                                    </tbody>
                                </table>
                                <h6 class="text-center">Total: <span id="modalTotalHargaSelesai"></span></h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL DETAIL TUNGGU -->
                <div class="modal fade" id="modalDetailPenjualanTunggu" tabindex="-1" aria-labelledby="modalDetailPenjualanTungguLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDetailPenjualanTungguLabel">Detail Penjualan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formSelesaiTunggu" action="" method="post">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Barang</th>
                                                    <th>Harga</th>
                                                    <th>Stok</th>
                                                    <th>Jumlah</th>
                                                    <th>Total</th>
                                                    <th>Deskripsi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="modalBodyContentTunggu">
                                                <!-- Content will be loaded dynamically -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <h6 class="text-center">Total: <span id="modalTotalHargaTunggu"></span></h6>
                                    <!-- Hidden input to store the penjualan id -->
                                    <input type="hidden" name="penjualan_id" id="penjualan_id">
                                </form>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <form id="formHapusTunggu" action="" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                                <div class="tombol-selesai">
                                    <button type="submit" class="btn btn-primary" form="formSelesaiTunggu">Selesai</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        // Function to update total price
        function updateTotal() {
            let totalHarga = 0;
            $('#modalBodyContentTunggu tr').each(function () {
                const harga = parseInt($(this).find('.qty-input').data('harga'));
                const jumlah = parseInt($(this).find('.qty-input').val());
                const totalPerBarang = harga * jumlah;
                $(this).find('.total-per-barang').text(totalPerBarang.toLocaleString('id-ID'));
                totalHarga += totalPerBarang;
            });
            $('#modalTotalHargaTunggu').text(`Rp. ${totalHarga.toLocaleString('id-ID')}`);
        }

        // Handler for "Tunggu" button
        $('.btn-detail-tunggu').on('click', function () {
            const penjualanId = $(this).data('penjualan-id');
            fetch(`/histori/${penjualanId}`)
                .then(response => response.json())
                .then(data => {
                    const penjualan = data.penjualan;
                    const barangs = data.barangs; // Ambil data barangs dari response
                    const tbody = $('#modalBodyContentTunggu');
                    const totalHargaElement = $('#modalTotalHargaTunggu');
                    const formSelesai = $('#formSelesaiTunggu');
                    const penjualanIdInput = $('#penjualan_id');

                    tbody.html('');
                    let totalHarga = 0;

                    penjualan.barang_juals.forEach((barangJual, index) => {
                        const barang = barangJual.barang;
                        const jumlah = barangJual.jumlah;
                        const harga = barang.harga;
                        const stok = barangs.find(b => b.id === barang.id).jumlah; // Ambil stok barang dari kolom 'jumlah'
                        const totalPerBarang = jumlah * harga;

                        totalHarga += totalPerBarang;

                        const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${barang.nama}</td>
                                <td>Rp. ${harga.toLocaleString('id-ID')}</td>
                                <td>
                                    Stok: ${stok} <!-- Tambahkan kolom stok -->
                                </td>
                                <td>
                                    <button type="button" class="btn btn-secondary btn-sm decrease-qty" data-index="${index}">-</button>
                                    <input type="text" name="barang_juals[${index}][jumlah]" value="${jumlah}" class="form-control qty-input" data-harga="${harga}" readonly style="width: 50px; display: inline-block;">
                                    <button type="button" class="btn btn-secondary btn-sm increase-qty" data-index="${index}" data-stok="${stok}">+</button>
                                </td>
                                <td>
                                    Rp. <span class="total-per-barang">${totalPerBarang.toLocaleString('id-ID')}</span>
                                </td>
                                <td>
                                    <input type="text" name="barang_juals[${index}][deskripsi]" value="${barangJual.deskripsi}" class="form-control">
                                    <input type="hidden" name="barang_juals[${index}][barang_id]" value="${barang.id}">
                                </td>
                            </tr>`;
                        tbody.append(row);
                    });

                    totalHargaElement.text(`Rp. ${totalHarga.toLocaleString('id-ID')}`);

                    // Update form actions
                    $('#formHapusTunggu').attr('action', `/histori/delete-penjualan-tunggu/${penjualanId}`);
                    formSelesai.attr('action', `/histori/selesai-penjualan-tunggu/${penjualanId}`);
                    penjualanIdInput.val(penjualanId);

                    // Add event listeners for quantity buttons
                    $('.increase-qty').on('click', function () {
                        const index = $(this).data('index');
                        const stok = $(this).data('stok');
                        const input = $(`input[name="barang_juals[${index}][jumlah]"]`);
                        let currentVal = parseInt(input.val());

                        if (currentVal < stok) {
                            input.val(currentVal + 1);
                        }

                        updateTotal();
                    });

                    $('.decrease-qty').on('click', function () {
                        const index = $(this).data('index');
                        const input = $(`input[name="barang_juals[${index}][jumlah]"]`);
                        if (parseInt(input.val()) > 0) {
                            input.val(parseInt(input.val()) - 1);
                        }
                        updateTotal();
                    });
                })
                .catch(error => {
                    console.error('Error fetching penjualan details:', error);
                });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Handler for "Selesai" button
        const selesaiButtons = document.querySelectorAll('.btn-detail-selesai');
        selesaiButtons.forEach(button => {
            button.addEventListener('click', function () {
                const penjualanId = this.getAttribute('data-penjualan-id');

                fetch(`/histori/${penjualanId}`)
                    .then(response => response.json())
                    .then(data => {
                        const penjualan = data.penjualan;
                        const tbody = document.getElementById('modalBodyContentSelesai');
                        const totalHargaElement = document.getElementById('modalTotalHargaSelesai');

                        tbody.innerHTML = '';
                        let totalHarga = 0;

                        penjualan.barang_juals.forEach((barangJual, index) => {
                            const barang = barangJual.barang;
                            const jumlah = barangJual.jumlah;
                            const harga = barang.harga;
                            const totalPerBarang = jumlah * harga;

                            totalHarga += totalPerBarang;

                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${barang.nama}</td>
                                <td>Rp. ${harga.toLocaleString('id-ID')}</td>
                                <td>${jumlah}</td>
                                <td>Rp. ${totalPerBarang.toLocaleString('id-ID')}</td>
                                <td>${barangJual.deskripsi}</td>
                            `;
                            tbody.appendChild(row);
                        });

                        totalHargaElement.textContent = `Rp. ${totalHarga.toLocaleString('id-ID')}`;
                    })
                    .catch(error => {
                        console.error('Error fetching penjualan details:', error);
                    });
            });
        });
    });
</script>

@endsection
