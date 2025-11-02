<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard HydraTracker</title>
    <style>
        /* Shared variables from index.blade.php */
        :root {
            --bg-color: #f7f3ed; /* Light Beige Background */
            --container-bg: #ffffff;
            --text-color: #3f3f3f; 
            --primary-color: #a38c82; /* Dusty Rose/Taupe Accent */
            --secondary-color: #8c8c8c;
            --input-border: #d4d0c7;
            --shadow-color: rgba(0, 0, 0, 0.08);
            --success-bg: #e5f5e0;
            --success-text: #2c6e49;
            --nav-bg: #fdfbf8; /* Very light background for sidebar */
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
            --nav-bg: #35302e; 
        }

        body { 
            font-family: 'Georgia', serif; 
            background-color: var(--bg-color); 
            color: var(--text-color); 
            margin: 0; 
            padding: 0; 
            transition: background-color 0.4s, color 0.4s;
        }
        
        /* HEADER & NAVIGATION */
        .main-header {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px 20px;
            display: flex; /* Tambahkan Flexbox */
            justify-content: space-between; /* Untuk memisahkan judul dan tombol mode */
            align-items: center; /* Untuk mensejajarkan secara vertikal */
        }
        .main-header h1 {
            font-size: 3em;
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 15px;
            margin-bottom: 10px;
            font-weight: 300;
        }
        .quote {
            font-style: italic;
            color: var(--secondary-color);
            margin-bottom: 30px;
        }

        /* LAYOUT (2 COLUMNS) */
        .content-area {
            display: flex;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }
        .sidebar {
            width: 250px;
            padding-right: 30px;
        }
        .main-content {
            flex-grow: 1;
            background: var(--container-bg);
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px var(--shadow-color);
        }
        
        /* SIDEBAR NAV STYLING */
        .sidebar h2 {
            border-bottom: 1px solid var(--input-border);
            padding-bottom: 10px;
            color: var(--text-color);
            margin-bottom: 15px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar li {
            margin-bottom: 10px;
        }
        .sidebar li a {
            display: block;
            padding: 8px 0;
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.3s;
        }
        .sidebar li a:hover {
            color: var(--primary-color);
        }
        
        /* CARD STYLING */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .feature-card {
            background-color: var(--nav-bg);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 10px var(--shadow-color);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(163, 140, 130, 0.4);
        }
        .card-icon {
            font-size: 2.5em;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        .card-title {
            font-size: 1.1em;
            font-weight: bold;
            color: var(--text-color);
        }
        .btn-logout { 
            padding: 10px 18px; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            text-decoration: none; 
            font-weight: bold; 
            background-color: var(--secondary-color); 
            color: white; 
            margin-top: 30px;
        }
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
    
    <div class="main-header">
        <div>
            <h1>HydraTracker: Personal Health Log 💦</h1>
            <p class="quote">"Health is a state of complete harmony of the body, mind and spirit."</p>
        </div>
        
        {{-- TOMBOL DARK MODE DI DASHBOARD --}}
        <button id="mode-toggle" class="btn-toggle">Mode Gelap: OFF</button>
    </div>

    <div class="content-area">
        <div class="sidebar">
            <h2>Navigasi Cepat</h2>
            <ul>
                <li><a href="{{ route('dashboard') }}">🏠 Dashboard Utama</a></li>
                <li><a href="{{ route('water-logs.index') }}">💧 Catatan Air Harian</a></li>
                <li><a href="#">📊 Analisis (Soon)</a></li>
                <li><a href="{{ route('profile.edit') }}">⚙️ Pengaturan Profil</a></li>
            </ul>

            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>

        <div class="main-content">
            <h2>Fitur Utama</h2>

            @if (session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif

            <div class="card-grid">
                
                {{-- CARD 1: KELOLA DATA --}}
                <a href="{{ route('water-logs.index') }}" class="feature-card">
                    <div class="card-icon">💧</div>
                    <div class="card-title">Kelola Catatan Air (CRUD)</div>
                </a>
                
                {{-- CARD 2: TAMBAH CEPAT --}}
                <a href="{{ route('water-logs.create') }}" class="feature-card">
                    <div class="card-icon">➕</div>
                    <div class="card-title">Catat Asupan Hari Ini</div>
                </a>

                {{-- CARD 3: Placeholder (untuk kesan ramai) --}}
                <div class="feature-card" style="opacity: 0.6;">
                    <div class="card-icon">📅</div>
                    <div class="card-title">Laporan Mingguan (Soon)</div>
                </div>

            </div>
        </div>
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
