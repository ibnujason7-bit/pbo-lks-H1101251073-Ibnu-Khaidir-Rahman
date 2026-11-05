<?php
$baseUrl = 'http://localhost:8000/api/categories';

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

echo "=== UJI COBA API KATEGORI ===\n\n";

// 1. GET Semua Kategori
echo "1. GET Semua Kategori:\n";
$res1 = requestAPI($baseUrl);
echo json_encode($res1) . "\n\n";

// 2. POST Kategori Baru
echo "2. POST Tambah Kategori Baru:\n";
$res2 = requestAPI($baseUrl, 'POST', ['nama_kategori' => 'Fiksi Remaja']);
echo json_encode($res2) . "\n\n";

$newId = $res2['data']['id'] ?? 1;

// 3. GET Kategori Berdasarkan ID
echo "3. GET Kategori ID $newId:\n";
$res3 = requestAPI($baseUrl . '/' . $newId);
echo json_encode($res3) . "\n\n";

// 4. PUT Ubah Kategori
echo "4. PUT Ubah Kategori ID $newId:\n";
$res4 = requestAPI($baseUrl . '/' . $newId, 'PUT', ['nama_kategori' => 'Fiksi & Sastra']);
echo json_encode($res4) . "\n\n";

// 5. DELETE Kategori
echo "5. DELETE Kategori ID $newId:\n";
$res5 = requestAPI($baseUrl . '/' . $newId, 'DELETE');
echo json_encode($res5) . "\n";