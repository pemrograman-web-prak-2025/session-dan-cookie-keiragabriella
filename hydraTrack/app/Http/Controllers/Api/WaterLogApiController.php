<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WaterLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WaterLogApiController extends Controller
{
    /**
     * GET: READ ALL - Mengambil semua data WaterLog
     */
    public function index()
    {
        $logs = WaterLog::all(); // Mengambil semua data
        return response()->json([
            'status' => 'success',
            'message' => 'Data WaterLog berhasil diambil.',
            'data' => $logs
        ], 200);
    }

    /**
     * POST: CREATE - Menambah data WaterLog baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id', // Wajib ada user_id yang valid
            'amount_ml' => 'required|integer|min:1',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan data
        $waterLog = WaterLog::create($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'WaterLog berhasil ditambahkan.',
            'data' => $waterLog
        ], 201); // 201 Created
    }

    /**
     * GET: READ BY ID - Mengambil satu data detail
     */
    public function show($id)
    {
        $waterLog = WaterLog::find($id);

        if (!$waterLog) {
            return response()->json([
                'status' => 'error',
                'message' => 'WaterLog tidak ditemukan.',
                'data' => null
            ], 404); // 404 Not Found
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail WaterLog berhasil diambil.',
            'data' => $waterLog
        ], 200);
    }

    /**
     * PUT/PATCH: UPDATE - Memperbarui data
     */
    public function update(Request $request, $id)
    {
        $waterLog = WaterLog::find($id);

        if (!$waterLog) {
            return response()->json([
                'status' => 'error',
                'message' => 'WaterLog tidak ditemukan.',
                'data' => null
            ], 404);
        }

        // Validasi hanya untuk field yang dikirim (sometimes)
        $validator = Validator::make($request->all(), [
            'amount_ml' => 'sometimes|integer|min:1',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $waterLog->update($validator->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'WaterLog berhasil diperbarui.',
            'data' => $waterLog
        ], 200);
    }

    /**
     * DELETE: DESTROY - Menghapus data
     */
    public function destroy($id)
    {
        $waterLog = WaterLog::find($id);

        if (!$waterLog) {
            return response()->json([
                'status' => 'error',
                'message' => 'WaterLog tidak ditemukan.',
                'data' => null
            ], 404);
        }

        $waterLog->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'WaterLog berhasil dihapus.',
            'data' => null
        ], 200);
    }
}