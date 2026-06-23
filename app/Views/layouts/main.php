<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Laundry Pro Manager' ?></title>
    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            --secondary-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --accent-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --danger-gradient: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --bg-sidebar: #0f172a;
            --bg-main: #f8fafc;
            --text-muted: #64748b;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            --transition-speed: 0.3s;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-main);
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            background-color: var(--bg-sidebar);
            min-height: 100vh;
            transition: all var(--transition-speed);
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
            position: fixed;
            z-index: 1000;
        }

        #sidebar .sidebar-header {
            padding: 1.5rem;
            background: linear-gradient(rgba(255,255,255,0.05), transparent);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        #sidebar .nav-link {
            color: #94a3b8;
            padding: 0.8rem 1.5rem;
            margin: 0.2rem 1rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: all 0.2s;
        }

        #sidebar .nav-link i {
            margin-right: 15px;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        #sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.05);
            transform: translateX(4px);
        }

        #sidebar .nav-link.active {
            color: #fff;
            background: var(--primary-gradient);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        /* Main Content Styling */
        #content {
            width: calc(100% - 260px);
            margin-left: 260px;
            min-height: 100vh;
            transition: all var(--transition-speed);
        }

        .navbar-top {
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 1rem 2rem;
        }

        .page-container {
            padding: 2rem;
        }

        /* Card Custom Styling */
        .card-premium {
            background-color: #fff;
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
        }

        .card-premium:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .card-header-premium {
            background: none;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.2rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Badges Custom */
        .badge-sop {
            padding: 0.5em 0.8em;
            border-radius: 8px;
            font-weight: 600;
            text-transform: capitalize;
            font-size: 0.8rem;
        }

        .badge-masuk { background-color: #e0f2fe; color: #0369a1; }
        .badge-timbang { background-color: #fef3c7; color: #d97706; }
        .badge-cuci { background-color: #e0e7ff; color: #4338ca; }
        .badge-setrika { background-color: #fae8ff; color: #a21caf; }
        .badge-kemas { background-color: #f3e8ff; color: #6b21a8; }
        .badge-siap_ambil { background-color: #d1fae5; color: #065f46; }
        .badge-selesai { background-color: #dcfce7; color: #15803d; }

        .badge-belum { background-color: #fee2e2; color: #b91c1c; }
        .badge-dp { background-color: #fef3c7; color: #b45309; }
        .badge-lunas { background-color: #dcfce7; color: #166534; }

        /* Buttons Custom */
        .btn-premium {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.2);
            transition: all 0.2s;
        }

        .btn-premium:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            color: white;
        }

        .btn-secondary-premium {
            background-color: #fff;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-secondary-premium:hover {
            background-color: #f8fafc;
            color: #1e293b;
        }

        /* Responsive sidebar toggle */
        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: -260px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                margin-left: 0;
            }
            #content.active {
                margin-left: 260px;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header d-flex align-items-center justify-content-between">
            <span class="text-white fw-bold fs-4"><i class="fa-solid fa-soap text-info me-2"></i>LaundryPro</span>
            <button class="btn btn-link text-white d-lg-none" id="sidebarCloseBtn">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="mt-4">
            <?php 
                $uri = service('uri');
                $segment = $uri->getSegment(1);
            ?>
            <a href="/" class="nav-link <?= empty($segment) || $segment == 'dashboard' ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-line"></i> Dashboard
            </a>
            <a href="/pesanan" class="nav-link <?= $segment == 'pesanan' ? 'active' : '' ?>">
                <i class="fa-solid fa-boxes-stacked"></i> Pesanan Laundry
            </a>
            <a href="/layanan" class="nav-link <?= $segment == 'layanan' ? 'active' : '' ?>">
                <i class="fa-solid fa-tags"></i> Jenis Layanan
            </a>
            <a href="/pelanggan" class="nav-link <?= $segment == 'pelanggan' ? 'active' : '' ?>">
                <i class="fa-solid fa-users"></i> Data Pelanggan
            </a>
            <a href="/laporan" class="nav-link <?= $segment == 'laporan' ? 'active' : '' ?>">
                <i class="fa-solid fa-file-invoice-dollar"></i> Laporan Keuangan
            </a>
        </div>
        <div class="position-absolute bottom-0 w-100 p-3 text-center border-top border-secondary">
            <small class="text-secondary">LaundryPro v1.0.0 &copy; 2026</small>
        </div>
    </nav>

    <!-- Content Area -->
    <div id="content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-top navbar-expand-lg navbar-light">
            <div class="container-fluid p-0">
                <button type="button" id="sidebarCollapseBtn" class="btn btn-light">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <a class="nav-link d-flex align-items-center" href="#" role="button">
                            <img src="https://ui-avatars.com/api/?name=Admin+Laundry&background=4f46e5&color=fff" class="rounded-circle me-2" width="35" height="35">
                            <span class="d-none d-md-inline fw-semibold">Admin Laundry</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main View Content -->
        <div class="page-container">
            <!-- Alert Notifications -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="fa-solid fa-circle-xmark me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Render child template content -->
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Bootstrap & Custom Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const toggleBtn = document.getElementById('sidebarCollapseBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('active');
                    content.classList.toggle('active');
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    sidebar.classList.remove('active');
                    content.classList.remove('active');
                });
            }
        });
    </script>
    <!-- Add extra scripts section -->
    <?= $this->renderSection('scripts') ?>
</body>
</html>
