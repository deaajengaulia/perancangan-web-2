<?php
// index.php
$page = 'home'; // ubah sesuai halaman ketika dipakai di file lain
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>DECANA Caffe & Resto — Beranda</title>

  <!-- Font (Google Fonts) -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    :root{
      --bg-overlay: rgba(8,8,8,0.45);
      --card-bg: rgba(255,255,255,0.95);
      --accent: #b8865f;
      --accent-2: #7a4b2b;
      --muted: #4b4b4b;
      --glass: rgba(255,255,255,0.08);
      --radius: 14px;
      --max-width: 1200px;
    }

    /* Reset */
    *{box-sizing:border-box;margin:0;padding:0}
    html,body{height:100%}
    body{
      font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color: #111;
      background: url('https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=1600&auto=format&fit=crop') center/cover no-repeat fixed;
      position: relative;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      overflow-x:hidden;
      line-height:1.45;
    }

    /* wallpaper semu: overlay + soft blur */
    body::before{
      content:"";
      position:fixed;
      inset:0;
      background: linear-gradient(180deg, rgba(0,0,0,0.25), rgba(0,0,0,0.45));
      backdrop-filter: blur(3px) saturate(110%);
      z-index:0;
    }

    /* container */
    .wrap{
      position:relative;
      z-index:10;
      max-width:var(--max-width);
      margin: 36px auto;
      padding: 28px;
      display:grid;
      grid-template-columns: 1fr;
      gap:28px;
    }

    /* header */
    header{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:16px;
      background: linear-gradient(90deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
      padding: 18px 22px;
      border-radius: 12px;
      box-shadow: 0 6px 22px rgba(9,9,9,0.35);
      border: 1px solid rgba(255,255,255,0.06);
      backdrop-filter: blur(6px);
    }
    .brand{
      display:flex;
      gap:14px;
      align-items:center;
      text-decoration:none;
      color: #fff;
    }
    .brand .logo{
      width:54px;height:54px;border-radius:10px;
      background: linear-gradient(135deg,var(--accent-2),var(--accent));
      display:flex;align-items:center;justify-content:center;
      color: #fff;font-weight:700;font-family:"Playfair Display",serif;
      box-shadow: 0 8px 20px rgba(120,60,30,0.25), inset 0 -4px 8px rgba(0,0,0,0.12);
      font-size:20px;
    }
    .brand .text{
      color:#fff;
      display:flex;flex-direction:column;
      line-height:1;
    }
    .brand .text .title{ font-family:"Playfair Display",serif; font-size:18px; font-weight:700; letter-spacing:0.2px }
    .brand .text .sub{ font-size:12px; color:rgba(255,255,255,0.9); opacity:0.9 }

    /* primary nav (text + small emoji at right of each link) */
    nav.primary{
      display:flex;
      gap:18px;
      align-items:center;
    }
    nav.primary a{
      display:flex;
      gap:8px;
      align-items:center;
      padding:8px 12px;
      border-radius:10px;
      color: rgba(255,255,255,0.94);
      text-decoration:none;
      font-weight:600;
      font-size:14px;
      transition: transform .22s ease, background .22s ease, box-shadow .22s ease;
    }
    nav.primary a .em{
      font-size:18px;
      opacity:0.95;
      transform: translateY(1px);
    }
    nav.primary a:hover{
      transform: translateY(-4px);
      background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
      box-shadow: 0 8px 30px rgba(0,0,0,0.35);
    }
    nav.primary a.active{
      background: linear-gradient(90deg, rgba(255,255,255,0.06), rgba(255,255,255,0.02));
      text-decoration:underline;
    }

    /* hero */
    .hero{
      display:grid;
      grid-template-columns: 1fr;
      gap: 20px;
      background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02));
      padding: 36px;
      border-radius: 12px;
      border:1px solid rgba(255,255,255,0.04);
      box-shadow: 0 10px 30px rgba(6,6,6,0.4);
      align-items:center;
    }
    .hero-inner{
      display:flex;
      gap:28px;
      align-items:center;
      justify-content:space-between;
      flex-wrap:wrap;
    }
    .hero-left{
      flex:1 1 520px;
      min-width:260px;
    }
    .eyebrow{
      color: rgba(255,255,255,0.85);
      font-weight:600;
      font-size:13px;
      letter-spacing:1px;
      text-transform:uppercase;
      margin-bottom:10px;
    }
    .hero h1{
      font-family:"Playfair Display",serif;
      font-size:44px;
      color:#fff;
      margin-bottom:14px;
      line-height:1.05;
      text-shadow: 0 8px 30px rgba(0,0,0,0.55);
    }
    .hero p.lead{
      color: rgba(255,255,255,0.92);
      max-width:780px;
      margin-bottom:18px;
      font-size:16px;
      opacity:0.95;
    }
    .hero .actions{
      display:flex;
      gap:12px;
      flex-wrap:wrap;
    }
    .btn{
      display:inline-flex;
      align-items:center;
      gap:10px;
      padding:12px 20px;
      border-radius:10px;
      text-decoration:none;
      font-weight:600;
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .btn.primary{
      background: linear-gradient(90deg,var(--accent),var(--accent-2));
      color:#fff;
      box-shadow: 0 10px 30px rgba(120,60,30,0.28);
    }
    .btn.ghost{
      background: transparent;
      border: 1px solid rgba(255,255,255,0.12);
      color: #fff;
    }
    .btn:hover{ transform: translateY(-4px) }

    /* featured menu cards */
    .featured{
      display:grid;
      grid-template-columns: repeat(4, 1fr);
      gap:18px;
      margin-top:6px;
    }

    .card{
      background: var(--card-bg);
      border-radius: 12px;
      overflow:hidden;
      box-shadow: 0 10px 30px rgba(12,12,12,0.2);
      transition: transform .22s ease, box-shadow .22s ease;
      display:flex;
      flex-direction:column;
      min-height: 320px;
      border: 1px solid rgba(10,10,10,0.03);
    }
    .card:hover{ transform: translateY(-8px); box-shadow: 0 20px 40px rgba(9,9,9,0.20) }
    .card .thumb{
      height:170px;
      background-size:cover;
      background-position:center;
    }
    .card .body{
      padding:14px 16px;
      display:flex;
      flex-direction:column;
      gap:10px;
      flex:1;
    }
    .card h3{ margin-top:2px; font-size:18px; color:#111; font-weight:700 }
    .card p{ font-size:13px; color:var(--muted); flex:1 }
    .card .meta{
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:10px;
      margin-top:8px;
    }
    .price{
      font-weight:700;
      color:var(--accent-2);
    }
    .order{
      background: var(--accent);
      color:#fff;
      padding:8px 12px;
      border-radius:8px;
      text-decoration:none;
      font-weight:700;
      font-size:13px;
    }
    .order:hover{ transform: translateY(-2px) }

    /* right floating emoji panel (vertical) */
    .emoji-panel{
      position:fixed;
      right:22px;
      top: 50%;
      transform: translateY(-50%);
      z-index: 30;
      display:flex;
      flex-direction:column;
      gap:12px;
      align-items:center;
      padding:12px;
      border-radius:18px;
      background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
      border:1px solid rgba(255,255,255,0.06);
      box-shadow: 0 20px 40px rgba(0,0,0,0.45);
      backdrop-filter: blur(6px);
    }
    .emoji-btn{
      width:64px;height:64px;border-radius:14px;
      display:flex;align-items:center;justify-content:center;
      font-size:28px;
      cursor:pointer;
      transition: transform .18s ease, box-shadow .18s ease;
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.00));
      border:1px solid rgba(255,255,255,0.06);
      color:#fff;
      position:relative;
    }
    .emoji-btn:hover{ transform: translateY(-8px) scale(1.03); box-shadow: 0 14px 30px rgba(0,0,0,0.35) }

    /* tooltip label on the left of button */
    .emoji-btn .label{
      position:absolute;
      right:78px;
      top:50%;
      transform:translateY(-50%) translateX(8px);
      background: rgba(0,0,0,0.75);
      color:#fff;
      padding:8px 12px;
      border-radius:8px;
      font-weight:600;
      font-size:13px;
      white-space:nowrap;
      opacity:0;
      pointer-events:none;
      transition:all .18s ease;
      box-shadow: 0 6px 18px rgba(0,0,0,0.45);
    }
    .emoji-btn:hover .label{ opacity:1; transform:translateY(-50%) translateX(0px) }

    /* badge for menu highlight count */
    .badge{
      position:absolute;
      top:8px; left:8px;
      background:var(--accent);
      color:#fff;
      font-size:11px;
      padding:6px 8px;
      border-radius:10px;
      font-weight:700;
      box-shadow: 0 6px 14px rgba(120,60,30,0.18);
    }

    footer.sitefoot{
      margin-top:18px;
      text-align:center;
      color:rgba(255,255,255,0.9);
      font-size:13px;
      padding:18px 6px;
      z-index:10;
      background:transparent;
    }

    /* responsive */
    @media (max-width:1100px){
      .featured{ grid-template-columns: repeat(2, 1fr); }
      .hero h1{ font-size:36px }
    }
    @media (max-width:680px){
      .wrap{ padding:16px; margin:20px; }
      header{ padding:12px }
      .featured{ grid-template-columns: 1fr; }
      .emoji-panel{ right:12px; transform: translateY(-45%); padding:8px }
      .emoji-btn{ width:56px;height:56px;font-size:24px;border-radius:12px }
      .emoji-btn .label{ display:none } /* hide labels on tiny screens */
      .hero h1{ font-size:26px }
      .brand .text .title{ font-size:16px }
    }
  </style>
