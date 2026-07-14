<!DOCTYPE html>
<html lang="id">


<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Koperasi Pegawai UNAIR — Belanja Mudah, Hemat, dan Menguntungkan</title>
   <link rel="dns-prefetch" href="//fonts.bunny.net">
   <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:300,400,500,600,700,800&display=swap"
       rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
       :root {
           --primary: #2f3291;
           --primary-dark: #1e2061;
           --primary-light: rgba(47, 50, 145, 0.08);
           --accent: #ffca0a;
           --accent-dark: #e6b709;
           --white: #ffffff;
           --bg-body: #f4f7fe;
           --text-main: #2d3748;
           --text-secondary: #718096;
           --border-color: #e2e8f0;
           --success: #10b981;
           --danger: #ef4444;
           --shadow-soft: 0 4px 20px rgba(112, 144, 176, 0.08);
           --shadow-card: 0 2px 10px rgba(112, 144, 176, 0.06);
           --shadow-lg: 0 10px 40px rgba(47, 50, 145, 0.12);
           --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
       }


       *,
       *::before,
       *::after {
           box-sizing: border-box;
           margin: 0;
           padding: 0;
       }


       html {
           scroll-behavior: smooth;
       }


       body {
           font-family: 'Plus Jakarta Sans', sans-serif;
           background: var(--bg-body);
           color: var(--text-main);
           line-height: 1.6;
           overflow-x: hidden;
       }


       /* ==================== HEADER / NAVBAR ==================== */
       .navbar {
           background: var(--white);
           box-shadow: var(--shadow-soft);
           position: sticky;
           top: 0;
           z-index: 1000;
           transition: var(--transition);
       }


       .navbar-container {
           max-width: 1200px;
           margin: 0 auto;
           padding: 18px 24px;
           display: flex;
           align-items: center;
           justify-content: space-between;
       }


       .logo-area {
           display: flex;
           align-items: center;
           gap: 12px;
       }


       .logo-box {
           width: 44px;
           height: 44px;
           background: var(--primary-light);
           border: 2px solid rgba(47, 50, 145, 0.15);
           border-radius: 12px;
           display: flex;
           align-items: center;
           justify-content: center;
           padding: 6px;
       }


       .logo-img {
           width: 100%;
           height: 100%;
           object-fit: contain;
       }


       .logo-text {
           font-weight: 800;
           font-size: 18px;
           color: var(--primary);
           line-height: 1.2;
       }


       .logo-text span {
           color: var(--accent);
       }


       .nav-menu {
           display: flex;
           align-items: center;
           gap: 32px;
           list-style: none;
       }


       .nav-link {
           color: var(--text-main);
           text-decoration: none;
           font-weight: 600;
           font-size: 14px;
           transition: var(--transition);
           position: relative;
       }


       .nav-link::after {
           content: '';
           position: absolute;
           bottom: -4px;
           left: 0;
           width: 0;
           height: 2px;
           background: var(--accent);
           transition: var(--transition);
       }


       .nav-link:hover {
           color: var(--primary);
       }


       .nav-link:hover::after {
           width: 100%;
       }


       .nav-buttons {
           display: flex;
           align-items: center;
           gap: 12px;
       }


       .btn {
           border: none;
           padding: 10px 20px;
           border-radius: 10px;
           font-weight: 700;
           font-size: 14px;
           cursor: pointer;
           transition: var(--transition);
           display: inline-flex;
           align-items: center;
           gap: 8px;
           text-decoration: none;
           font-family: 'Plus Jakarta Sans', sans-serif;
       }


       .btn-outline {
           background: transparent;
           color: var(--primary);
           border: 2px solid var(--primary);
       }


       .btn-outline:hover {
           background: var(--primary);
           color: var(--white);
           transform: translateY(-2px);
       }


       .btn-primary {
           background: linear-gradient(135deg, var(--primary), var(--primary-dark));
           color: var(--white);
           box-shadow: 0 4px 16px rgba(47, 50, 145, 0.25);
       }


       .btn-primary:hover {
           box-shadow: 0 6px 24px rgba(47, 50, 145, 0.35);
           transform: translateY(-2px);
       }


       .btn-accent {
           background: var(--accent);
           color: var(--primary);
           box-shadow: 0 4px 16px rgba(255, 202, 10, 0.25);
       }


       .btn-accent:hover {
           background: var(--accent-dark);
           transform: translateY(-2px);
       }


       .mobile-toggle {
           display: none;
           background: none;
           border: none;
           font-size: 24px;
           color: var(--primary);
           cursor: pointer;
       }


       /* ==================== HERO SECTION ==================== */
       .hero {
           background: linear-gradient(155deg, var(--primary-dark) 0%, var(--primary) 60%, #3d3fa8 100%);
           padding: 80px 24px;
           position: relative;
           overflow: hidden;
       }


       .hero::before {
           content: '';
           position: absolute;
           inset: 0;
           background-image:
               linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
               linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
           background-size: 48px 48px;
           pointer-events: none;
       }


       .hero-geo {
           position: absolute;
           border-radius: 50%;
           pointer-events: none;
       }


       .hero-geo-1 {
           width: 500px;
           height: 500px;
           border: 1px solid rgba(255, 255, 255, 0.06);
           top: -200px;
           right: -200px;
       }


       .hero-geo-2 {
           width: 300px;
           height: 300px;
           background: rgba(255, 202, 10, 0.08);
           bottom: -100px;
           left: -100px;
       }


       .hero-container {
           max-width: 1200px;
           margin: 0 auto;
           display: grid;
           grid-template-columns: 1fr 1fr;
           gap: 60px;
           align-items: center;
           position: relative;
           z-index: 1;
       }


       .hero-content h1 {
           font-size: 48px;
           font-weight: 800;
           color: var(--white);
           line-height: 1.2;
           margin-bottom: 24px;
       }


       .hero-content h1 span {
           color: var(--accent);
       }


       .hero-content p {
           font-size: 18px;
           color: rgba(255, 255, 255, 0.75);
           line-height: 1.8;
           margin-bottom: 32px;
       }


       .hero-stats {
           display: grid;
           grid-template-columns: repeat(3, 1fr);
           gap: 20px;
           margin-top: 48px;
       }


       .stat-card {
           background: rgba(255, 255, 255, 0.08);
           border: 1px solid rgba(255, 255, 255, 0.12);
           border-radius: 16px;
           padding: 24px;
           text-align: center;
       }


       .stat-card .stat-icon {
           font-size: 32px;
           margin-bottom: 12px;
       }


       .stat-card .stat-value {
           font-size: 28px;
           font-weight: 800;
           color: var(--white);
           display: block;
           margin-bottom: 4px;
       }


       .stat-card .stat-label {
           font-size: 13px;
           color: rgba(255, 255, 255, 0.6);
           font-weight: 500;
       }


       .hero-image {
           position: relative;
       }


       .hero-illustration {
           width: 100%;
           height: auto;
           animation: float 6s ease-in-out infinite;
       }


       @keyframes float {


           0%,
           100% {
               transform: translateY(0);
           }


           50% {
               transform: translateY(-20px);
           }
       }


       /* ==================== FEATURES ==================== */
       .features {
           padding: 80px 24px;
           background: var(--white);
       }


       .section-header {
           text-align: center;
           max-width: 700px;
           margin: 0 auto 60px;
       }


       .section-badge {
           display: inline-flex;
           align-items: center;
           gap: 8px;
           background: var(--primary-light);
           border: 1px solid rgba(47, 50, 145, 0.15);
           border-radius: 100px;
           padding: 8px 18px;
           margin-bottom: 20px;
           font-size: 12px;
           font-weight: 800;
           color: var(--primary);
           letter-spacing: 1px;
       }


       .section-title {
           font-size: 38px;
           font-weight: 800;
           color: var(--primary);
           line-height: 1.2;
           margin-bottom: 16px;
       }


       .section-subtitle {
           font-size: 16px;
           color: var(--text-secondary);
           line-height: 1.8;
       }


       .features-grid {
           max-width: 1200px;
           margin: 0 auto;
           display: grid;
           grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
           gap: 32px;
       }


       .feature-card {
           background: var(--bg-body);
           border: 2px solid var(--border-color);
           border-radius: 20px;
           padding: 32px;
           text-align: center;
           transition: var(--transition);
       }


       .feature-card:hover {
           transform: translateY(-8px);
           border-color: var(--primary);
           box-shadow: var(--shadow-lg);
       }


       .feature-icon {
           width: 70px;
           height: 70px;
           background: linear-gradient(135deg, var(--primary), var(--accent));
           border-radius: 18px;
           display: flex;
           align-items: center;
           justify-content: center;
           margin: 0 auto 24px;
           font-size: 32px;
           color: var(--white);
       }


       .feature-card h3 {
           font-size: 20px;
           font-weight: 700;
           color: var(--primary);
           margin-bottom: 12px;
       }


       .feature-card p {
           font-size: 14px;
           color: var(--text-secondary);
           line-height: 1.7;
       }


       /* ==================== CATEGORIES ==================== */
       .categories {
           padding: 80px 24px;
           background: var(--bg-body);
       }


       .categories-container {
           max-width: 1200px;
           margin: 0 auto;
       }


       .categories-grid {
           display: grid;
           grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
           gap: 24px;
       }


       .category-card {
           background: var(--white);
           border-radius: 16px;
           padding: 28px 20px;
           text-align: center;
           transition: var(--transition);
           cursor: pointer;
           box-shadow: var(--shadow-card);
       }


       .category-card:hover {
           transform: translateY(-6px);
           box-shadow: var(--shadow-lg);
       }


       .category-icon {
           font-size: 48px;
           margin-bottom: 16px;
       }


       .category-card h4 {
           font-size: 16px;
           font-weight: 700;
           color: var(--primary);
           margin-bottom: 8px;
       }


       .category-card p {
           font-size: 13px;
           color: var(--text-secondary);
       }


       /* ==================== PRODUCTS ==================== */
       .products {
           padding: 80px 24px;
           background: var(--white);
       }


       .products-container {
           max-width: 1200px;
           margin: 0 auto;
       }


       .products-grid {
           display: grid;
           grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
           gap: 28px;
       }


       .product-card {
           background: var(--white);
           border: 2px solid var(--border-color);
           border-radius: 18px;
           overflow: hidden;
           transition: var(--transition);
           display: flex;
           flex-direction: column;
       }


       .product-card:hover {
           transform: translateY(-8px);
           box-shadow: var(--shadow-lg);
           border-color: var(--primary);
       }


       .product-image {
           width: 100%;
           height: 220px;
           object-fit: cover;
           background: var(--bg-body);
       }


       .product-badge {
           position: absolute;
           top: 12px;
           right: 12px;
           background: var(--accent);
           color: var(--primary);
           padding: 6px 14px;
           border-radius: 100px;
           font-size: 11px;
           font-weight: 800;
           letter-spacing: 0.5px;
       }


       .product-info {
           padding: 20px;
           flex: 1;
           display: flex;
           flex-direction: column;
       }


       .product-category {
           display: inline-block;
           background: var(--primary-light);
           color: var(--primary);
           padding: 4px 12px;
           border-radius: 6px;
           font-size: 11px;
           font-weight: 700;
           margin-bottom: 12px;
           width: fit-content;
       }


       .product-name {
           font-size: 17px;
           font-weight: 700;
           color: var(--text-main);
           margin-bottom: 8px;
           line-height: 1.3;
       }


       .product-price {
           font-size: 22px;
           font-weight: 800;
           color: var(--primary);
           margin-bottom: 12px;
       }


       .product-meta {
           display: flex;
           align-items: center;
           justify-content: space-between;
           padding-top: 12px;
           border-top: 1px solid var(--border-color);
           margin-top: auto;
       }


       .product-stock {
           font-size: 13px;
           color: var(--text-secondary);
       }


       .product-stock i {
           color: var(--success);
           margin-right: 4px;
       }


       .product-stock.low i {
           color: var(--danger);
       }


       /* ==================== REWARDS ==================== */
       .rewards {
           padding: 80px 24px;
           background: var(--bg-body);
       }


       .rewards-container {
           max-width: 1200px;
           margin: 0 auto;
       }


       .rewards-grid {
           display: grid;
           grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
           gap: 28px;
       }


       .reward-card {
           background: var(--white);
           border: 2px solid var(--border-color);
           border-radius: 18px;
           overflow: hidden;
           transition: var(--transition);
       }


       .reward-card:hover {
           transform: translateY(-8px);
           box-shadow: var(--shadow-lg);
           border-color: var(--accent);
       }


       .reward-image-wrapper {
           position: relative;
           width: 100%;
           height: 240px;
           background: linear-gradient(135deg, var(--primary-light), rgba(255, 202, 10, 0.1));
           display: flex;
           align-items: center;
           justify-content: center;
       }


       .reward-image {
           width: 100%;
           height: 100%;
           object-fit: cover;
       }


       .reward-points {
           position: absolute;
           bottom: 12px;
           left: 12px;
           background: var(--accent);
           color: var(--primary);
           padding: 8px 16px;
           border-radius: 100px;
           font-size: 14px;
           font-weight: 800;
           display: flex;
           align-items: center;
           gap: 6px;
           box-shadow: 0 4px 12px rgba(255, 202, 10, 0.4);
       }


       .reward-info {
           padding: 20px;
       }


       .reward-name {
           font-size: 18px;
           font-weight: 700;
           color: var(--text-main);
           margin-bottom: 8px;
       }


       .reward-description {
           font-size: 13px;
           color: var(--text-secondary);
           line-height: 1.6;
           margin-bottom: 16px;
       }


       .reward-stock {
           display: flex;
           align-items: center;
           justify-content: space-between;
           padding-top: 12px;
           border-top: 1px solid var(--border-color);
       }


       .reward-stock-info {
           font-size: 13px;
           color: var(--text-secondary);
       }


       .reward-stock-info i {
           color: var(--success);
           margin-right: 4px;
       }


       .reward-status {
           padding: 6px 12px;
           border-radius: 100px;
           font-size: 11px;
           font-weight: 700;
       }


       .reward-status.available {
           background: rgba(16, 185, 129, 0.1);
           color: var(--success);
       }


       .reward-status.unavailable {
           background: rgba(239, 68, 68, 0.1);
           color: var(--danger);
       }


       /* ==================== CTA SECTION ==================== */
       .cta {
           padding: 80px 24px;
           background: linear-gradient(135deg, var(--primary), var(--primary-dark));
           position: relative;
           overflow: hidden;
       }


       .cta::before {
           content: '';
           position: absolute;
           inset: 0;
           background-image:
               linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
               linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
           background-size: 48px 48px;
       }


       .cta-container {
           max-width: 900px;
           margin: 0 auto;
           text-align: center;
           position: relative;
           z-index: 1;
       }


       .cta-container h2 {
           font-size: 42px;
           font-weight: 800;
           color: var(--white);
           line-height: 1.2;
           margin-bottom: 20px;
       }


       .cta-container h2 span {
           color: var(--accent);
       }


       .cta-container p {
           font-size: 18px;
           color: rgba(255, 255, 255, 0.8);
           line-height: 1.8;
           margin-bottom: 36px;
       }


       .cta-buttons {
           display: flex;
           gap: 16px;
           justify-content: center;
           flex-wrap: wrap;
       }


       /* ==================== FOOTER ==================== */
       .footer {
           background: var(--text-main);
           color: rgba(255, 255, 255, 0.7);
           padding: 60px 24px 24px;
       }


       .footer-container {
           max-width: 1200px;
           margin: 0 auto;
       }


       .footer-grid {
           display: grid;
           grid-template-columns: 2fr 1fr 1fr 1fr;
           gap: 48px;
           margin-bottom: 48px;
       }


       .footer-about h3 {
           color: var(--white);
           font-size: 20px;
           font-weight: 800;
           margin-bottom: 16px;
       }


       .footer-about p {
           line-height: 1.8;
           margin-bottom: 20px;
       }


       .footer-social {
           display: flex;
           gap: 12px;
       }


       .social-icon {
           width: 40px;
           height: 40px;
           background: rgba(255, 255, 255, 0.1);
           border-radius: 10px;
           display: flex;
           align-items: center;
           justify-content: center;
           color: var(--white);
           transition: var(--transition);
           text-decoration: none;
       }


       .social-icon:hover {
           background: var(--accent);
           color: var(--primary);
           transform: translateY(-4px);
       }


       .footer-links h4 {
           color: var(--white);
           font-size: 16px;
           font-weight: 700;
           margin-bottom: 20px;
       }


       .footer-links ul {
           list-style: none;
       }


       .footer-links ul li {
           margin-bottom: 12px;
       }


       .footer-links a {
           color: rgba(255, 255, 255, 0.7);
           text-decoration: none;
           transition: var(--transition);
           font-size: 14px;
       }


       .footer-links a:hover {
           color: var(--accent);
           padding-left: 4px;
       }


       .footer-bottom {
           padding-top: 24px;
           border-top: 1px solid rgba(255, 255, 255, 0.1);
           text-align: center;
           font-size: 14px;
       }


       /* ==================== RESPONSIVE ==================== */
       @media (max-width: 992px) {
           .nav-menu {
               display: none;
           }


           .mobile-toggle {
               display: block;
           }


           .hero-container {
               grid-template-columns: 1fr;
               gap: 40px;
           }


           .hero-content h1 {
               font-size: 36px;
           }


           .hero-stats {
               grid-template-columns: repeat(3, 1fr);
           }


           .footer-grid {
               grid-template-columns: 1fr 1fr;
               gap: 32px;
           }
       }


       @media (max-width: 768px) {
           .navbar-container {
               padding: 16px 20px;
           }


           .nav-buttons .btn-outline {
               display: none;
           }


           .hero {
               padding: 60px 20px;
           }


           .hero-content h1 {
               font-size: 32px;
           }


           .hero-content p {
               font-size: 16px;
           }


           .hero-stats {
               grid-template-columns: 1fr;
               gap: 16px;
           }


           .section-title {
               font-size: 28px;
           }


           .features,
           .categories,
           .products,
           .rewards,
           .cta {
               padding: 60px 20px;
           }


           .features-grid {
               grid-template-columns: 1fr;
           }


           .categories-grid {
               grid-template-columns: repeat(2, 1fr);
           }


           .products-grid,
           .rewards-grid {
               grid-template-columns: 1fr;
           }


           .cta-container h2 {
               font-size: 32px;
           }


           .cta-buttons {
               flex-direction: column;
           }


           .footer-grid {
               grid-template-columns: 1fr;
           }
       }
   </style>
</head>


<body>
   <!-- Navbar -->
   <nav class="navbar">
       <div class="navbar-container">
           <div class="logo-area">
               <div class="logo-box">
                   <img src="{{ asset('images/unair-logo.png') }}" alt="UNAIR" class="logo-img">
               </div>
               <div class="logo-text">
                   KOPERASI<span><br>UNAIR</span>
               </div>
           </div>


           <ul class="nav-menu">
               <li><a href="#home" class="nav-link">Beranda</a></li>
               <li><a href="#kategori" class="nav-link">Kategori</a></li>
               <li><a href="#produk" class="nav-link">Produk</a></li>
               <li><a href="#hadiah" class="nav-link">Hadiah</a></li>
               <li><a href="#tentang" class="nav-link">Tentang</a></li>
           </ul>


           <div class="nav-buttons">
               <a href="{{ route('login') }}" class="btn btn-outline">
                   <i class="fas fa-sign-in-alt"></i>
                   Login
               </a>
               <a href="{{ route('member.login') }}" class="btn btn-primary">
                   <i class="fas fa-user"></i>
                   Member
               </a>
           </div>


           <button class="mobile-toggle">
               <i class="fas fa-bars"></i>
           </button>
       </div>
   </nav>


   <!-- Hero Section -->
   <section class="hero" id="home">
       <div class="hero-geo hero-geo-1"></div>
       <div class="hero-geo hero-geo-2"></div>


       <div class="hero-container">
           <div class="hero-content">
               <h1>Belanja Lebih <span>Hemat</span>, Dapat <span>Poin</span>, Raih <span>Hadiah!</span></h1>
               <p>
                   Koperasi Pegawai UNAIR hadir sebagai solusi belanja kebutuhan sehari-hari dengan harga terjangkau.
                   Setiap pembelian mengumpulkan poin yang bisa ditukar dengan hadiah menarik!
               </p>


               <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                   <a href="#produk" class="btn btn-accent">
                       <i class="fas fa-shopping-cart"></i>
                       Lihat Produk
                   </a>
                   <a href="#hadiah" class="btn btn-outline" style="background: rgba(255,255,255,0.1); color: white; border-color: rgba(255,255,255,0.3);">
                       <i class="fas fa-gift"></i>
                       Lihat Hadiah
                   </a>
               </div>


               <div class="hero-stats">
                   <div class="stat-card">
                       <div class="stat-icon">🛒</div>
                       <span class="stat-value">{{ $totalProduk }}+</span>
                       <span class="stat-label">Produk Tersedia</span>
                   </div>
                   <div class="stat-card">
                       <div class="stat-icon">🎁</div>
                       <span class="stat-value">{{ $totalHadiah }}+</span>
                       <span class="stat-label">Hadiah Menarik</span>
                   </div>
                   <div class="stat-card">
                       <div class="stat-icon">👥</div>
                       <span class="stat-value">{{ $totalMember }}+</span>
                       <span class="stat-label">Member Aktif</span>
                   </div>
               </div>
           </div>


           <div class="hero-image">
               <svg class="hero-illustration" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg">
                   <!-- Shopping Cart Illustration -->
                   <circle cx="250" cy="250" r="200" fill="rgba(255, 202, 10, 0.1)" />
                   <circle cx="250" cy="250" r="160" fill="rgba(255, 255, 255, 0.2)" />


                   <!-- Cart -->
                   <rect x="180" y="200" width="140" height="120" rx="10" fill="white" stroke="#2f3291"
                       stroke-width="4" />
                   <circle cx="210" cy="340" r="15" fill="#ffca0a" stroke="#2f3291" stroke-width="3" />
                   <circle cx="290" cy="340" r="15" fill="#ffca0a" stroke="#2f3291" stroke-width="3" />


                   <!-- Cart items -->
                   <rect x="200" y="220" width="100" height="60" rx="5" fill="#2f3291" opacity="0.2" />
                   <rect x="200" y="240" width="80" height="40" rx="5" fill="#ffca0a" />


                   <!-- Stars -->
                   <circle cx="140" cy="150" r="3" fill="#ffca0a" />
                   <circle cx="360" cy="180" r="4" fill="#ffca0a" />
                   <circle cx="380" cy="280" r="3" fill="#ffca0a" />
                   <circle cx="150" cy="320" r="3" fill="white" />
               </svg>
           </div>
       </div>
   </section>


   <!-- Features -->
   <section class="features" id="tentang">
       <div class="section-header">
           <span class="section-badge">
               <i class="fas fa-star"></i>
               KEUNGGULAN KAMI
           </span>
           <h2 class="section-title">Mengapa Belanja di Koperasi UNAIR?</h2>
           <p class="section-subtitle">
               Nikmati berbagai kemudahan dan keuntungan yang kami tawarkan untuk anggota koperasi
           </p>
       </div>


       <div class="features-grid">
           <div class="feature-card">
               <div class="feature-icon">
                   <i class="fas fa-tag"></i>
               </div>
               <h3>Harga Terjangkau</h3>
               <p>Dapatkan produk berkualitas dengan harga yang lebih murah dibanding pasaran umum</p>
           </div>


           <div class="feature-card">
               <div class="feature-icon">
                   <i class="fas fa-coins"></i>
               </div>
               <h3>Sistem Poin</h3>
               <p>Setiap pembelian mengumpulkan poin yang bisa ditukarkan dengan berbagai hadiah menarik</p>
           </div>


           <div class="feature-card">
               <div class="feature-icon">
                   <i class="fas fa-shield-alt"></i>
               </div>
               <h3>Terpercaya</h3>
               <p>Koperasi resmi Universitas Airlangga yang telah melayani pegawai selama puluhan tahun</p>
           </div>


           <div class="feature-card">
               <div class="feature-icon">
                   <i class="fas fa-clock"></i>
               </div>
               <h3>Belanja Praktis</h3>
               <p>Lokasi strategis dan jam operasional yang fleksibel untuk kemudahan anggota</p>
           </div>
       </div>
   </section>


   <!-- Categories -->
   <section class="categories" id="kategori">
       <div class="section-header">
           <span class="section-badge">
               <i class="fas fa-th-large"></i>
               KATEGORI PRODUK
           </span>
           <h2 class="section-title">Jelajahi Berdasarkan Kategori</h2>
           <p class="section-subtitle">
               Temukan produk yang Anda butuhkan dengan mudah melalui kategori yang tersedia
           </p>
       </div>


       <div class="categories-container">
           <div class="categories-grid">
               @forelse($kategoriProduk as $kategori)
                   <div class="category-card">
                       <div class="category-icon">
                           📦
                       </div>
                       <h4>{{ $kategori->nama }}</h4>
                       <p>{{ $kategori->produk_count ?? 0 }} Produk</p>
                   </div>
               @empty
                   <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
                       <p style="color: var(--text-secondary);">Belum ada kategori tersedia</p>
                   </div>
               @endforelse
           </div>
       </div>
   </section>


   <!-- Products -->
   <section class="products" id="produk">
       <div class="section-header">
           <span class="section-badge">
               <i class="fas fa-shopping-bag"></i>
               PRODUK PILIHAN
           </span>
           <h2 class="section-title">Produk Terlaris & Terpopuler</h2>
           <p class="section-subtitle">
               Koleksi produk berkualitas dengan harga terbaik untuk kebutuhan sehari-hari Anda
           </p>
       </div>


       <div class="products-container">
           <div class="products-grid">
               @forelse($produkTerbaru as $produk)
                   <div class="product-card">
                       <div style="position: relative;">
                           @if($produk->foto)
                               <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama }}"
                                   class="product-image">
                           @else
                               <div class="product-image"
                                   style="display: flex; align-items: center; justify-content: center; background: var(--primary-light); font-size: 48px;">
                                   📦
                               </div>
                           @endif


                           @if($produk->stok <= $produk->stok_minimum)
                               <span class="product-badge"
                                   style="background: var(--danger); color: white;">STOK TERBATAS</span>
                           @elseif($produk->created_at->diffInDays(now()) <= 7)
                               <span class="product-badge">BARU</span>
                           @endif
                       </div>


                       <div class="product-info">
                           @if($produk->kategori)
                               <span class="product-category">{{ $produk->kategori->nama }}</span>
                           @endif
                           <h3 class="product-name">{{ $produk->nama }}</h3>
                           <div class="product-price">{{ $produk->harga_formatted }}</div>


                           <div class="product-meta">
                               <span class="product-stock {{ $produk->stok <= $produk->stok_minimum ? 'low' : '' }}">
                                   <i class="fas fa-box"></i>
                                   Stok: {{ $produk->stok }} {{ $produk->satuan }}
                               </span>
                           </div>
                       </div>
                   </div>
               @empty
                   <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                       <div style="font-size: 64px; margin-bottom: 20px;">📦</div>
                       <h3 style="color: var(--text-main); margin-bottom: 8px;">Belum Ada Produk</h3>
                       <p style="color: var(--text-secondary);">Produk akan segera tersedia</p>
                   </div>
               @endforelse
           </div>


           @if($produkTerbaru->count() > 0)
               <div style="text-align: center; margin-top: 48px;">
                   <a href="{{ route('member.login') }}" class="btn btn-primary btn-lg">
                       <i class="fas fa-store"></i>
                       Lihat Semua Produk
                   </a>
               </div>
           @endif
       </div>
   </section>


   <!-- Rewards -->
   <section class="rewards" id="hadiah">
       <div class="section-header">
           <span class="section-badge">
               <i class="fas fa-gift"></i>
               HADIAH MENARIK
           </span>
           <h2 class="section-title">Tukar Poin dengan Hadiah Pilihan</h2>
           <p class="section-subtitle">
               Kumpulkan poin dari setiap pembelian dan tukarkan dengan berbagai hadiah eksklusif
           </p>
       </div>


       <div class="rewards-container">
           <div class="rewards-grid">
               @forelse($hadiahTersedia as $hadiah)
                   <div class="reward-card">
                       <div class="reward-image-wrapper">
                           @if($hadiah->foto)
                               <img src="{{ asset('storage/' . $hadiah->foto) }}" alt="{{ $hadiah->nama }}"
                                   class="reward-image">
                           @else
                               <div style="font-size: 80px;">🎁</div>
                           @endif


                           <span class="reward-points">
                               <i class="fas fa-star"></i>
                               {{ number_format($hadiah->biaya_poin, 0, ',', '.') }} Poin
                           </span>
                       </div>


                       <div class="reward-info">
                           <h3 class="reward-name">{{ $hadiah->nama }}</h3>
                           <p class="reward-description">
                               {{ Str::limit($hadiah->keterangan ?? 'Hadiah menarik untuk member setia', 80) }}
                           </p>


                           <div class="reward-stock">
                               <span class="reward-stock-info">
                                   <i class="fas fa-box"></i>
                                   Stok: {{ $hadiah->stok }} unit
                               </span>
                               @if($hadiah->isTersedia())
                                   <span class="reward-status available">Tersedia</span>
                               @else
                                   <span class="reward-status unavailable">Habis</span>
                               @endif
                           </div>
                       </div>
                   </div>
               @empty
                   <div style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                       <div style="font-size: 64px; margin-bottom: 20px;">🎁</div>
                       <h3 style="color: var(--text-main); margin-bottom: 8px;">Belum Ada Hadiah</h3>
                       <p style="color: var(--text-secondary);">Hadiah akan segera tersedia</p>
                   </div>
               @endforelse
           </div>


           @if($hadiahTersedia->count() > 0)
               <div style="text-align: center; margin-top: 48px;">
                   <a href="{{ route('member.login') }}" class="btn btn-primary btn-lg">
                       <i class="fas fa-gift"></i>
                       Lihat Semua Hadiah
                   </a>
               </div>
           @endif
       </div>
   </section>


   <!-- CTA -->
   <section class="cta">
       <div class="cta-container">
           <h2>Siap Berbelanja dan <span>Kumpulkan Poin?</span></h2>
           <p>
               Bergabunglah dengan ribuan member lainnya dan nikmati berbagai keuntungan berbelanja di Koperasi UNAIR.
               Daftar sekarang dan mulai kumpulkan poin!
           </p>
           <div class="cta-buttons">
               <a href="{{ route('member.login') }}" class="btn btn-accent btn-lg">
                   <i class="fas fa-user-plus"></i>
                   Daftar Member
               </a>
               <a href="{{ route('login') }}" class="btn btn-outline btn-lg"
                   style="background: rgba(255,255,255,0.1); color: white; border-color: rgba(255,255,255,0.3);">
                   <i class="fas fa-sign-in-alt"></i>
                   Login Admin
               </a>
           </div>
       </div>
   </section>


   <!-- Footer -->
   <footer class="footer">
       <div class="footer-container">
           <div class="footer-grid">
               <div class="footer-about">
                   <h3>Koperasi Pegawai UNAIR</h3>
                   <p>
                       Koperasi resmi untuk pegawai Universitas Airlangga yang menyediakan berbagai kebutuhan
                       sehari-hari dengan harga terjangkau dan sistem reward yang menguntungkan.
                   </p>
                   <div class="footer-social">
                       <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                       <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                       <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                       <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                   </div>
               </div>


               <div class="footer-links">
                   <h4>Menu</h4>
                   <ul>
                       <li><a href="#home">Beranda</a></li>
                       <li><a href="#kategori">Kategori</a></li>
                       <li><a href="#produk">Produk</a></li>
                       <li><a href="#hadiah">Hadiah</a></li>
                       <li><a href="#tentang">Tentang</a></li>
                   </ul>
               </div>


               <div class="footer-links">
                   <h4>Member</h4>
                   <ul>
                       <li><a href="{{ route('member.login') }}">Login Member</a></li>
                       <li><a href="{{ route('member.login') }}">Daftar Member</a></li>
                       <li><a href="#">Cara Belanja</a></li>
                       <li><a href="#">Tukar Poin</a></li>
                       <li><a href="#">Syarat & Ketentuan</a></li>
                   </ul>
               </div>


               <div class="footer-links">
                   <h4>Kontak</h4>
                   <ul>
                       <li><a href="#"><i class="fas fa-map-marker-alt"></i> Kampus C UNAIR</a></li>
                       <li><a href="tel:031-1234567"><i class="fas fa-phone"></i> (031) 1234-567</a></li>
                       <li><a href="mailto:koperasi@unair.ac.id"><i class="fas fa-envelope"></i>
                               koperasi@unair.ac.id</a></li>
                       <li><a href="#"><i class="fas fa-clock"></i> Senin-Jumat, 08:00-16:00</a></li>
                   </ul>
               </div>
           </div>


           <div class="footer-bottom">
               © {{ date('Y') }} Koperasi Pegawai Universitas Airlangga. All rights reserved.
           </div>
       </div>
   </footer>
</body>


</html>




