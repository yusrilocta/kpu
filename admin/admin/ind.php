<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = array(
        'id_tps' => $_POST['id_tps'],
        'kec' => $_POST['kec'],
        'desa' => $_POST['desa'],
        'notps' => $_POST['notps'],
        'peml' => $_POST['peml'],
        'pemp' => $_POST['pemp'],
        'duaper' => $_POST['duaper'],
        'id_calon' => $_POST['id_calon'],
        'nama_calon' => $_POST['nama_calon'],
        'nama_partai' => $_POST['nama_partai'],
        'no_urut' => $_POST['no_urut'],
        'pemlss' => $_POST['pemlss'],
        'pempss' => $_POST['pempss'],
        'tdua' => $_POST['tdua'],
    );

    // Koneksi ke database
    $host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'admin';

    $conn = new mysqli($host, $db_user, $db_pass, $db_name);

    // Cek koneksi ke database
    if ($conn->connect_error) {
        die("Koneksi ke database gagal: " . $conn->connect_error);
    }

    // Looping untuk menginput data dari array
    foreach ($data['id_calon'] as $key => $value) {
        $id_calon = $value;
        $id_tps = $data['id_tps'][$key];
        $kec = $data['kec'][$key];
        $desa = $data['desa'][$key];
        $notps = $data['notps'][$key];
        $pemp = $data['pemp'][$key];
        $peml = $data['peml'][$key];
        $duaper = $data['duaper'][$key];
        $id_calon = $data['id_calon'][$key];
        $nama_calon = $data['nama_calon'][$key];
        $nama_partai = $data['nama_partai'][$key];
        $no_urut = $data['no_urut'][$key];
        $pemlss = $data['pemlss'][$key];
        $pempss = $data['pempss'][$key];
        $total = $peml + $pemp;

        // Query untuk meng-input data ke tabel "tps"
        $queryTPS = "INSERT INTO tps (kec, desa, notps, peml, pemp, duaper) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtTPS = $conn->prepare($queryTPS);
        $stmtTPS->bind_param('ssssss', $kec, $desa, $notps, $peml, $pemp, $duaper);
        
        // Query untuk meng-input data ke tabel "calon"
        $queryCalon = "INSERT INTO calon (nama_partai, nama_calon, no_urut) VALUES (?, ?, ?)";
        $stmtCalon = $conn->prepare($queryCalon);
        $stmtCalon->bind_param('sss', $nama_partai, $nama_calon, $no_urut);
        
        // Query untuk meng-input data ke tabel "pemilu"
        $queryPemilu = "INSERT INTO pemilu (id_calon, id_tps, peml, pemp, total) VALUES (?, ?, ?, ?, ?)";
        $stmtPemilu = $conn->prepare($queryPemilu);
        $stmtPemilu->bind_param('sssss', $id_calon, $id_tps, $pemlss, $pempss, $total);

        // Eksekusi query untuk setiap data
        if ($stmtTPS->execute() && $stmtCalon->execute() && $stmtPemilu->execute()) {
            echo "Data berhasil di-input ke database.";
        } else {
            echo "Terjadi kesalahan: " . $conn->error;
            break; // Berhenti jika terjadi kesalahan pada salah satu data
        }
    }
    $stmtTPS->close();
    $stmtCalon->close();
    $stmtPemilu->close();
    $conn->close();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Qiuck Count</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>
<body>
    <h2>Tempelkan Data dari Spreadsheet</h2>
    <form id="pasteForm">
        <div class="form-group">
            <label for="pasteData">Tempelkan Data:</label>
            <textarea class="form-control" id="pasteData" name="pasteData" rows="6" placeholder="Tempelkan data di sini"></textarea>
        </div>
        <button type="button" onclick="parseAndPasteData()" class="btn btn-primary">Tempelkan Data</button>
    </form>
    
    <div id="parsedData">
        <!-- Hasil data yang ditempelkan akan muncul di sini -->
    </div>

    <script>
    function parseAndPasteData() {
    const pasteData = document.getElementById('pasteData').value;
    const lines = pasteData.split('\n');
    const dataArray = [];

    lines.forEach(line => {
        const columns = line.split(/\s+/); // Menggunakan spasi sebagai pemisah
        if (columns.length === 14) {
            const data = {
                id_tps: columns[0].trim(),
                kec: columns[1].trim(),
                desa: columns[2].trim(),
                notps: columns[3].trim(),
                peml: columns[4].trim(),
                pemp: columns[5].trim(),
                duaper: columns[6].trim(),
                id_calon: columns[7].trim(),
                nama_calon: columns[8].trim(),
                nama_partai: columns[9].trim(),
                no_urut: columns[10].trim(),
                pemlss: columns[11].trim(),
                pempss: columns[12].trim(),
                tdua: columns[13].trim(),
            };
            dataArray.push(data);
        }
    });

    if (dataArray.length > 0) {
    const arrayForm = document.createElement('form');
    arrayForm.className = 'container mt-3'; // Tambahkan kelas Bootstrap untuk tata 
    arrayForm.method = 'POST';
    
    dataArray.forEach((data, index) => {
        const rowDiv = document.createElement('div');
        rowDiv.className = 'row mb-3'; // Tambahkan kelas Bootstrap untuk baris dan margin bawah
        
        Object.keys(data).forEach(key => {
            const colDiv = document.createElement('div');
            colDiv.className = 'col'; // Tambahkan kelas Bootstrap untuk kolom
            
            const label = document.createElement('label');
            label.textContent = key.charAt(0).toUpperCase() + key.slice(1) + ' ' + (index + 1) + ':';
            label.className = 'form-label'; // Tambahkan kelas Bootstrap untuk label
            
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control'; // Tambahkan kelas Bootstrap untuk input
            input.name  = key + '[]';
            input.value = data[key];

            colDiv.appendChild(label);
            colDiv.appendChild(input);
            rowDiv.appendChild(colDiv);
        });

        arrayForm.appendChild(rowDiv);
    });

    // Tombol Submit Data
    const submitButton = document.createElement('button');
    submitButton.type = 'submit';
    submitButton.className = 'btn btn-primary';
    submitButton.textContent = 'Submit Data';
    arrayForm.appendChild(submitButton);

    document.getElementById('parsedData').innerHTML = '';
    document.getElementById('parsedData').appendChild(arrayForm);
} else {
    document.getElementById('parsedData').innerHTML = 'Tidak ada data yang valid.';
}


}

    </script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>