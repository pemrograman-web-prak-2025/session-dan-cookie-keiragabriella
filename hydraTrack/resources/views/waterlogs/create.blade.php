<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan Air</title>
    <style>
        /* Shared variables from index.blade.php */
        :root {
            --bg-color: #f7f3ed; 
            --container-bg: #ffffff;
            --text-color: #3f3f3f; 
            --primary-color: #a38c82; 
            --secondary-color: #8c8c8c;
            --input-border: #d4d0c7;
            --shadow-color: rgba(0, 0, 0, 0.08);
            --success-bg: #e5f5e0;
            --success-text: #2c6e49;
        }

        body.dark-mode {
            --bg-color: #2e2825; 
            --container-bg: #3c3532;
            --text-color: #e3dcd7; 
            --primary-color: #c9b1a7; 
            --secondary-color: #bfa79f;
            --input-border: #5a514d;
            --shadow-color: rgba(255, 255, 255, 0.05);
            --success-bg: #2d4533;
            --success-text: #a8dadc;
        }

        body { 
            font-family: 'Georgia', serif; 
            background-color: var(--bg-color); 
            color: var(--text-color); 
            margin: 0; 
            padding: 40px 20px; 
            transition: background-color 0.4s, color 0.4s;
        }
        .container { 
            max-width: 600px; 
            margin: 0 auto; 
            background: var(--container-bg); 
            padding: 40px; 
            border-radius: 16px; 
            box-shadow: 0 8px 20px var(--shadow-color); 
            transition: background-color 0.4s;
        }
        h1 { color: var(--primary-color); text-align: center; margin-bottom: 35px; font-size: 2.2em; font-weight: 300; }
        .form-group { margin-bottom: 25px; }
        label { display: block; margin-bottom: 8px; font-weight: 500; color: var(--text-color); }
        input[type="number"] { 
            width: 100%; 
            padding: 14px; 
            border: 1px solid var(--input-border); 
            border-radius: 8px; 
            box-sizing: border-box; 
            font-size: 1em; 
            transition: border-color 0.3s;
            background-color: var(--container-bg); 
            color: var(--text-color);
        }
        input[type="number"]:focus { 
            border-color: var(--primary-color); 
            outline: none; 
            box-shadow: 0 0 0 2px var(--primary-color); 
        }
        .btn { padding: 12px 25px; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; font-weight: bold; transition: background-color 0.3s, transform 0.1s; letter-spacing: 0.5px; }
        .btn-success { background-color: var(--primary-color); color: white; box-shadow: 0 4px 6px rgba(163, 140, 130, 0.4); }
        .btn-success:hover { background-color: var(--secondary-color); transform: translateY(-2px); box-shadow: 0 6px 10px rgba(163, 140, 130, 0.4); }
        .error { color: #dc3545; font-size: 0.9em; margin-top: 5px; display: block; }
        .action-links a { color: var(--primary-color); text-decoration: none; font-weight: 500; }
        .action-links a:hover { color: var(--secondary-color); }
    </style>
</head>
<body>
    <div class="container">
        <div class="action-links" style="text-align: left; margin-bottom: 20px;">
            <a href="{{ route('water-logs.index') }}">⬅️ Kembali ke Daftar Catatan</a>
        </div>
        <h1>Tambah Catatan Air Baru 💧</h1>

        <form action="{{ route('water-logs.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="amount_ml">Jumlah Air (ml):</label>
                <input type="number" name="amount_ml" id="amount_ml" value="{{ old('amount_ml') }}" required min="1">
                @error('amount_ml')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Simpan Catatan</button>
        </form>
        
        @if ($errors->any())
            <div style="color: var(--primary-color); margin-top: 15px; padding: 10px; border: 1px solid var(--primary-color); border-radius: 8px; background-color: rgba(163, 140, 130, 0.1);">
                <p>⚠️ Terdapat kesalahan input:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <script>
        // Logika Dark Mode Persistensi
        const body = document.body;
        const storageKey = 'hydraTrackerDarkMode';

        const savedMode = localStorage.getItem(storageKey);
        if (savedMode === 'dark') {
            body.classList.add('dark-mode');
        }
    </script>
</body>
</html>
