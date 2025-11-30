<?php
// bangku.php
$page = 'bangku';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title>Bangku DECANA — Perhitungan Kursi Rapi</title>
<style>
  :root{
    --brown:#5c3d2e;
    --accent:#8b5a3c;
    --bg:#fffaf3;
    --card:#ffffff;
    --muted:#f5e8da;
  }
  *{box-sizing:border-box}
  body{font-family:Inter, Poppins, system-ui, Arial; margin:0; background:var(--bg); color:#222}
  header{background:var(--brown); color:#fff; padding:18px 12px; text-align:center}
  header h1{margin:0;font-size:20px}
  .wrap{max-width:1200px;margin:18px auto;padding:12px}
  .topbar{display:flex;gap:12px;align-items:center;flex-wrap:wrap;margin-bottom:12px}
  .note{font-size:14px;color:#333}
  .controls{margin-left:auto;display:flex;gap:8px}
  .btn{padding:8px 10px;border-radius:8px;border:none;cursor:pointer}
  .btn.free{background:#fff;color:var(--brown);border:1px solid var(--brown)}
  .btn.occupy{background:var(--brown);color:#fff}
  .summary-boxes{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:12px;margin-bottom:12px}
  .box{background:var(--card);padding:12px;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
  .box h3{margin:0 0 8px 0;color:var(--brown)}
  .small{font-size:13px;color:#666}
  .stats{display:flex;gap:10px;flex-wrap:wrap}
  .stat{background:var(--muted);padding:8px;border-radius:8px;min-width:120px}
  .stat strong{display:block;font-size:18px;color:var(--brown)}
  .floors{margin-top:10px}
  .floor-header{display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin:10px 0}
  .floor-header h2{margin:0;color:var(--brown)}
  .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:10px}
  .table-card{background:#fff;padding:10px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.06);text-align:center}
  .table-code{font-weight:700;color:var(--brown);font-size:16px}
  .table-seat{font-size:13px;color:#666;margin-top:6px}
  .table-status{margin-top:8px;padding:6px;border-radius:8px;font-weight:700}
  .table-status.kosong{background:#e8f6ea;color:#1b7a2b}
  .table-status.terisi{background:#ffecec;color:#b02a2a}
  .table-actions{margin-top:8px;display:flex;gap:6px;justify-content:center;flex-wrap:wrap}
  .legend{display:flex;gap:12px;align-items:center;margin-bottom:6px}
  .dot{width:14px;height:14px;border-radius:3px;display:inline-block}
  .dot.k{background:#e8f6ea;border:1px solid #bfe6bf}
  .dot.t{background:#ffecec;border:1px solid #f0b8b8}
  footer{margin-top:18px;text-align:center;color:#666;font-size:13px}
  .center{text-align:center}
  @media(max-width:680px){ .topbar{flex-direction:column;align-items:stretch} }
</style>
</head>
<body>

<header>
  <h1>🪑 Status Meja & Perhitungan Kursi — DECANA</h1>
</header>

<div class="wrap">
  <div class="topbar">
    <div class="note">Sinkron: <code>localStorage</code> key <strong>decana_tables_simple</strong>. Perubahan pesanan di halaman pemesanan akan otomatis memengaruhi status meja di sini (tab/ browser sama).</div>
    <div class="controls">
      <button id="resetAll" class="btn free">Reset Semua → Kosong</button>
      <button id="resetFloor" class="btn free">Reset Lantai Terpilih</button>
    </div>
  </div>

  <!-- summary global -->
  <div class="summary-boxes" id="globalSummary"></div>

  <!-- per-floor summaries -->
  <div id="floorSummaries"></div>

  <!-- floor detail -->
  <div style="margin-top:12px">
    <label for="floorSelect" class="small">Pilih Lantai:</label>
    <select id="floorSelect" style="padding:8px;border-radius:6px;border:1px solid #ddd;margin-left:8px">
      <option value="1">Lantai 1</option>
      <option value="2">Lantai 2</option>
    </select>
  </div>

  <div id="floorDetail" style="margin-top:12px"></div>

  <footer>
    © <?php echo date('Y'); ?> DECANA Caffe & Resto — Perhitungan kursi per tipe & total jelas
  </footer>
</div>

<script>
/* Improved bangku.html:
 - generate tables as requested (2 floors)
 - compute counts per table-type and seat totals (occupied & free)
 - show tidy summaries
 - sync via localStorage key: decana_tables_simple
*/

const LS_TABLES = 'decana_tables_simple';

// requested composition per floor
const countsPerFloor = [
  { seats: 4, count: 10 },
  { seats: 6, count: 30 },
  { seats: 2, count: 50 }
];

function generateDefaultTables(){
  const tables = [];
  let id = 1;
  for(let floor=1; floor<=2; floor++){
    countsPerFloor.forEach(group=>{
      for(let i=1;i<=group.count;i++){
        const code = `L${floor}-${group.seats}-${String(i).padStart(2,'0')}`;
        tables.push({ id: id++, code, floor, seats: group.seats, is_available: 1 });
      }
    });
  }
  return tables;
}

function loadTables(){
  const raw = localStorage.getItem(LS_TABLES);
  if(raw){
    try{
      const parsed = JSON.parse(raw);
      if(Array.isArray(parsed) && parsed.length>0) return parsed;
    }catch(e){}
  }
  const def = generateDefaultTables();
  localStorage.setItem(LS_TABLES, JSON.stringify(def));
  return def;
}
function saveTables(tables){
  localStorage.setItem(LS_TABLES, JSON.stringify(tables));
  window.dispatchEvent(new Event('decana_tables_updated'));
}

/* utilities */
function sum(arr){ return arr.reduce((s,x)=>s+x,0); }
function rp(n){ return 'Rp '+Number(n).toLocaleString('id-ID'); }
function escapeHtml(s){ if(!s && s !== 0) return ''; return String(s).replace(/[&<>"']/g, m=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'})[m]); }

/* compute stats per floor and global */
function computeStats(tables){
  const floors = [1,2];
  const result = { global: {}, floors: {} };

  // initialize global counters
  result.global.totalTables = tables.length;
  result.global.totalSeats = sum(tables.map(t=>t.seats || 0));
  result.global.occupiedTables = tables.filter(t=>t.is_available===0).length;
  result.global.freeTables = result.global.totalTables - result.global.occupiedTables;
  result.global.occupiedSeats = sum(tables.filter(t=>t.is_available===0).map(t=>t.seats||0));
  result.global.freeSeats = result.global.totalSeats - result.global.occupiedSeats;

  // per-type global counts (2/4/6)
  const types = [...new Set(tables.map(t=>t.seats))].sort((a,b)=>a-b);
  result.global.types = {};
  types.forEach(seat=>{
    const items = tables.filter(t=>t.seats===seat);
    result.global.types[seat] = {
      tables: items.length,
      seatsTotal: sum(items.map(x=>x.seats)),
      occupiedTables: items.filter(x=>x.is_available===0).length,
      occupiedSeats: sum(items.filter(x=>x.is_available===0).map(x=>x.seats))
    };
  });

  // per floor
  floors.forEach(f=>{
    const floorTables = tables.filter(t=>t.floor===f);
    result.floors[f] = {
      totalTables: floorTables.length,
      totalSeats: sum(floorTables.map(t=>t.seats || 0)),
      occupiedTables: floorTables.filter(t=>t.is_available===0).length,
      freeTables: floorTables.filter(t=>t.is_available===1).length,
      occupiedSeats: sum(floorTables.filter(t=>t.is_available===0).map(t=>t.seats||0)),
      freeSeats: sum(floorTables.filter(t=>t.is_available===1).map(t=>t.seats||0)),
      types: {}
    };
    const floorTypes = [...new Set(floorTables.map(t=>t.seats))].sort((a,b)=>a-b);
    floorTypes.forEach(seat=>{
      const items = floorTables.filter(x=>x.seats===seat);
      result.floors[f].types[seat] = {
        tables: items.length,
        seatsTotal: sum(items.map(x=>x.seats)),
        occupiedTables: items.filter(x=>x.is_available===0).length,
        occupiedSeats: sum(items.filter(x=>x.is_available===0).map(x=>x.seats))
      };
    });
  });

  return result;
}

/* render functions */
function renderGlobalSummary(stats){
  const container = document.getElementById('globalSummary');
  container.innerHTML = '';

  // small cards
  const cards = [
    {title:'Total Meja (Semua Lantai)', value: stats.global.totalTables},
    {title:'Total Kursi (Semua Lantai)', value: stats.global.totalSeats},
    {title:'Meja Terisi (Semua)', value: stats.global.occupiedTables},
    {title:'Kursi Terisi (Semua)', value: stats.global.occupiedSeats},
    {title:'Meja Kosong (Semua)', value: stats.global.freeTables},
    {title:'Kursi Kosong (Semua)', value: stats.global.freeSeats}
  ];

  cards.forEach(c=>{
    const div = document.createElement('div');
    div.className = 'box';
    div.innerHTML = `<h3>${escapeHtml(c.title)}</h3><div class="stat"><strong>${c.value}</strong></div>`;
    container.appendChild(div);
  });
}

function renderFloorSummaries(tables, stats){
  const container = document.getElementById('floorSummaries');
  container.innerHTML = '';

  [1,2].forEach(f=>{
    const s = stats.floors[f];
    const box = document.createElement('div');
    box.className = 'box';
    box.innerHTML = `
      <h3>Ringkasan Lantai ${f}</h3>
      <div class="small">Meja: <strong>${s.totalTables}</strong> • Kursi Total: <strong>${s.totalSeats}</strong></div>
      <div class="small">Terisi: <strong>${s.occupiedTables}</strong> • Kursi Terisi: <strong>${s.occupiedSeats}</strong></div>
      <div class="small">Kosong: <strong>${s.freeTables}</strong> • Kursi Kosong: <strong>${s.freeSeats}</strong></div>
      <div style="margin-top:8px;" class="small">Rincian per tipe:</div>
      <div style="margin-top:6px" class="stats">
        ${Object.keys(s.types).map(seat=>{
          const t = s.types[seat];
          return `<div class="stat"><div class="small">Tipe ${seat} kursi</div><strong>${t.tables} meja</strong><div class="small">Kursi total ${t.seatsTotal}</div><div class="small">Terisi ${t.occupiedTables} meja / ${t.occupiedSeats} kursi</div></div>`;
        }).join('')}
      </div>
      <div style="margin-top:8px"><button class="btn free" data-view-floor="${f}">Lihat detail Lantai ${f}</button></div>
    `;
    container.appendChild(box);
  });

  // attach view buttons
  container.querySelectorAll('[data-view-floor]').forEach(b=>{
    b.addEventListener('click', ()=> {
      document.getElementById('floorSelect').value = b.getAttribute('data-view-floor');
      renderFloorDetail(Number(b.getAttribute('data-view-floor')));
      window.scrollTo({top:500, behavior:'smooth'});
    });
  });
}

function renderFloorDetail(floor){
  const tables = loadTables();
  const floorTables = tables.filter(t=>t.floor === floor);
  const container = document.getElementById('floorDetail');
  const headerHtml = `
    <div class="floor-header">
      <h2>Lantai ${floor} — Detail Meja (${floorTables.length} meja)</h2>
      <div class="small">Klik tombol untuk menandai Kosong/Terisi</div>
    </div>
  `;
  const gridHtml = floorTables.map(t=>{
    const statusClass = t.is_available === 1 ? 'kosong' : 'terisi';
    const statusText = t.is_available === 1 ? 'Kosong' : 'Terisi';
    return `
      <div class="table-card" data-id="${t.id}">
        <div class="table-code">${escapeHtml(t.code)}</div>
        <div class="table-seat">Kursi: ${t.seats}</div>
        <div class="table-status ${statusClass}">${statusText}</div>
        <div class="table-actions">
          ${t.is_available === 1 
            ? `<button class="btn occupy" data-act="occupy" data-id="${t.id}">Tandai Terisi</button>`
            : `<button class="btn free" data-act="free" data-id="${t.id}">Tandai Kosong</button>`
          }
        </div>
      </div>`;
  }).join('');

  container.innerHTML = `<div class="box">${headerHtml}<div class="grid">${gridHtml}</div></div>`;

  // attach handlers
  container.querySelectorAll('button[data-act]').forEach(btn=>{
    btn.addEventListener('click', ()=>{
      const id = Number(btn.getAttribute('data-id'));
      const act = btn.getAttribute('data-act');
      toggleTableById(id, act === 'free' ? 1 : 0);
    });
  });
}

/* toggle single table availability */
function toggleTableById(id, availability){
  const tables = loadTables();
  const idx = tables.findIndex(t=>t.id === id);
  if(idx === -1) return;
  tables[idx].is_available = availability;
  saveTables(tables);
  renderAll();
}

/* render everything */
function renderAll(){
  const tables = loadTables();
  const stats = computeStats(tables);
  renderGlobalSummary(stats);
  renderFloorSummaries(tables, stats);
  const selFloor = Number(document.getElementById('floorSelect').value || 1);
  renderFloorDetail(selFloor);
}

/* reset handlers */
document.getElementById('resetAll').addEventListener('click', ()=>{
  if(!confirm('Reset semua meja jadi KOSONG?')) return;
  const tables = generateDefaultTables();
  saveTables(tables);
  renderAll();
});
document.getElementById('resetFloor').addEventListener('click', ()=>{
  const f = Number(document.getElementById('floorSelect').value || 1);
  if(!confirm(`Reset semua meja Lantai ${f} jadi KOSONG?`)) return;
  const tables = loadTables();
  tables.forEach(t=> { if(t.floor === f) t.is_available = 1; });
  saveTables(tables);
  renderAll();
});
document.getElementById('floorSelect').addEventListener('change', ()=> renderAll());

/* listen to storage change (other tab) */
window.addEventListener('storage', (e)=>{
  if(e.key === LS_TABLES){
    renderAll();
  }
});
window.addEventListener('decana_tables_updated', ()=> renderAll());

/* init */
(function init(){
  let tables = loadTables();
  // ensure shape & floors set
  tables = tables.map((t,i)=>({
    id: t.id || (i+1),
    code: t.code || `T${i+1}`,
    floor: t.floor || (t.id && t.id <= (countsPerFloor.reduce((a,b)=>a+b.count,0)) ? 1 : 2),
    seats: t.seats || 4,
    is_available: (typeof t.is_available === 'number' ? t.is_available : (t.is_available ? 1 : 0))
  }));
  saveTables(tables);
  renderAll();
})();
</script>

</body>
</html>
