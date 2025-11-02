<?php

namespace App\Http\Controllers;

use App\Models\WaterLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class WaterLogController extends Controller
{
    /**
     * READ: Menampilkan daftar catatan air pengguna yang sedang login.
     */
    public function index(): View
    {
        // Mengambil semua catatan air yang dimiliki oleh user yang sedang login
        $logs = Auth::user()->waterLogs()->latest()->get(); 
        
        // Memastikan relasi sudah didefinisikan di Model User
        return view('waterlogs.index', compact('logs'));
    }

    /**
     * CREATE: Menampilkan form tambah data.
     */
    public function create(): View
    {
        return view('waterlogs.create');
    }

    /**
     * CREATE: Menyimpan data baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'amount_ml' => 'required|integer|min:1',
        ]);

        WaterLog::create([
            'user_id' => Auth::id(), // ID pengguna wajib diisi
            'amount_ml' => $validated['amount_ml'],
        ]);

        return redirect()->route('water-logs.index')->with('success', 'Catatan air berhasil ditambahkan!');
    }

    /**
     * UPDATE: Menampilkan form edit.
     */
    public function edit(WaterLog $waterLog): View
    {
        // Guardrail: Pastikan user hanya bisa mengedit log miliknya sendiri
        if (Auth::id() !== $waterLog->user_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('waterlogs.edit', compact('waterLog'));
    }

    /**
     * UPDATE: Memperbarui data yang ada.
     */
    public function update(Request $request, WaterLog $waterLog): RedirectResponse
    {
        if (Auth::id() !== $waterLog->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'amount_ml' => 'required|integer|min:1',
        ]);

        $waterLog->update($validated);

        return redirect()->route('water-logs.index')->with('success', 'Catatan air berhasil diperbarui!');
    }

    /**
     * DELETE: Menghapus data.
     */
    public function destroy(WaterLog $waterLog): RedirectResponse
    {
        if (Auth::id() !== $waterLog->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        $waterLog->delete();

        return redirect()->route('water-logs.index')->with('success', 'Catatan air berhasil dihapus!');
    }
}