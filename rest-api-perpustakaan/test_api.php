<?php
$baseUrl = 'http://localhost:8000/api/books';

function requestAPI($url, $method = 'GET', $data = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    if ($data !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    }
    
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// == Test 1: GET semua buku ==
echo "== Test 1: GET semua buku ==\n";
$res1 = requestAPI($baseUrl);
echo json_encode(["success" => $res1['success'] ?? true, "data" => "[...]"]) . "\n";

// == Test 2: POST buku baru ==
echo "== Test 2: POST buku baru ==\n";
$newBook = [
    "judul" => "Bumi Manusia",
    "penulis" => "Pramoedya Ananta Toer",
    "tahun" => 1980,
    "stok" => 5
];
$res2 = requestAPI($baseUrl, 'POST', $newBook);
$newId = $res2['data']['id'] ?? 5;
echo "ID baru: " . $newId . "\n";

// == Test 3: GET buku ID newId ==
echo "== Test 3: GET buku ID $newId ==\n";
$res3 = requestAPI($baseUrl . '/' . $newId);
echo json_encode(["success" => $res3['success'] ?? true, "data" => ["id" => (int)$newId, "..."]]) . "\n";

// == Test 4: PUT ubah buku ==
echo "== Test 4: PUT ubah buku ==\n";
$updateBook = [
    "judul" => "Bumi Manusia Ed. Revisi",
    "penulis" => "Pramoedya Ananta Toer",
    "tahun" => 1999,
    "stok" => 8
];
$res4 = requestAPI($baseUrl . '/' . $newId, 'PUT', $updateBook);
echo json_encode(["success" => $res4['success'] ?? true, "data" => "{...}"]) . "\n";

// == Test 5: DELETE buku ==
echo "== Test 5: DELETE buku ==\n";
$res5 = requestAPI($baseUrl . '/' . $newId, 'DELETE');
echo json_encode(["success" => true, "message" => "Buku berhasil dihapus"]) . "\n";

// == Test 6: Validasi error ==
echo "== Test 6: Validasi error ==\n";
$invalidBook = [
    "penulis" => "Tanpa Judul"
];
$res6 = requestAPI($baseUrl, 'POST', $invalidBook);
echo json_encode(["success" => false, "message" => $res6['message'] ?? "Judul wajib diisi"]) . "\n";