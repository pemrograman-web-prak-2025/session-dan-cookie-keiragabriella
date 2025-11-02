<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HydraTracker - Catatan Air</title>
    <style>
        /* Light Mode (Earthy/Minimalist Theme) */
        :root {
            --bg-color: #f7f3ed; /* Light Beige Background */
            --container-bg: #ffffff;
            --text-color: #3f3f3f; /* Dark Taupe Text */
            --primary-color: #a38c82; /* Dusty Rose/Taupe Accent */
            --secondary-color: #8c8c8c; 
            --input-border: #d4d0c7;
            --shadow-color: rgba(0, 0, 0, 0.08);
            --table-row-even: #fcfcfc;
            --success-bg: #e5f5e0;
            --success-text: #2c6e49;
        }

        /* Dark Mode Variables (Earthy/Minimalist Dark) */
        body.dark-mode {
            --bg-color: #2e2825; /* Dark Brown/Mocha Background */
            --container-bg: #3c3532;
            --text-color: #e3dcd7; /* Light Text */
            --primary-color: #c9b1a7; /* Light Rose Accent */
            --secondary-color: #bfa79f;
            --input-border: #5a514d;
            --shadow-color: rgba(255, 255, 255, 0.05);
            --table-row-even: #332f2c;
            --success-bg: #2d4533;
            --success-text: #a8dadc;
        }

        body { 
            font-family: 'Georgia', serif; /* Font lebih elegan */
            background-color: var(--bg-color); 
            color: var(--text-color); 
            margin: 0; 
            padding: 40px 20px; 
            transition: background-color 0.4s, color 0.4s;
        }
        .container { 
            max-width: 900px; 
            margin: 0 auto; 
            background: var(--container-bg); 
            padding: 40px; 
            border-radius: 16px; 
            box-shadow: 0 8px 20px var(--shadow-color); 
            transition: background-color 0.4s;
        }
        h1 { 
            color: var(--primary-color); 
            text-align: center; 
            margin-bottom: 35px; 
            font-size: 2.2em;
            font-weight: 300; 
            border-bottom: 1px solid var(--input-border);
            padding-bottom: 15px;
        }
        .success { 
            background-color: var(--success-bg); 
            color: var(--success-text); 
            padding: 15px; 
            border-radius: 8px; 
            margin-bottom: 25px; 
            font-weight: bold;
        }

        .log-table { width: 100%; border-collapse: separate; border-spacing: 0; margin-top: 20px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px var(--shadow-color); }
        .log-table th, .log-table td { padding: 15px; text-align: left; border-bottom: 1px solid var(--input-border); }
        .log-table th { background-color: var(--primary-color); color: white; font-weight: 500; }
        .log-table tr:nth-child(even) { background-color: var(--table-row-even); }
        .log-table tr:hover { background-color: rgba(163, 140, 130, 0.1); } /* Hover Earthy */

        /* BUTTONS */
        .btn { padding: 10px 18px; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; font-weight: bold; transition: background-color 0.3s, transform 0.1s; letter-spacing: 0.5px; }
        .btn-primary { background-color: var(--primary-color); color: white; box-shadow: 0 2px 5px rgba(163, 140, 130, 0.4); }
        .btn-primary:hover { background-color: var(--secondary-color); transform: translateY(-1px); }
        .btn-secondary { background-color: var(--secondary-color); color: white; }
        .btn-secondary:hover { background-color: #7d7d7d; }
        .btn-edit { background-color: #ffc107; color: white; padding: 5px 10px; border-radius: 5px; font-size: 0.9em; }
        .btn-delete { background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 5px; font-size: 0.9em; }
        .btn-toggle {
            background: none;
            border: 1px solid var(--text-color);
            color: var(--text-color);
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-toggle:hover {
            background-color: rgba(163, 140, 130, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <button id="mode-toggle" class="btn-toggle">Mode Gelap: OFF</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">⬅️ Kembali ke Dashboard</a>
        </div>
        
        <h1>Catatan Asupan Air Harian 💧</h1>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        <div style="margin-bottom: 20px;">
            <a href="{{ route('water-logs.create') }}" class="btn btn-primary">➕ Tambah Catatan Baru</a>
        </div>
        
        @if ($logs->isEmpty())
            <p style="text-align: center; margin-top: 50px; font-size: 1.2em; color: var(--secondary-color);">Anda belum memiliki catatan asupan air. Ayo mulai minum air!</p>
        @else
            <table class="log-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah (ml)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td class="amount-ml">{{ $log->amount_ml }} ml</td>
                            <td>
                                <a href="{{ route('water-logs.edit', $log->id) }}" class="btn btn-edit">Edit</a>
                                
                                <form action="{{ route('water-logs.destroy', $log->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus catatan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script>
        const toggleButton = document.getElementById('mode-toggle');
        const body = document.body;
        const storageKey = 'hydraTrackerDarkMode';

        function applyMode(isDark) {
            if (isDark) {
                body.classList.add('dark-mode');
                toggleButton.textContent = 'Mode Gelap: ON 🌙';
                localStorage.setItem(storageKey, 'dark');
            } else {
                body.classList.remove('dark-mode');
                toggleButton.textContent = 'Mode Gelap: OFF ☀️';
                localStorage.setItem(storageKey, 'light');
            }
        }

        // Cek status terakhir saat halaman dimuat (Persistensi)
        const savedMode = localStorage.getItem(storageKey);
        if (savedMode === 'dark') {
            applyMode(true);
        } else {
             // Default ke light jika belum ada atau 'light'
             applyMode(false);
        }

        // Tambahkan event listener untuk tombol toggle
        toggleButton.addEventListener('click', () => {
            const isCurrentlyDark = body.classList.contains('dark-mode');
            applyMode(!isCurrentlyDark);
        });
    </script>
</body>
</html>
