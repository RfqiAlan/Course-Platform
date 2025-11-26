{{-- resources/views/guest/dashboard.blade.php --}}
<x-app-layout title="Selamat Datang di EDVO">
    <div class="container py-5">

        {{-- ======================= --}}
        {{-- HERO SECTION (dari lama) --}}
        {{-- ======================= --}}
        <section class="row align-items-center g-5">

            {{-- LEFT TEXT --}}
            <div class="col-lg-6">

                <div class="mb-3">
                    <span class="badge rounded-pill px-3 py-2"
                          style="background:#EAF2FF; color:#0F3D73; font-size:.9rem;">
                        EDVO Learning Platform
                    </span>
                </div>

                <h1 class="fw-bold lh-sm mb-3" style="font-size:2.8rem;">
                    Belajar Skill Baru<br>
                    <span class="text-decoration-underline" style="text-decoration-color:#FFD955;">
                        Kapan Saja, Di Mana Saja.
                    </span>
                </h1>

                <p class="text-muted mb-4" style="font-size:1.05rem;">
                    1000+ Course mencakup berbagai bidang teknologi untuk meningkatkan kemampuanmu.
                    Belajar dari pengajar berpengalaman dan raih sertifikat resmi.
                </p>

                {{-- CTA BUTTONS --}}
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('courses.index') }}" class="btn btn-primary btn-lg px-4 py-2"
                       style="background:#0F3D73; border-color:#0F3D73;">
                        Mulai Belajar
                    </a>

                    <a href="#fitur" class="btn btn-outline-primary btn-lg px-4 py-2"
                       style="border-color:#0F3D73; color:#0F3D73;">
                        Cara Kerja
                    </a>
                </div>

                {{-- STATISTICS --}}
                <div class="d-flex flex-wrap gap-4 mt-5">
                    <div>
                        <h3 class="fw-bold mb-0" style="color:#FFC400;">1000+</h3>
                        <p class="text-muted mb-0 small">Course tersedia</p>
                    </div>

                    <div>
                        <h3 class="fw-bold mb-0" style="color:#3396FF;">5000+</h3>
                        <p class="text-muted mb-0 small">Siswa belajar</p>
                    </div>

                    <div>
                        <h3 class="fw-bold mb-0" style="color:#FF5E5E;">200+</h3>
                        <p class="text-muted mb-0 small">Pengajar Profesional</p>
                    </div>
                </div>
            </div>

            {{-- RIGHT IMAGE --}}
            <div class="col-lg-6 text-center position-relative">
                <img src="/images/hero-girl.png"
                     class="img-fluid"
                     style="max-height:420px; position:relative; z-index:2;">

                {{-- Decorative shapes --}}
                <div style="
                    position:absolute;
                    top:10%;
                    right:8%;
                    width:120px;
                    height:120px;
                    background:#FF7A39;
                    border-radius:50%;
                    z-index:1;">
                </div>

                <div style="
                    position:absolute;
                    bottom:10%;
                    left:10%;
                    width:140px;
                    height:140px;
                    background:#FFD955;
                    border-radius:50%;
                    z-index:1;">
                </div>

                <img src="/images/rocket.png"
                     style="position:absolute; top:-10px; right:20px; width:130px;">

                <img src="/images/trophy.png"
                     style="position:absolute; bottom:-20px; right:0; width:140px;">
            </div>

        </section>

        {{-- ======================= --}}
        {{-- FITUR / CARA KERJA --}}
        {{-- ======================= --}}
        <section id="fitur" class="mt-5 pt-4">
            <div class="row mb-4">
                <div class="col-lg-8">
                    <h2 class="fw-bold mb-2">Bagaimana EDVO Membantumu Belajar?</h2>
                    <p class="text-muted mb-0">
                        Mulai dari memilih course hingga mendapatkan sertifikat, semuanya dirancang sederhana dan terstruktur.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-2">1. Jelajahi Kursus</h5>
                            <p class="text-muted small mb-0">
                                Buka halaman <strong>Kursus</strong>, filter berdasarkan kategori,
                                dan pilih materi yang sesuai dengan kebutuhanmu.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-2">2. Daftar & Mulai Belajar</h5>
                            <p class="text-muted small mb-0">
                                Login atau buat akun, lalu daftar ke course pilihanmu dan akses
                                video, materi, serta latihan kapan pun kamu mau.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-2">3. Selesaikan & Dapatkan Sertifikat</h5>
                            <p class="text-muted small mb-0">
                                Selesaikan semua lesson, capai 100% progress, dan unduh sertifikat
                                sebagai bukti kompetensimu.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>
