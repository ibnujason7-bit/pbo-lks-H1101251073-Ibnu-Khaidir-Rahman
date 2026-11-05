#!/bin/bash

BASE_URL="http://localhost:8000/api/books"

echo "== Test 1: GET semua buku =="
curl -s -X GET "$BASE_URL" | jq -c '{success: .success, data: "[...]"}'

echo "== Test 2: POST buku baru =="
POST_RES=$(curl -s -X POST "$BASE_URL" \
  -H "Content-Type: application/json" \
  -d '{"judul":"Bumi Manusia","penulis":"Pramoedya Ananta Toer","tahun":1980,"stok":5}')
NEW_ID=$(echo "$POST_RES" | jq -r '.data.id // 5')
echo "ID baru: $NEW_ID"

echo "== Test 3: GET buku ID $NEW_ID =="
curl -s -X GET "$BASE_URL/$NEW_ID" | jq -c '{success: .success, data: {id: .data.id, "...": null}}'

echo "== Test 4: PUT ubah buku =="
curl -s -X PUT "$BASE_URL/$NEW_ID" \
  -H "Content-Type: application/json" \
  -d '{"judul":"Bumi Manusia Ed. Revisi","penulis":"Pramoedya Ananta Toer","tahun":1999,"stok":8}' | jq -c '{success: .success, data: "{...}"}'

echo "== Test 5: DELETE buku =="
curl -s -X DELETE "$BASE_URL/$NEW_ID" | jq -c '{success: .success, message: .message}'

echo "== Test 6: Validasi error =="
curl -s -X POST "$BASE_URL" \
  -H "Content-Type: application/json" \
  -d '{"penulis":"Tanpa Judul"}' | jq -c '{success: .success, message: .message}'