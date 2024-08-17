@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
@include('layouts.navbars.topnav', ['title' => 'Barang'])
@include('sweetalert::alert')
<head>
    <style>
        .table th,
        .table td,
        .table tfoot th {
            text-align: center;
            vertical-align: middle;
        }

        .input-group .form-control {
            text-align: center;
        }

        .jumlah-barang {
            width: 60px;
            /* Adjust this value to make the field smaller or larger */
        }

        .modal-footer .btn {
            margin: 0;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
        }
    </style>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="container-fluid px-0 px-sm-4 py-3">
    <div class="card">
        <div class="card-header">
            <h5>Total Harga: Rp. <span id="total-harga">0</span></h5>
            <button class="btn btn-success btn-lg" data-toggle="modal" data-target="#summaryModal">Lanjut</button>
        </div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="m-0 lh-1">Daftar Barang</h6>
            <input type="text" id="search-bar" class="form-control w-25" placeholder="Cari Barang">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-striped w-auto">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Nama</th>
                            <th>Gudang</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Stok</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['barang'] as $barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $barang->kategori->nama }}</td>
                            <td>{{ $barang->nama }}</td>
                            <td>{{ $barang->gudang->nama }}</td>
                            <td>{{ $barang->satuan->nama }}</td>
                            <td data-id="{{ $loop->iteration }}" data-harga="{{ $barang->harga }}">Rp.{{ number_format($barang->harga, 0, ',', '.') }}</td>
                            <td>{{ $barang->jumlah }}</td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary btn-decrement" type="button"
                                            data-id="{{ $loop->iteration }}" data-max="{{ $barang->jumlah }}">-</button>
                                    </div>
                                    <input type="text" class="form-control text-center jumlah-barang" value="0"
                                        data-id="{{ $loop->iteration }}" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-increment" type="button"
                                            data-id="{{ $loop->iteration }}" data-max="{{ $barang->jumlah }}">+</button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input type="text" class="form-control deskripsi-barang" data-id="{{ $loop->iteration }}" placeholder="Masukkan Deskripsi">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Nama</th>
                            <th>Gudang</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Stok</th>
                            <th>Jumlah</th>
                            <th>Deskripsi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Ringkasan Jual -->
    <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="summaryModalLabel">Ringkasan Pembelian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                        <tbody id="modal-body-content">
                        </tbody>
                    </table>
                    <h6 class="text-center">Total Harga: Rp. <span id="modal-total-harga">0</span></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning">Tunggu</button>
                    <button type="button" class="btn btn-primary" id="btnSelesai">Selesai</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- JS Jual -->
    <script>
        $(document).ready(function () {
            // Event listener untuk input pencarian
            $('#search-bar').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('#table tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            function updateTotal() {
                let totalHarga = 0;

                $('.jumlah-barang').each(function () {
                    const id = $(this).data('id');
                    const jumlah = parseInt($(this).val());
                    const harga = parseInt($(`td[data-id='${id}']`).data('harga'));

                    if (!isNaN(jumlah) && !isNaN(harga)) {
                        totalHarga += jumlah * harga;
                    }
                });

                $('#total-harga').text(totalHarga.toLocaleString('id-ID'));
            }

            $('.btn-increment').on('click', function () {
                const id = $(this).data('id');
                const max = parseInt($(this).data('max'));
                const input = $(`.jumlah-barang[data-id='${id}']`);
                let currentVal = parseInt(input.val());

                if (currentVal < max) {
                    input.val(currentVal + 1);
                }

                updateTotal();
            });

            $('.btn-decrement').on('click', function () {
                const id = $(this).data('id');
                const input = $(`.jumlah-barang[data-id='${id}']`);
                let currentVal = parseInt(input.val());

                if (currentVal > 0) {
                    input.val(currentVal - 1);
                }

                updateTotal();
            });

            // js modal ringkasan
            $('.btn-lg').on('click', function() {
                let modalContent = '';
                let totalHarga = 0;

                $('.jumlah-barang').each(function () {
                    const id = $(this).data('id');
                    const jumlah = parseInt($(this).val());
                    const deskripsi = $(`.deskripsi-barang[data-id='${id}']`).val();
                    const harga = parseInt($(`td[data-id='${id}']`).data('harga'));
                    const nama = $(`td[data-id='${id}']`).siblings().eq(2).text();

                    if (!isNaN(jumlah) && jumlah > 0) {
                        const total = jumlah * harga;
                        totalHarga += total;
                        modalContent += `
                            <tr data-barang-id="${id}">
                                <td>${id}</td>
                                <td>${nama}</td>
                                <td>Rp. ${harga.toLocaleString('id-ID')}</td>
                                <td>${jumlah}</td>
                                <td>Rp. ${total.toLocaleString('id-ID')}</td>
                                <td>${deskripsi}</td>
                            </tr>
                        `;
                    }
                });

                $('#modal-body-content').html(modalContent);
                $('#modal-total-harga').text(totalHarga.toLocaleString('id-ID'));
            });

            // Fungsi untuk membersihkan dan mengonversi total harga
            function parseCurrency(value) {
                return parseInt(value.replace(/[^0-9]/g, ''), 10);
            }

            // Fungsi untuk mengirim data ke server dengan status
            function sendData(status) {
                let items = [];
                $('#modal-body-content tr').each(function() {
                    let barang_id = $(this).data('barang-id'); // Ambil ID barang dari atribut data
                    let deskripsi = $(this).find('td').eq(5).text(); // Kolom deskripsi
                    let jumlah = parseInt($(this).find('td').eq(3).text()); // Kolom jumlah

                    if (jumlah > 0) {
                        items.push({
                            barang_id: barang_id,
                            deskripsi: deskripsi,
                            jumlah: jumlah // Menambahkan jumlah ke data yang dikirim
                        });
                    }
                });

                let totalHarga = parseCurrency($('#modal-total-harga').text());

                $.ajax({
                    url: '{{ route("simpanPenjualan") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        total_harga: totalHarga,
                        items: items,
                        status: status
                    },
                    success: function(response) {
                        console.log('Data berhasil disimpan:', response);
                        Swal.fire({
                            icon: 'success',
                            title: 'Penjualan berhasil!',
                            showConfirmButton: true,
                            allowOutsideClick: false // Agar pengguna tidak bisa menutup pesan dengan klik di luar SweetAlert
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseText);
                        alert('Terjadi kesalahan saat menyimpan data: ' + xhr.responseText);
                    }
                });
            }

            // Event handler untuk tombol "Tunggu"
            $('.btn-warning').on('click', function() {
                sendData(1); // Status 1 untuk "Tunggu"
            });

            // Event handler untuk tombol "Selesai"
            $('.btn-primary').on('click', function() {
                sendData(2); // Status 2 untuk "Selesai"
            });
        });
    </script>

@endsection
