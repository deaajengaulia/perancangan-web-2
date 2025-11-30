<?php
// kontak.php
$page = 'kontak';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Kontak - DECANA Caffe & Resto</title>

  <style>
    :root{
      --brown:#5c3d2e;
      --accent:#7b3f00;
      --bg:#fff9f3;
      --card:#ffffff;
      --muted:#f5e0cf;
      --radius:12px;
      --shadow: 0 8px 24px rgba(0,0,0,0.06);
      --maxw:1200px;
      font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color-scheme: light;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      background:var(--bg);
      color:#222;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    /* Header */
    header{
      background: linear-gradient(90deg,var(--brown), #4c2f22);
      color:#fff;
      padding:14px 20px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      position:sticky;
      top:0;
      z-index:100;
    }
    .brand{ font-weight:800; letter-spacing:1px; font-size:18px; }
    nav a{ color:#fff; text-decoration:none; margin-left:14px; font-weight:600; }
    nav a[aria-current="page"]{ text-decoration:underline; }

    /* Page container */
    main.container{
      max-width:var(--maxw);
      margin:28px auto;
      padding:0 18px 60px;
    }

    /* Hero */
    .hero{
      display:flex;
      gap:20px;
      align-items:center;
      padding:22px;
      border-radius:var(--radius);
      background: linear-gradient(180deg, rgba(123,63,0,0.04), rgba(255,255,255,0));
      box-shadow:var(--shadow);
      margin-bottom:20px;
      flex-wrap:wrap;
    }
    .hero .left{ flex:1 1 420px; min-width:260px; }
    .hero h1{ margin:0 0 8px; color:var(--accent); font-size:26px; }
    .hero p{ margin:0; color:#444; line-height:1.6; }

    /* layout grid */
    .grid{
      display:grid;
      grid-template-columns: 1fr 420px;
      gap:20px;
      margin-top:18px;
    }
    @media (max-width:980px){
      .grid{ grid-template-columns: 1fr; }
    }

    /* card */
    .card{
      background:var(--card);
      border-radius:12px;
      padding:18px;
      box-shadow:var(--shadow);
    }

    /* contact info */
    .contact-info{ display:flex; flex-direction:column; gap:12px; }
    .info-row{ display:flex; gap:12px; align-items:flex-start; }
    .icon{
      width:46px; height:46px; border-radius:10px; background:var(--muted);
      display:flex; align-items:center; justify-content:center; flex-shrink:0;
    }
    .info-text h4{ margin:0; color:var(--accent); font-size:15px; }
    .info-text p{ margin:6px 0 0; color:#555; font-size:14px; }

    /* form */
    form label{ display:block; margin:10px 0 6px; font-weight:600; color:#333; }
    input[type="text"], input[type="email"], textarea, select{
      width:100%; padding:10px 12px; border-radius:8px; border:1px solid #e8d9c9; background:#fff;
      font-size:15px;
    }
    textarea{ min-height:120px; resize:vertical; }
    .btn{
      display:inline-block;
      background:var(--accent); color:#fff; border:none; padding:10px 14px; border-radius:8px;
      cursor:pointer; font-weight:700; margin-top:12px;
    }
    .btn.secondary{ background:#fff; color:#333; border:1px solid #e8d9c9; }

    /* quick-order pills */
    .quick-order{ display:flex; gap:8px; flex-wrap:wrap; margin-top:8px; }
    .pill{
      background:#fff; border:1px solid #e8d9c9; padding:8px 12px; border-radius:999px;
      cursor:pointer; font-weight:600; color:var(--accent);
    }
    .pill:hover{ background:var(--muted); }

    /* map */
    .map{ border-radius:10px; overflow:hidden; height:260px; margin-top:12px; }

    /* messages */
    .messages{ margin-top:10px; font-size:14px }

    /* footer */
    footer{ text-align:center; margin-top:28px; color:#666; font-size:14px; }

  </style>
</head>
<body>
  <header>
    <div class="brand">☕ DECANA Caffe & Resto</div>
    <nav aria-label="Main navigation">
      <a href="index.php" class="<?php echo ($page === 'home') ? 'active' : ''; ?>">Beranda</a>
      <a href="menu.php" class="<?php echo ($page === 'menu') ? 'active' : ''; ?>">Menu</a>
      <a href="pemesanan.php" class="<?php echo ($page === 'pemesanan') ? 'active' : ''; ?>">Pemesanan</a>
      <a href="tentang.php" class="<?php echo ($page === 'tentang') ? 'active' : ''; ?>">Tentang Kami</a>
      <a href="kontak.php" aria-current="page">Kontak</a>
    </nav>
  </header>

  <main class="container" id="main">
    <!-- HERO -->
    <section class="hero" aria-labelledby="contact-title">
      <div class="left">
        <h1 id="contact-title">Hubungi Kami — DECANA</h1>
        <p>Butuh bantuan, reservasi, kerjasama, atau pemesanan cepat? Isi formulir di bawah atau hubungi kami langsung lewat telepon / WhatsApp. Kami siap melayani dengan ramah.</p>

        <div style="margin-top:12px; display:flex; gap:10px; align-items:center; flex-wrap:wrap">
          <a class="btn" href="pemesanan.php">Pesan Sekarang</a>
          <a class="btn secondary" href="https://wa.me/6281234567890" target="_blank" rel="noopener">Chat via WhatsApp</a>
        </div>
      </div>

      <aside style="flex:0 0 320px">
        <div class="card" aria-label="Kontak Cepat">
          <h3 style="margin:0 0 10px; color:var(--accent)">Kontak Cepat</h3>
          <div class="contact-info">
            <div class="info-row">
              <div class="icon" aria-hidden="true">📍</div>
              <div class="info-text"><h4>Alamat</h4><p>Jl. Raya Slawi No.45, Tegal</p></div>
            </div>

            <div class="info-row">
              <div class="icon" aria-hidden="true">📞</div>
              <div class="info-text"><h4>Telepon</h4><p>(0283) 777-888</p></div>
            </div>

            <div class="info-row">
              <div class="icon" aria-hidden="true">✉️</div>
              <div class="info-text"><h4>Email</h4><p>info@decana.co.id</p></div>
            </div>

            <div class="info-row">
              <div class="icon" aria-hidden="true">⏰</div>
              <div class="info-text"><h4>Jam Buka</h4><p>08.00 - 22.00 WIB (Setiap Hari)</p></div>
            </div>

            <div style="margin-top:10px">
              <strong>Pesan Cepat</strong>
              <div class="quick-order" id="quickOrder"></div>
            </div>
          </div>
        </div>
      </aside>
    </section>

    <!-- GRID: FORM & MAP -->
    <div class="grid">
      <!-- FORM KONTAK -->
      <section class="card" aria-labelledby="formTitle">
        <h2 id="formTitle" style="margin-top:0; color:var(--accent)">Kirim Pesan ke Kami</h2>

        <form id="contactForm" autocomplete="off">
          <label for="nama">Nama Lengkap</label>
          <input id="nama" name="nama" type="text" placeholder="Contoh: Siti Aisyah" required>

          <label for="email">Email</label>
          <input id="email" name="email" type="email" placeholder="name@domain.com" required>

          <label for="pesan">Pesan</label>
          <textarea id="pesan" name="pesan" placeholder="Apa yang bisa kami bantu?" required></textarea>

          <button class="btn" type="submit">Kirim Pesan</button>
          <div id="msgBox" class="messages" role="status" aria-live="polite"></div>
        </form>

        <hr style="margin:18px 0">

        <h4 style="margin:0 0 8px">Atau Hubungi Langsung</h4>
        <p style="margin:0 0 8px; color:#555">Telp / WA: <a href="tel:+6281234567890">+62 812-3456-7890</a></p>
      </section>

      <!-- MAP & INFO -->
      <aside>
        <div class="card">
          <h3 style="margin-top:0; color:var(--accent)">Lokasi Kami</h3>

          <!-- Ganti src dengan embed Google Maps lokasi asli jika perlu -->
          <div class="map" aria-hidden="false">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.123456789!2d109.123456!3d-6.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f7c123456789%3A0xabcdef1234567890!2sTegal!5e0!3m2!1sen!2sid!4v1600000000000!5m2!1sen!2sid"
              width="100%" height="260" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>

          <h4 style="margin:12px 0 6px">Jam Operasional</h4>
          <p style="margin:0 0 8px; color:#555">Senin - Minggu: 08.00 - 22.00 WIB</p>

          <h4 style="margin:8px 0 6px">Metode Pembayaran</h4>
          <p style="margin:0; color:#555">Tunai, Transfer Bank, QRIS</p>
        </div>
      </aside>
    </div>

    <footer>
      © <?php echo date('Y'); ?> DECANA Caffe & Resto | Nikmati Cita Rasa dalam Setiap Tegukan
    </footer>
  </main>

  <script>
    // Daftar menu pendek untuk quick-order (sama dengan menu utama)
    const MENU_SHORT = [
      "Espresso","Americano","Caffè Latte","Cappuccino","Mocha","Iced Coffee",
      "Caramel Macchiato","Affogato","Matcha Latte","Red Velvet Latte",
      "Hot Chocolate","Milkshake Vanilla","Nasi Goreng Spesial","Pasta Carbonara","Chicken Steak"
    ];

    // Render quick-order pills
    const quickOrderEl = document.getElementById('quickOrder');
    MENU_SHORT.forEach(name=>{
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'pill';
      btn.textContent = name;
      btn.addEventListener('click', ()=> {
        // arahkan ke pemesanan dengan preselect menu lewat query param
        const url = 'pemesanan.php?menu=' + encodeURIComponent(name);
        window.location.href = url;
      });
      quickOrderEl.appendChild(btn);
    });

    // Contact form: simpan pesan ke localStorage agar admin bisa lihat
    const contactForm = document.getElementById('contactForm');
    const msgBox = document.getElementById('msgBox');

    contactForm.addEventListener('submit', function(e){
      e.preventDefault();
      const nama = document.getElementById('nama').value.trim();
      const email = document.getElementById('email').value.trim();
      const pesan = document.getElementById('pesan').value.trim();

      if(!nama || !email || !pesan){
        msgBox.style.color = 'crimson';
        msgBox.textContent = 'Harap lengkapi semua kolom.';
        return;
      }

      const messages = JSON.parse(localStorage.getItem('decana_messages')) || [];
      const item = {
        id: 'M' + Date.now(),
        nama, email, pesan,
        waktu: new Date().toISOString()
      };
      messages.push(item);
      localStorage.setItem('decana_messages', JSON.stringify(messages));

      msgBox.style.color = 'green';
      msgBox.textContent = 'Pesan terkirim! Tim DECANA akan menghubungi Anda secepatnya.';
      contactForm.reset();
      setTimeout(()=> msgBox.textContent = '', 5000);
    });

    // Jika pengguna datang dari pemesanan dengan menu param, pemesanan.php akan gunakan param tersebut.
    // (Jangan lupa: pemesanan.php harus membaca URLSearchParams untuk preselect menu)
  </script>
</body>
</html>
