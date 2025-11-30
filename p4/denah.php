<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Denah Caffe Decana</title>
  <style>
    /* Internal CSS: sederhana, rapi, responsif */
    :root{
      --bg:#f7f6f4;
      --card:#ffffff;
      --accent:#b55a31;
      --muted:#666;
      --glass: rgba(255,255,255,0.8);
      font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    }
    *{box-sizing:border-box}
    body{margin:0;background:linear-gradient(180deg,var(--bg),#efeae6);color:#222}
    header{background:var(--card);backdrop-filter: blur(6px);box-shadow:0 2px 8px rgba(0,0,0,.06);padding:18px 20px;display:flex;gap:18px;align-items:center}
    .brand{display:flex;align-items:center;gap:12px}
    .brand .logo{width:54px;height:54px;border-radius:8px;background:linear-gradient(135deg,var(--accent),#f2a07b);display:flex;align-items:center;justify-content:center;color:white;font-weight:700}
    .brand h1{font-size:18px;margin:0}
    .brand p{margin:0;font-size:12px;color:var(--muted)}

    main{display:grid;grid-template-columns:1fr 380px;gap:18px;padding:18px;max-width:1200px;margin:18px auto}

    /* Panel denah */
    .map-card{background:var(--card);padding:16px;border-radius:14px;box-shadow:0 6px 24px rgba(0,0,0,.06)}
    .map-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
    .controls{display:flex;gap:8px;align-items:center}
    button.btn{background:var(--accent);border:none;color:white;padding:8px 12px;border-radius:10px;cursor:pointer}
    button.ghost{background:transparent;border:1px solid #eee;color:var(--muted)}

    /* SVG container */
    .floorwrap{width:100%;height:560px;border-radius:10px;background:linear-gradient(180deg,#fff,#fff);display:flex;align-items:center;justify-content:center;padding:12px}
    svg{max-width:100%;max-height:100%;border-radius:8px}

    /* Info sidebar */
    aside{background:var(--card);padding:16px;border-radius:14px;box-shadow:0 6px 24px rgba(0,0,0,.06);height:fit-content}
    .info-title{font-weight:700;margin:0 0 8px 0}
    .legend{display:flex;flex-direction:column;gap:8px;margin-bottom:12px}
    .legend-item{display:flex;gap:10px;align-items:center}
    .swatch{width:28px;height:18px;border-radius:4px}
    .meta{font-size:13px;color:var(--muted)}

    /* modal */
    .modal{position:fixed;inset:0;display:none;align-items:center;justify-content:center;background:rgba(0,0,0,.4);z-index:50}
    .modal.show{display:flex}
    .modal-card{background:var(--card);padding:18px;border-radius:12px;max-width:520px;width:94%;box-shadow:0 20px 60px rgba(0,0,0,.3)}

    /* responsive */
    @media (max-width:980px){main{grid-template-columns:1fr;}.floorwrap{height:420px}} 
    @media (max-width:520px){.floorwrap{height:360px}.brand h1{font-size:16px}}

    /* tooltip-like hover */
    .hotspot{cursor:pointer;transition:transform .12s ease}
    .hotspot:hover{transform:scale(1.03)}
  </style>
</head>
<body>
  <header>
    <div class="brand">
      <div class="logo">D</div>
      <div>
        <h1>Caffe Decana — Denah &amp; Panduan</h1>
        <p>Temukan meja, area, dan fasilitas dengan cepat</p>
      </div>
    </div>
    <div style="margin-left:auto;display:flex;gap:10px;align-items:center">
      <button class="ghost">Tentang</button>
      <button class="btn" id="printBtn">Cetak Denah</button>
    </div>
  </header>

  <main>
    <section class="map-card">
      <div class="map-header">
        <div>
          <strong>Denah Lantai - Caffe Decana</strong>
          <div class="meta">Lantai utama, kapasitas ~40 orang</div>
        </div>
        <div class="controls">
          <button class="btn" id="zoomIn">+</button>
          <button class="btn" id="zoomOut">−</button>
          <button class="ghost" id="resetView">Reset</button>
        </div>
      </div>

      <div class="floorwrap" id="floorwrap">
        <!-- SVG simple denah: meja, kasir, dapur, wc -->
        <svg id="denah" viewBox="0 0 1000 700" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Denah Caffe Decana">
          <!-- background floor -->
          <rect x="10" y="10" width="980" height="680" rx="16" fill="#fbfaf9" stroke="#efe6df"/>

          <!-- Entrance -->
          <g id="entrance">
            <rect x="420" y="18" width="160" height="30" rx="6" fill="#fff6ef" stroke="#f1d8c3"/>
            <text x="500" y="38" font-size="14" text-anchor="middle" fill="#6b3b27">ENTRANCE</text>
          </g>

          <!-- Counter / Kasir -->
          <g class="hotspot" id="counter" data-name="Kasir &amp; Bar" data-desc="Tempat pesanan dan pembayaran. Ada mesin espresso dan display kue." tabindex="0">
            <rect x="720" y="60" width="240" height="120" rx="8" fill="#fff" stroke="#d8c3b6"/>
            <text x="840" y="130" font-size="18" text-anchor="middle" fill="#894b30">KASIR / BAR</text>
          </g>

          <!-- Kitchen -->
          <g class="hotspot" id="kitchen" data-name="Dapur" data-desc="Area persiapan makanan dan minuman. Akses untuk staf only." tabindex="0">
            <rect x="720" y="200" width="240" height="180" rx="8" fill="#fff" stroke="#e0d6d0"/>
            <text x="840" y="300" font-size="18" text-anchor="middle" fill="#5b473e">DAPUR</text>
          </g>

          <!-- Seating area left -->
          <g id="leftSeats">
            <rect x="40" y="64" width="620" height="180" rx="10" fill="#fff" stroke="#efe1d8"/>
            <text x="350" y="86" font-size="14" fill="#7a5a4a">Area Duduk Utama</text>

            <!-- tables: 1..6 -->
            <g class="hotspot" id="t1" data-name="Meja 1" data-desc="Meja untuk 2 orang." tabindex="0">
              <rect x="70" y="110" width="90" height="70" rx="8" fill="#fffdfb" stroke="#e7d5cc"/>
              <text x="115" y="150" font-size="13" text-anchor="middle">Meja 1</text>
            </g>
            <g class="hotspot" id="t2" data-name="Meja 2" data-desc="Meja untuk 2 orang." tabindex="0">
              <rect x="190" y="110" width="90" height="70" rx="8" fill="#fffdfb" stroke="#e7d5cc"/>
              <text x="235" y="150" font-size="13" text-anchor="middle">Meja 2</text>
            </g>
            <g class="hotspot" id="t3" data-name="Meja 3" data-desc="Meja untuk 4 orang." tabindex="0">
              <rect x="310" y="110" width="130" height="70" rx="8" fill="#fffdfb" stroke="#e7d5cc"/>
              <text x="375" y="150" font-size="13" text-anchor="middle">Meja 3</text>
            </g>
            <g class="hotspot" id="t4" data-name="Meja 4" data-desc="Meja komunitas, cocok untuk kerja kelompok." tabindex="0">
              <rect x="470" y="110" width="150" height="70" rx="8" fill="#fffdfb" stroke="#e7d5cc"/>
              <text x="545" y="150" font-size="13" text-anchor="middle">Meja 4</text>
            </g>

            <!-- lower row -->
            <g class="hotspot" id="t5" data-name="Meja 5" data-desc="Meja di dekat jendela." tabindex="0">
              <rect x="100" y="200" width="110" height="70" rx="8" fill="#fffdfb" stroke="#e7d5cc"/>
              <text x="155" y="240" font-size="13" text-anchor="middle">Meja 5</text>
            </g>
            <g class="hotspot" id="t6" data-name="Meja 6" data-desc="Meja untuk 2 orang, area tenang." tabindex="0">
              <rect x="240" y="200" width="120" height="70" rx="8" fill="#fffdfb" stroke="#e7d5cc"/>
              <text x="300" y="240" font-size="13" text-anchor="middle">Meja 6</text>
            </g>
          </g>

          <!-- Sofa area right -->
          <g class="hotspot" id="sofa" data-name="Sofa Lounge" data-desc="Area santai dengan sofa dan meja kecil." tabindex="0">
            <rect x="40" y="340" width="480" height="200" rx="10" fill="#fff" stroke="#efe1d8"/>
            <text x="280" y="362" font-size="14" fill="#7a5a4a">Sofa Lounge</text>
          </g>

          <!-- WC -->
          <g class="hotspot" id="wc" data-name="Toilet" data-desc="Toilet pria & perempuan. Akses umum." tabindex="0">
            <rect x="720" y="400" width="120" height="120" rx="8" fill="#fff" stroke="#e7e0df"/>
            <text x="780" y="460" font-size="14" text-anchor="middle" fill="#6b6b6b">WC</text>
          </g>

          <!-- Storage -->
          <g id="storage">
            <rect x="860" y="400" width="98" height="120" rx="8" fill="#fff" stroke="#efebe8"/>
            <text x="909" y="460" font-size="12" text-anchor="middle" fill="#8a8a8a">Gudang</text>
          </g>

          <!-- Outdoor terrace -->
          <g class="hotspot" id="terrace" data-name="Terasa Luar" data-desc="Area duduk outdoor, cocok untuk merokok & udara segar." tabindex="0">
            <rect x="40" y="560" width="940" height="110" rx="8" fill="#fffaf6" stroke="#efe6df"/>
            <text x="510" y="620" font-size="14" text-anchor="middle" fill="#7a5a4a">TERASA LUAR</text>
          </g>

        </svg>
      </div>
    </section>

    <aside>
      <h3 class="info-title">Informasi & Legenda</h3>
      <div class="meta">Klik pada area denah untuk melihat detail. Gunakan tombol zoom/cetak di atas.</div>

      <div style="height:12px"></div>
      <div class="legend">
        <div class="legend-item"><div class="swatch" style="background:#fffdfb;border:1px solid #e7d5cc"></div><div>Meja / Area duduk</div></div>
        <div class="legend-item"><div class="swatch" style="background:#fff6ef;border:1px solid #f1d8c3"></div><div>Entrance / Akses</div></div>
        <div class="legend-item"><div class="swatch" style="background:#fffaf6;border:1px solid #efe6df"></div><div>Outdoor / Terasa</div></div>
        <div class="legend-item"><div class="swatch" style="background:#ffffff;border:1px solid #e0d6d0"></div><div>Fasilitas (dapur, kasir, wc)</div></div>
      </div>

      <div class="meta"><strong>Detail terpilih:</strong></div>
      <div id="detailBox" style="padding:10px;background:linear-gradient(180deg,#fff,#faf8f7);border-radius:8px;margin-top:10px;min-height:120px">Pilih area di denah untuk melihat informasi.</div>

      <div style="height:14px"></div>
      <div style="display:flex;gap:8px;flex-wrap:wrap">
        <button class="btn" id="exportPNG">Simpan PNG</button>
        <button class="ghost" id="downloadSVG">Download SVG</button>
      </div>
    </aside>
  </main>

  <!-- modal detail -->
  <div class="modal" id="modal">
    <div class="modal-card">
      <h3 id="modalTitle"></h3>
      <p id="modalDesc"></p>
      <div style="text-align:right;margin-top:12px"><button class="btn" id="modalClose">Tutup</button></div>
    </div>
  </div>

  <script>
    // Interactivity: klik hotspot -> tampilkan modal + sidebar detail
    const hotspots = document.querySelectorAll('.hotspot');
    const modal = document.getElementById('modal');
    const modalTitle = document.getElementById('modalTitle');
    const modalDesc = document.getElementById('modalDesc');
    const modalClose = document.getElementById('modalClose');
    const detailBox = document.getElementById('detailBox');

    hotspots.forEach(h => {
      h.addEventListener('click', () => handleSelect(h));
      h.addEventListener('keydown', (e)=>{ if(e.key==='Enter' || e.key===' ') handleSelect(h)});
    });

    function handleSelect(el){
      const name = el.dataset.name || el.id;
      const desc = el.dataset.desc || 'Tidak ada informasi.';
      modalTitle.textContent = name;
      modalDesc.textContent = desc;
      detailBox.innerHTML = `<strong>${name}</strong><div style="margin-top:6px;color:var(--muted)">${desc}</div>`;
      modal.classList.add('show');
    }
    modalClose.addEventListener('click', ()=> modal.classList.remove('show'));
    modal.addEventListener('click', (e)=>{ if(e.target===modal) modal.classList.remove('show') });

    // Zoom basic
    const svg = document.getElementById('denah');
    let scale = 1;
    const setScale = (s)=>{ svg.style.transform = `scale(${s})`; svg.style.transformOrigin='50% 0%'; }
    document.getElementById('zoomIn').addEventListener('click', ()=>{ scale = Math.min(2, +(scale+0.1).toFixed(2)); setScale(scale); });
    document.getElementById('zoomOut').addEventListener('click', ()=>{ scale = Math.max(.6, +(scale-0.1).toFixed(2)); setScale(scale); });
    document.getElementById('resetView').addEventListener('click', ()=>{ scale=1; setScale(scale); window.scrollTo({top:0,behavior:'smooth'}); });

    // Print
    document.getElementById('printBtn').addEventListener('click', ()=>{ window.print(); });

    // Export SVG / PNG
    document.getElementById('downloadSVG').addEventListener('click', ()=>{
      const serializer = new XMLSerializer();
      const source = serializer.serializeToString(svg);
      const blob = new Blob([source], {type: 'image/svg+xml;charset=utf-8'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a'); a.href = url; a.download = 'denah-caffe-decana.svg'; document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
    });

    document.getElementById('exportPNG').addEventListener('click', async ()=>{
      // convert svg to png using canvas
      const serializer = new XMLSerializer();
      const source = serializer.serializeToString(svg);
      const svg64 = btoa(unescape(encodeURIComponent(source)));
      const b64Start = 'data:image/svg+xml;base64,';
      const image64 = b64Start + svg64;
      const img = new Image();
      img.onload = function(){
        const canvas = document.createElement('canvas');
        canvas.width = img.width*1.5; canvas.height = img.height*1.5;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#ffffff'; ctx.fillRect(0,0,canvas.width,canvas.height);
        ctx.drawImage(img,0,0,canvas.width,canvas.height);
        const png = canvas.toDataURL('image/png');
        const a = document.createElement('a'); a.href = png; a.download = 'denah-caffe-decana.png'; document.body.appendChild(a); a.click(); a.remove();
      }
      img.src = image64;
    });

    // Accessibility: focus outline for keyboard users
    document.addEventListener('keydown', function(e){ if(e.key==='Escape') modal.classList.remove('show') });

    // Small enhancement: highlight on hover + aria
    hotspots.forEach(h=>{
      h.setAttribute('role','button');
      h.setAttribute('tabindex','0');
      h.addEventListener('mouseenter',()=> h.style.opacity=0.95);
      h.addEventListener('mouseleave',()=> h.style.opacity=1);
    });

  </script>
</body>
</html>
