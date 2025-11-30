{{-- resources/views/guest/dashboard.blade.php --}}
<x-app-layout title="Selamat Datang di EDVO">
    <style>
        .hero-edvo {
            background: radial-gradient(circle at top left, #EAF2FF 0, #ffffff 45%, #FDF7FF 100%);
            border-radius: 1.75rem;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-edvo::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, rgba(15, 61, 115, 0.08), rgba(255, 121, 57, 0.06));
            mix-blend-mode: soft-light;
            pointer-events: none;
        }

        .hero-badge {
            background: rgba(15, 61, 115, 0.06);
            color: #0F3D73;
            font-size: .85rem;
            border-radius: 999px;
            padding: .45rem .9rem;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
        }

        .hero-badge span.dot {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #27AE60;
        }

        .hero-title {
            font-size: clamp(2.1rem, 3vw + 1.2rem, 2.8rem);
            line-height: 1.15;
        }

        .highlight-underline {
            text-decoration: underline;
            text-decoration-color: #FFD955;
            text-decoration-thickness: 6px;
            text-underline-offset: .4rem;
        }

        .hero-subtitle {
            font-size: 1.02rem;
            max-width: 38rem;
            margin-inline: auto;
        }

        .hero-actions .btn {
            border-radius: 999px;
        }

        .hero-stat-card {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.9);
            border-radius: 1.4rem;
            padding: 1rem 1.2rem;
            box-shadow: 0 18px 40px rgba(15, 61, 115, 0.12);
            min-width: 150px;
        }

        .hero-stat-number {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .hero-stat-label {
            font-size: .8rem;
        }

        .hero-blob-left,
        .hero-blob-right {
            position: absolute;
            width: 220px;
            height: 220px;
            opacity: .55;
            filter: blur(4px);
            z-index: 0;
        }

        .hero-blob-left {
            bottom: -80px;
            left: -60px;
            background: radial-gradient(circle at 30% 30%, #FFEAA0, #FFD955);
            border-radius: 60% 40% 70% 40%;
        }

        .hero-blob-right {
            top: -70px;
            right: -60px;
            background: radial-gradient(circle at 30% 30%, #FFB27D, #FF7A39);
            border-radius: 40% 70% 40% 60%;
        }

        .section-label {
            font-size: .78rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #0F3D73;
            background: rgba(15, 61, 115, 0.06);
            border-radius: 999px;
            padding: .3rem .9rem;
            display: inline-block;
        }

        .feature-card {
            transition: transform .18s ease, box-shadow .18s ease, border-color .2s ease;
            border-radius: 1.4rem;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(15, 61, 115, 0.1);
            border-color: rgba(15, 61, 115, 0.08) !important;
        }

        .feature-icon {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .hero-edvo {
                padding: 2rem 1.4rem;
                border-radius: 1.3rem;
            }

            .hero-stat-wrap {
                justify-content: center;
            }
        }
    </style>

    <div class="container py-3">

        <section class="hero-edvo mb-5">
            <div class="hero-blob-left"></div>
            <div class="hero-blob-right"></div>

            <div class="row justify-content-center position-relative" style="z-index: 2;">
                <div class="col-lg-9 text-center">

                    <div class="mb-3">
                        <div class="hero-badge">
                            <span class="dot"></span>
                            <span class="fw-semibold">EDVO Learning Platform</span>
                            <span class="text-muted d-none d-sm-inline">Belajar skill tech secara terarah</span>
                        </div>
                    </div>

                    <h1 class="fw-bold hero-title mb-3">
                        Belajar Skill Baru,
                        <span class="d-block highlight-underline">
                            Kapan Saja, di Mana Saja.
                        </span>
                    </h1>

                    <p class="text-muted hero-subtitle mb-4">
                        Akses <strong>1000+ course</strong> teknologi, data, desain, dan karier dari pengajar
                        berpengalaman. Belajar fleksibel, progress terekam, dan dapatkan sertifikat resmi EDVO.
                    </p>
                    <div class="hero-actions d-flex flex-wrap justify-content-center gap-3 mb-3">
                        <a href="{{ route('courses.index') }}"
                           class="btn btn-primary btn-lg px-4 py-2 d-inline-flex align-items-center gap-2"
                           style="background:#0F3D73; border-color:#0F3D73;">
                            <i class="bi bi-play-circle-fill"></i>
                            <span>Mulai Belajar</span>
                        </a>

                        <a href="#fitur"
                           class="btn btn-outline-primary btn-lg px-4 py-2 d-inline-flex align-items-center gap-2"
                           style="border-color:#0F3D73; color:#0F3D73;">
                            <i class="bi bi-lightning-charge"></i>
                            <span>Cara Kerja</span>
                        </a>
                    </div>

                    <div class="d-flex flex-wrap justify-content-center gap-3 text-muted small mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Akses materi seumur hidup</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Progress belajar terekam otomatis</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span>Sertifikat resmi bisa untuk CV</span>
                        </div>
                    </div>
                    <div class="d-flex flex-wrap hero-stat-wrap justify-content-center gap-3 mt-2">
                        <div class="hero-stat-card">
                            <div class="hero-stat-number" style="color:#FFC400;">1000+</div>
                            <div class="hero-stat-label text-muted">Course tersedia</div>
                        </div>

                        <div class="hero-stat-card">
                            <div class="hero-stat-number" style="color:#3396FF;">5000+</div>
                            <div class="hero-stat-label text-muted">Siswa aktif belajar</div>
                        </div>

                        <div class="hero-stat-card">
                            <div class="hero-stat-number" style="color:#FF5E5E;">200+</div>
                            <div class="hero-stat-label text-muted">Pengajar profesional</div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <section id="fitur" class="mt-2 pt-1">
            <div class="row align-items-end mb-4">
                <div class="col-lg-8">
                    <span class="section-label mb-2">Cara Kerja EDVO</span>
                    <h2 class="fw-bold mb-2">Bagaimana EDVO Membantumu Belajar?</h2>
                    <p class="text-muted mb-0">
                        Mulai dari memilih course hingga mendapatkan sertifikat, alur belajar di EDVO dirancang
                        sederhana, terstruktur, dan mudah diikuti.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border feature-card h-100 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="feature-icon mb-3"
                                 style="background:rgba(51,150,255,0.08); color:#0F3D73;">
                                <i class="bi bi-search"></i>
                            </div>
                            <h5 class="fw-bold mb-2">1. Jelajahi Kursus</h5>
                            <p class="text-muted small mb-3">
                                Buka halaman <strong>Kursus</strong>, filter berdasarkan kategori, level, dan pengajar,
                                lalu pilih materi yang paling sesuai dengan kebutuhanmu.
                            </p>
                            <ul class="small text-muted ps-3 mb-0">
                                <li>Filter kategori </li>
                                <li>Lihat jumlah siswa</li>
                                <li>Cek kurikulum sebelum daftar</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border feature-card h-100 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="feature-icon mb-3"
                                 style="background:rgba(39,174,96,0.08); color:#1E8449;">
                                <i class="bi bi-play-circle"></i>
                            </div>
                            <h5 class="fw-bold mb-2">2. Daftar & Mulai Belajar</h5>
                            <p class="text-muted small mb-3">
                                Login atau buat akun, daftar ke course pilihan, dan langsung akses video, materi,
                                serta latihan kapan pun kamu mau.
                            </p>
                            <ul class="small text-muted ps-3 mb-0">
                                <li>Bisa lewat laptop maupun HP</li>
                                <li>Progress belajar terekam otomatis</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border feature-card h-100 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="feature-icon mb-3"
                                 style="background:rgba(255,201,71,0.16); color:#B46900;">
                                <i class="bi bi-patch-check-fill"></i>
                            </div>
                            <h5 class="fw-bold mb-2">3. Selesaikan & Dapatkan Sertifikat</h5>
                            <p class="text-muted small mb-3">
                                Setelah semua lesson selesai dan progress mencapai 100%, kamu bisa mengunduh
                                sertifikat EDVO sebagai bukti kompetensi.
                            </p>
                            <ul class="small text-muted ps-3 mb-0">
                                <li>Sertifikat bisa dilampirkan di CV</li>
                                <li>Cocok untuk portofolio LinkedIn</li>
                                <li>Track semua course yang sudah tamat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>
