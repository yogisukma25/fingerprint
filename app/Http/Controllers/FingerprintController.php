<?php

namespace App\Http\Controllers;

use App\Models\Fingerprint;
use Illuminate\Http\Request;

class FingerprintController extends Controller
{
    // Fungsi untuk cek apakah sidik jari sudah terdaftar
    public function check(Request $request)
    {
        $fingerID = $request->input('fingerID');

        // Cek di database apakah sidik jari sudah ada
        $fingerprint = Fingerprint::where('finger_id', $fingerID)->first();

        if ($fingerprint) {
            return response()->json(['status' => 'exists', 'message' => 'Sidik jari sudah terdaftar'], 200);
        } else {
            return response()->json(['status' => 'not_found', 'message' => 'Sidik jari belum terdaftar'], 404);
        }
    }

    // Fungsi untuk mendaftarkan sidik jari baru
    public function register(Request $request)
    {
        $fingerID = $request->input('fingerID');
        $confidence = $request->input('confidence');

        // Cek apakah sidik jari sudah ada
        $exists = Fingerprint::where('finger_id', $fingerID)->exists();

        if ($exists) {
            return response()->json(['status' => 'exists', 'message' => 'Sidik jari sudah terdaftar'], 200);
        }

        // Simpan sidik jari baru ke database
        $fingerprint = new Fingerprint();
        $fingerprint->finger_id = $fingerID;
        $fingerprint->confidence = $confidence;
        $fingerprint->save();

        return response()->json(['status' => 'success', 'message' => 'Sidik jari berhasil didaftarkan'], 201);
    }
}