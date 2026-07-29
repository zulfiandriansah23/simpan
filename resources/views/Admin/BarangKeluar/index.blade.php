@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Barang Keluar</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Transaksi</li>
                <li class="breadcrumb-item active" aria-current="page">Barang Keluar</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
@if($stokMenipis->count() > 0)
<div class="alert alert-warning position-relative" role="alert">

    <button type="button"
            data-bs-dismiss="alert"
            aria-label="Close"
            style="
                position: absolute;
                top: 10px;
                right: 15px;
                border: none;
                background: transparent;
                font-size: 24px;
                font-weight: bold;
                color: #000;
                cursor: pointer;
                line-height: 1;
            ">
        &times;
    </button>

    <h5 class="mb-2">
        <i class="fe fe-alert-triangle"></i>
        Notifikasi Stok Menipis
    </h5>

    <ul class="mb-0">
        @foreach($stokMenipis as $barang)
            <li>
    Kode: <strong>{{ $barang->barang_kode }}</strong> |
    Nama: {{ $barang->barang_nama }} |
    Stok: <span class="text-danger">{{ $barang->barang_stok }}</span>
</li>
        @endforeach
    </ul>

</div>
@endif
    <!-- ROW -->
    
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header justify-content-between">
                 <h3 class="card-title">Data</h3>

    @if ($hakTambah > 0)
    <div class="d-flex gap-2">

        <!-- TOMBOL VOICE -->
        <button type="button"
                id="btnVoice"
                class="btn btn-danger-light">
            Voice Input
            <i class="fe fe-mic"></i>
        </button>

        <!-- TOMBOL TAMBAH -->
        <a class="modal-effect btn btn-primary-light"
            onclick="generateID()"
            data-bs-effect="effect-super-scaled"
            data-bs-toggle="modal"
            href="#modaldemo8">

            Tambah Data
            <i class="fe fe-plus"></i>

        </a>

    </div>
    @endif
</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-1"
                            class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                            <thead>
                                <th class="border-bottom-0" width="1%">No</th>
                                <th class="border-bottom-0">Tanggal Keluar</th>
                                <th class="border-bottom-0">Kode Barang Keluar</th>
                                <th class="border-bottom-0">Kode Barang</th>
                                <th class="border-bottom-0">Barang</th>
                                <th class="border-bottom-0">Jumlah Keluar</th>
                                <th class="border-bottom-0">Tujuan</th>
                                <th class="border-bottom-0" width="1%">Action</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->

    @include('Admin.BarangKeluar.tambah')
    @include('Admin.BarangKeluar.edit')
    @include('Admin.BarangKeluar.hapus')
    @include('Admin.BarangKeluar.barang')

    <script>
        function generateID() {
            id = new Date().getTime();
            $("input[name='bkkode']").val("BK-" + id);
        }

        function update(data) {
            $("input[name='idbkU']").val(data.bk_id);
            $("input[name='bkkodeU']").val(data.bk_kode);
            $("input[name='kdbarangU']").val(data.barang_kode);
            $("input[name='jmlU']").val(data.bk_jumlah);
            $("input[name='tujuanU']").val(data.bk_tujuan.replace(/_/g, ' '));

            getbarangbyidU(data.barang_kode);

            $("input[name='tglkeluarU").bootstrapdatepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            }).bootstrapdatepicker("update", data.bk_tanggal);
        }

        function hapus(data) {
            $("input[name='idbk']").val(data.bk_id);
            $("#vbk").html("Kode BK " + "<b>" + data.bk_kode + "</b>");
        }

        function validasi(judul, status) {
            swal({
                title: judul,
                type: status,
                confirmButtonText: "Iya."
            });
        }
    </script>
@endsection

@section('scripts')

<script>

    // ==============================
    // VOICE RECOGNITION
    // ==============================

    const SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition;

    const recognition = new SpeechRecognition();

    recognition.lang = 'id-ID';
    recognition.continuous = false;
    recognition.interimResults = false;

    const btnVoice = document.getElementById('btnVoice');

    btnVoice.addEventListener('click', function(){

        recognition.start();

        btnVoice.innerHTML = '🎙️ Mendengarkan...';
        btnVoice.classList.remove('btn-danger-light');
        btnVoice.classList.add('btn-success');

    });

recognition.onresult = function(event){

    let text = event.results[0][0].transcript.toLowerCase().trim();

    console.log("VOICE :", text);

    // =====================================
    // NORMALISASI SPASI
    // contoh:
    // "brg 001 jumlah 10"
    // menjadi:
    // "brg001 jumlah 10"
    // =====================================

    text = text.replace(/b\s+(\d+)/g, 'b$1');

    console.log("NORMAL :", text);

    // =====================================
    // AMBIL KODE BARANG
    // contoh:
    // BRG001
    // =====================================

    let kode = text.match(/(b\d+)/i);

    // =====================================
    // AMBIL JUMLAH
    // contoh:
    // jumlah 10
    // =====================================

    let jumlah = text.match(/jumlah\s+(\d+)/i);

    // =====================================
    // VALIDASI
    // =====================================

    if(kode && jumlah){

        // buka modal
        generateID();

        $('#modaldemo8').modal('show');

        // isi form
        $("input[name='kdbarang']").val(
            kode[1].toUpperCase()
        );

        $("input[name='jml']").val(
            jumlah[1]
        );

        // tanggal otomatis
        let today = new Date().toISOString().split('T')[0];

        $("input[name='tglkeluar']").val(today);

        // optional:
        // jika ada function ambil barang
        if(typeof getbarangbyid === 'function'){
            getbarangbyid(kode[1].toUpperCase());
        }

        swal({
            title: "Voice berhasil dikenali",
            text:
                "Kode : " + kode[1].toUpperCase() +
                "\nJumlah : " + jumlah[1],
            type: "success"
        });

    }else{

        swal({
            title: "Voice tidak dikenali",
            text: "Contoh : B01 jumlah 10",
            type: "error"
        });

    }

};

    recognition.onend = function(){

        btnVoice.innerHTML = 'Voice Input <i class="fe fe-mic"></i>';

        btnVoice.classList.remove('btn-success');
        btnVoice.classList.add('btn-danger-light');

    };

</script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table;
        $(document).ready(function() {
            //datatables
            table = $('#table-1').DataTable({

                "processing": true,
                "serverSide": true,
                "info": true,
                "order": [],
                "scrollX": true,
                "stateSave":true,
                "lengthMenu": [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],
                "pageLength": 10,

                lengthChange: true,

                "ajax": {
                    "url": "{{ route('barang-keluar.getbarang-keluar') }}",
                },

                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'tgl',
                        name: 'bk_tanggal',
                    },
                    {
                        data: 'bk_kode',
                        name: 'bk_kode',
                    },
                    {
                        data: 'barang_kode',
                        name: 'barang_kode',
                    },
                    {
                        data: 'barang',
                        name: 'barang_nama',
                    },
                    {
                        data: 'bk_jumlah',
                        name: 'bk_jumlah',
                    },
                    {
                        data: 'tujuan',
                        name: 'bk_tujuan',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],

            });
        });
    </script>
@endsection
