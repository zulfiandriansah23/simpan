<!DOCTYPE html>
<html>
<head>
    <title>Input Barang Keluar Voice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .mic-active{
            background-color:red !important;
            color:white;
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <h3>Input Barang Keluar Dengan Voice Recognition</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('barang-keluar.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Kode Barang Keluar</label>
            <input type="text" name="bk_kode" id="bk_kode" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="bk_tanggal" id="bk_tanggal" class="form-control">
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="bk_jumlah" id="bk_jumlah" class="form-control">
        </div>

        <button type="button" id="btnVoice" class="btn btn-danger">
            🎤 Mulai Voice Input
        </button>

        <button type="submit" class="btn btn-primary">
            Simpan
        </button>

    </form>

    <hr>

    <h5>Hasil Voice :</h5>
    <div id="result" class="alert alert-secondary"></div>

</div>

<script>

    const btnVoice = document.getElementById('btnVoice');
    const result = document.getElementById('result');

    const SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition;

    const recognition = new SpeechRecognition();

    recognition.lang = 'id-ID';
    recognition.continuous = false;
    recognition.interimResults = false;

    btnVoice.addEventListener('click', () => {

        recognition.start();

        btnVoice.classList.add('mic-active');
        btnVoice.innerHTML = '🎙️ Mendengarkan...';

    });

    recognition.onresult = function(event){

        let transcript = event.results[0][0].transcript.toLowerCase();

        result.innerHTML = transcript;

        // ======================
        // AMBIL KODE
        // contoh: kode BK001
        // ======================

        let kodeMatch = transcript.match(/kode\s([a-zA-Z0-9]+)/);

        if(kodeMatch){
            document.getElementById('bk_kode').value = kodeMatch[1].toUpperCase();
        }

        // ======================
        // AMBIL JUMLAH
        // contoh: jumlah 10
        // ======================

        let jumlahMatch = transcript.match(/jumlah\s(\d+)/);

        if(jumlahMatch){
            document.getElementById('bk_jumlah').value = jumlahMatch[1];
        }

        // ======================
        // AMBIL TANGGAL
        // contoh:
        // tanggal 2026-05-20
        // ======================

        let tanggalMatch = transcript.match(/tanggal\s(\d{4}-\d{2}-\d{2})/);

        if(tanggalMatch){
            document.getElementById('bk_tanggal').value = tanggalMatch[1];
        }

    };

    recognition.onend = function(){

        btnVoice.classList.remove('mic-active');
        btnVoice.innerHTML = '🎤 Mulai Voice Input';

    };

</script>

</body>
</html>