</head>
<body>

  <!-- floating emoji shortcuts (right side) -->
  <div class="emoji-panel" aria-hidden="false">
    <a href="index.php" class="emoji-btn" aria-label="Beranda" title="Beranda">
      <span class="label">Beranda</span>🏠
    </a>

    <a href="menu2.php" class="emoji-btn" aria-label="Menu" title="Menu">
      <span class="label">Menu</span>☕
      <span class="badge" style="background:#e07b4d">4</span>
    </a>

    <a href="pemesanan.php" class="emoji-btn" aria-label="Pemesanan" title="Pemesanan">
      <span class="label">Pemesanan</span>🛒
    </a>

    <a href="tentang.php" class="emoji-btn" aria-label="Tentang Kami" title="Tentang Kami">
      <span class="label">Tentang Kami</span>ℹ️
    </a>

    <a href="kontak.php" class="emoji-btn" aria-label="Kontak" title="Kontak">
      <span class="label">Kontak</span>📞
    </a>
  </div>

  <!-- main content wrapper -->
  <div class="wrap">

    <!-- header -->
    <header role="banner" aria-label="Header DECANA">
      <a href="index2.php" class="brand" aria-label="DECANA Caffe & Resto">
        <div class="logo">DC</div>
        <div class="text">
          <div class="title">DECANA Caffe & Resto</div>
          <div class="sub">Suasana hangat • Rasa tak terlupakan</div>
        </div>
      </a>

      <nav class="primary" role="navigation" aria-label="Primary navigation">
        <a href="index2.php" class="<?php echo ($page === 'home') ? 'active' : ''; ?>"><span>Beranda</span><span class="em">🏠</span></a>
        <a href="menu2.php" class="<?php echo ($page === 'menu') ? 'active' : ''; ?>"><span>Menu</span><span class="em">☕</span></a>
        <a href="pemesanan.php" class="<?php echo ($page === 'pemesanan') ? 'active' : ''; ?>"><span>Pemesanan</span><span class="em">🛒</span></a>
        <a href="tentang.php" class="<?php echo ($page === 'tentang') ? 'active' : ''; ?>"><span>Tentang Kami</span><span class="em">ℹ️</span></a>
        <a href="kontak.php" class="<?php echo ($page === 'kontak') ? 'active' : ''; ?>"><span>Kontak</span><span class="em">📞</span></a>
      </nav>
    </header>

    <!-- hero -->
    <section class="hero" role="region" aria-label="Hero DECANA">
      <div class="hero-inner">
        <div class="hero-left">
          <div class="eyebrow">Selamat Datang</div>
          <h1>Rasakan Hangat & Keistimewaan Kopi Kami<br><span style="font-size:20px;font-weight:600;color:rgba(255,255,255,0.88)">— tempat bertemu rasa & cerita</span></h1>
          <p class="lead">
            DECANA menyajikan kopi spesial, hidangan rumahan dengan sentuhan chef, dan dessert yang memanjakan lidah. Duduk santai, nikmati ambience, dan biarkan kami melayani setiap momenmu.
          </p>

          <div class="actions" role="group" aria-label="Aksi utama">
            <a class="btn primary" href="menu.php">Lihat Menu & Favorit</a>
            <a class="btn ghost" href="pemesanan.php">Pesan Sekarang</a>
          </div>
        </div>

        <!-- right hero visual (subtle card) -->
        <div style="min-width:260px;flex:0 0 320px;max-width:380px;">
          <div style="background:linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.92)); padding:16px; border-radius:12px; box-shadow:0 14px 30px rgba(8,8,8,0.14);">
            <div style="display:flex;gap:12px;align-items:center;">
              <img src="https://images.unsplash.com/photo-1506806732259-39c2d0268443?q=80&w=520&auto=format&fit=crop" alt="Kopi spesial" style="width:88px;height:88px;border-radius:10px;object-fit:cover;box-shadow:0 6px 16px rgba(0,0,0,0.12)">
              <div>
                <div style="font-weight:700;color:#111;font-size:16px">Paket Santai DECANA</div>
                <div style="font-size:13px;color:#555;margin-top:6px">Kopi + Cake pilihan + diskon 10% untuk 2 orang</div>
                <div style="margin-top:10px"><a href="pemesanan.php" class="order" style="text-decoration:none">Pesan Paket</a></div>
              </div>
            </div>
          </div>

          <div style="margin-top:12px; padding:12px; border-radius:10px; background:rgba(255,255,255,0.06); color:#fff; font-size:13px; text-align:center;">
            <div style="font-weight:700">Jam Operasional</div>
            <div style="opacity:0.95;margin-top:6px">Senin - Minggu • 08:00 - 22:00</div>
          </div>
        </div>
      </div>

      <!-- featured menu items (gambar sudah dilengkapi untuk tiap item) -->
      <div class="featured" aria-label="Menu Unggulan">
        <!-- Card 1 -->
        <article class="card" role="article" aria-labelledby="item1">
          <div class="thumb" style="background-image:url('https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=1000&auto=format&fit=crop')";"></div>
          <div class="body">
            <h3 id="item1">Latte Signature</h3>
            <p>Perpaduan espresso single-origin dan susu pilihan, berbusa lembut, sedikit karamel di atasnya — favorite pelanggan kami.</p>
            <div class="meta">
              <div class="price">Rp 28.000</div>
              <a class="order" href="pemesanan.php">Order</a>
            </div>
          </div>
        </article>

        <!-- Card 2 -->
        <article class="card" role="article" aria-labelledby="item2">
          <div class="thumb" style="background-image:url('https://images.unsplash.com/photo-1603133872878-684f208fb84b?q=80&w=1000&auto=format&fit=crop');"></div>
          <div class="body">
            <h3 id="item2">Pasta Carbonara</h3>
            <p>Krim lembut, pancetta renyah, parmesan asli — comfort food dengan sentuhan chef kami.</p>
            <div class="meta">
              <div class="price">Rp 45.000</div>
              <a class="order" href="pemesanan.php">Order</a>
            </div>
          </div>
        </article>

        <!-- Card 3 -->
        <article class="card" role="article" aria-labelledby="item3">
          <div class="thumb" style="background-image:url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?q=80&w=1000&auto=format&fit=crop');"></div>
          <div class="body">
            <h3 id="item3">Steak Sirloin</h3>
            <p>Steak sirloin medium-rare, saus mushroom, kentang panggang — hidangan utama untuk momen istimewa.</p>
            <div class="meta">
              <div class="price">Rp 98.000</div>
              <a class="order" href="pemesanan.php">Order</a>
            </div>
          </div>
        </article>

        <!-- Card 4 -->
        <article class="card" role="article" aria-labelledby="item4">
          <div class="thumb" style="background-image:url('https://images.unsplash.com/photo-1605475128374-9624859643aa?q=80&w=1000&auto=format&fit=crop');"></div>
          <div class="body">
            <h3 id="item4">Chocolate Lava Cake</h3>
            <p>Chocolate lover? Cake hangat dengan inti cokelat meleleh yang memanjakan lidah dan hati.</p>
            <div class="meta">
              <div class="price">Rp 35.000</div>
              <a class="order" href="pemesanan.php">Order</a>
            </div>
          </div>
        </article>
      </div>
    </section>

    <footer class="sitefoot" role="contentinfo">
      📍 DECANA Caffe & Resto — Jl. Raya Slawi No.45, Tegal • Email: info@decanacaffe.id • Telp: (0283) 123-456
    </footer>

  </div>

  <!-- Optional: small JS for keyboard access & smooth focus -->
  <script>
    // Smooth scroll for anchor links (if any)
    document.querySelectorAll('a[href^="#"]').forEach(a=>{
      a.addEventListener('click', e=>{
        e.preventDefault();
        const id = a.getAttribute('href').slice(1);
        const el = document.getElementById(id);
        if(el) el.scrollIntoView({behavior:'smooth', block:'center'});
      })
    });

    // Make emoji buttons accessible via keyboard (enter/space)
    document.querySelectorAll('.emoji-btn').forEach(btn=>{
      btn.setAttribute('tabindex','0');
      btn.addEventListener('keydown', (e)=>{
        if(e.key === 'Enter' || e.key === ' '){ btn.click(); e.preventDefault(); }
      });
    });
  </script>
</body>
</html>
