<?php
// pemesanan.php
$page = 'pemesanan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Pemesanan Sederhana - DECANA (Semua Menu)</title>
<style>
  body{font-family:Arial,Helvetica,sans-serif;background:#fffaf3;margin:0;padding:20px;color:#222}
  header{background:#5c3d2e;color:#fff;padding:14px;border-radius:8px;text-align:center}
  h1{margin:0;font-size:20px}
  .container{max-width:1100px;margin:20px auto;display:grid;grid-template-columns:1fr 360px;gap:20px}
  @media(max-width:960px){.container{grid-template-columns:1fr}}
  .card{background:#fff;padding:12px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.06)}
  .menu-list{display:grid;gap:10px}
  .menu-item{display:flex;justify-content:space-between;align-items:center;padding:10px;border-radius:6px;border:1px solid #f0e0d6;background:#fff}
  .menu-item .info{max-width:72%}
  .menu-item h3{margin:0;color:#5c3d2e;font-size:16px}
  .menu-item p{margin:6px 0 0;font-size:13px;color:#666}
  button{background:#5c3d2e;color:#fff;border:none;padding:8px 10px;border-radius:6px;cursor:pointer}
  button.secondary{background:#fff;color:#5c3d2e;border:1px solid #5c3d2e}
  .cart{display:flex;flex-direction:column;gap:10px}
  .cart-item{display:flex;justify-content:space-between;align-items:center;padding:8px;border-bottom:1px solid #eee}
  select,input[type=number]{padding:8px;border-radius:6px;border:1px solid #ddd}
  .totals{font-weight:700;text-align:right}
  .small{font-size:13px;color:#666}
  .center{text-align:center}
  .searchbar{display:flex;gap:8px;margin-bottom:10px}
  .searchbar input{flex:1;padding:8px;border-radius:6px;border:1px solid #ddd}
  .menu-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:10px}
  .menu-card{background:#f5e8da;padding:10px;border-radius:10px;text-align:center}
  .menu-card h4{margin:8px 0 4px;color:#5c3d2e}
  .menu-card p{font-size:13px;color:#444;margin:0}
  .price{margin-top:8px;font-weight:700}
</style>
</head>
<body>

<header>
  <h1>🛒 Pemesanan DECANA — Semua Menu</h1>
</header>

<div class="container">
  <!-- LEFT: Menu -->
  <div class="card">
    <div class="searchbar">
      <input id="searchInput" placeholder="Cari menu (ketik nama atau kategori)...">
      <select id="categoryFilter"><option value="">Semua Kategori</option></select>
    </div>

    <div id="menuGrid" class="menu-grid"></div>
  </div>

  <!-- RIGHT: Cart & Meja -->
  <div class="card">
    <h2>Ringkasan Pesanan</h2>

    <label class="small">Pilih Meja:</label><br/>
    <select id="tableSelect" style="width:100%;margin:8px 0 12px">
      <!-- options diisi JS -->
    </select>

    <div id="cartArea" class="cart">
      <div class="center small">Keranjang kosong</div>
    </div>

    <div class="totals" style="margin-top:8px">
      <div>Subtotal: <span id="subtotal">Rp 0</span></div>
      <div style="margin-top:6px">Total (PPN 10%): <span id="total">Rp 0</span></div>
    </div>

    <div style="margin-top:12px;display:flex;gap:8px">
      <button id="confirmBtn" style="flex:1">Konfirmasi Pesanan</button>
      <button id="clearBtn" class="secondary" style="flex:1">Kosongkan</button>
    </div>

    <p class="small" style="margin-top:10px">Catatan: demo frontend. Data disimpan di <code>localStorage</code>.</p>

    <div style="margin-top:12px">
      <button id="resetTables" class="secondary" style="width:100%;padding:8px">Reset Meja (debug)</button>
    </div>
  </div>
</div>

<script>
/*
  Semua menu ditambahkan di menuData (unik berdasarkan nama).
  Versi sederhana: menyimpan pesanan ke localStorage 'decana_orders_simple'
  Meja disimpan di localStorage 'decana_tables_simple'
*/

/* ------------------ MENU DATA (SEMUA ITEM DARI DAFTAR) ------------------ */
const menuData = [
  /* Kopi */
  {id:1, category:'Kopi', name:'Espresso', price:20000},
  {id:2, category:'Kopi', name:'Americano', price:22000},
  {id:3, category:'Kopi', name:'Coffe Latte', price:25000},
  {id:4, category:'Kopi', name:'Cappuccino', price:27000},
  {id:5, category:'Kopi', name:'Mocha', price:28000},
  {id:6, category:'Kopi', name:'Iced Coffee', price:24000},
  {id:7, category:'Kopi', name:'Caramel Macchiato', price:30000},
  {id:8, category:'Kopi', name:'Affogato', price:32000},
  {id:9, category:'Kopi', name:'Flat White', price:26000},
  {id:10, category:'Kopi', name:'Piccolo Latte', price:24000},
  {id:11, category:'Kopi', name:'Long Black', price:23000},
  {id:12, category:'Kopi', name:'Cortado', price:27000},
  {id:13, category:'Kopi', name:'Vienna Coffee', price:29000},
  {id:14, category:'Kopi', name:'Hazelnut Latte', price:30000},
  {id:15, category:'Kopi', name:'Salted Caramel Latte', price:31000},
  {id:16, category:'Kopi', name:'Cold Brew', price:28000},
  {id:17, category:'Kopi', name:'Nitro Coffee', price:35000},
  {id:18, category:'Kopi', name:'Irish Coffee', price:36000},

  /* Non-Kopi */
  {id:19, category:'Non-Kopi', name:'Matcha Latte', price:27000},
  {id:20, category:'Non-Kopi', name:'Red Velvet Latte', price:28000},
  {id:21, category:'Non-Kopi', name:'Hot Chocolate', price:25000},
  {id:22, category:'Non-Kopi', name:'Milkshake Vanilla', price:26000},
  {id:23, category:'Non-Kopi', name:'Teh Lemon', price:20000},
  {id:24, category:'Non-Kopi', name:'Green Tea Latte', price:25000},
  {id:25, category:'Non-Kopi', name:'Chai Latte', price:26000},
  {id:26, category:'Non-Kopi', name:'Ginger Tea', price:18000},
  {id:27, category:'Non-Kopi', name:'Homemade Lemonade', price:22000},
  {id:28, category:'Non-Kopi', name:'Mango Smoothie', price:30000},
  {id:29, category:'Non-Kopi', name:'Iced Peach Tea', price:22000},
  {id:30, category:'Non-Kopi', name:'Sparkling Berry', price:29000},
  {id:31, category:'Non-Kopi', name:'Vanilla Latte (Non-Coffee)', price:24000},
  {id:32, category:'Non-Kopi', name:'Strawberry Smoothie', price:30000},
  {id:33, category:'Non-Kopi', name:'Blueberry Smoothie', price:32000},
  {id:34, category:'Non-Kopi', name:'Chocolate Milkshake', price:28000},
  {id:35, category:'Non-Kopi', name:'Avocado Float', price:33000},
  {id:36, category:'Non-Kopi', name:'Thai Tea', price:25000},
  {id:37, category:'Non-Kopi', name:'Tropical Punch', price:30000},
  {id:38, category:'Non-Kopi', name:'Lychee Tea', price:24000},
  {id:39, category:'Non-Kopi', name:'Honey Lemon Tea', price:23000},

  /* Makanan Berat */
  {id:40, category:'Makanan Berat', name:'Nasi Goreng Spesial', price:30000},
  {id:41, category:'Makanan Berat', name:'Mie Goreng Jawa', price:28000},
  {id:42, category:'Makanan Berat', name:'Sop Iga Sapi', price:45000},
  {id:43, category:'Makanan Berat', name:'Chicken Steak', price:40000},
  {id:44, category:'Makanan Berat', name:'Pasta Carbonara', price:35000},
  {id:45, category:'Makanan Berat', name:'Grilled Salmon', price:55000},
  {id:46, category:'Makanan Berat', name:'Beef Burger', price:38000},
  {id:47, category:'Makanan Berat', name:'Ribeye Steak', price:85000},
  {id:48, category:'Makanan Berat', name:'Nasi Campur DECANA', price:33000},
  {id:49, category:'Makanan Berat', name:'Chicken Caesar Salad', price:32000},
  {id:50, category:'Makanan Berat', name:'Fish & Chips', price:36000},
  {id:51, category:'Makanan Berat', name:'Ramen Spesial', price:40000},
  {id:52, category:'Makanan Berat', name:'Beef Teriyaki Rice', price:42000},
  {id:53, category:'Makanan Berat', name:'Chicken Katsu Rice', price:38000},
  {id:54, category:'Makanan Berat', name:'Spaghetti Bolognese', price:36000},
  {id:55, category:'Makanan Berat', name:'Seafood Fried Rice', price:40000},
  {id:56, category:'Makanan Berat', name:'Chicken Teriyaki Bowl', price:37000},
  {id:57, category:'Makanan Berat', name:'Spaghetti Aglio Olio', price:34000},
  {id:58, category:'Makanan Berat', name:'Beef Stroganoff', price:50000},
  {id:59, category:'Makanan Berat', name:'Fried Chicken Deluxe', price:35000},

  /* Ringan & Dessert */
  {id:60, category:'Dessert', name:'Donat Cokelat', price:15000},
  {id:61, category:'Dessert', name:'Cheesecake', price:25000},
  {id:62, category:'Dessert', name:'Brownies Panggang', price:20000},
  {id:63, category:'Dessert', name:'Croissant Butter', price:18000},
  {id:64, category:'Dessert', name:'French Fries', price:17000},
  {id:65, category:'Dessert', name:'Pancake Maple', price:22000},
  {id:66, category:'Dessert', name:'Waffle Berry', price:28000},
  {id:67, category:'Dessert', name:'Tiramisu', price:30000},
  {id:68, category:'Dessert', name:'Ice Cream Sundae', price:24000},
  {id:69, category:'Dessert', name:'Banana Foster', price:27000},
  {id:70, category:'Dessert', name:'Chocolate Chip Cookies', price:12000},
  {id:71, category:'Dessert', name:'Fruit Salad', price:20000},
  {id:72, category:'Dessert', name:'Donat Isi Custard', price:18000},
  {id:73, category:'Dessert', name:'Cinnamon Roll', price:22000},
  {id:74, category:'Dessert', name:'Chocolate Lava Cake', price:30000},
  {id:75, category:'Dessert', name:'Oreo Cheesecake', price:28000},
  {id:76, category:'Dessert', name:'Mini Churros', price:20000},
  {id:77, category:'Dessert', name:'Mozzarella Sticks', price:25000},
  {id:78, category:'Dessert', name:'Garlic Bread', price:18000},
  {id:79, category:'Dessert', name:'Pudding Caramel', price:19000},
  {id:80, category:'Dessert', name:'Mango Pudding', price:20000},

  /* Spesial */
  {id:81, category:'Spesial', name:'Beef Rendang', price:48000},
  {id:82, category:'Spesial', name:'Ayam Bakar Madu', price:38000},
  {id:83, category:'Spesial', name:'Iga Bakar Madu', price:55000},
  {id:84, category:'Spesial', name:'Chicken Parmigiana', price:45000},
  {id:85, category:'Spesial', name:'Beef Lasagna', price:42000},
  {id:86, category:'Spesial', name:'Seafood Spaghetti', price:39000},
  {id:87, category:'Spesial', name:'Chicken Teriyaki Bento', price:41000},
  {id:88, category:'Spesial', name:'Steak Mushroom Sauce', price:60000},
  {id:89, category:'Spesial', name:'Grilled Chicken BBQ', price:43000},
  {id:90, category:'Spesial', name:'Shrimp Fried Rice', price:37000},

  /* Snack */
  {id:91, category:'Snack', name:'Onion Rings', price:18000},
  {id:92, category:'Snack', name:'Nachos Cheese', price:25000},
  {id:93, category:'Snack', name:'Potato Wedges', price:20000},
  {id:94, category:'Snack', name:'Mini Burger', price:22000},
  {id:95, category:'Snack', name:'Tahu Crispy', price:15000},
  {id:96, category:'Snack', name:'Sosis Bakar', price:18000},
  {id:97, category:'Snack', name:'Tempe Mendoan', price:12000},
  {id:98, category:'Snack', name:'Roti Bakar Coklat Keju', price:20000},
  {id:99, category:'Snack', name:'Pisang Goreng Crispy', price:17000},
  {id:100, category:'Snack', name:'Churros Cinnamon', price:25000},

  /* Premium Dessert */
  {id:101, category:'Premium Dessert', name:'Red Velvet Cake', price:35000},
  {id:102, category:'Premium Dessert', name:'Blueberry Cheesecake', price:32000},
  {id:103, category:'Premium Dessert', name:'Panna Cotta', price:30000},
  {id:104, category:'Premium Dessert', name:'Chocolate Mousse', price:28000},
  {id:105, category:'Premium Dessert', name:"Crème Brûlée", price:33000},
  {id:106, category:'Premium Dessert', name:'Strawberry Parfait', price:29000},
  {id:107, category:'Premium Dessert', name:'Ice Cream Trio', price:25000},
  {id:108, category:'Premium Dessert', name:'Mochi Ice Cream', price:27000},

  /* Kids & Family */
  {id:109, category:'Kids & Family', name:'Mini Pancake Kids', price:20000},
  {id:110, category:'Kids & Family', name:'Mac and Cheese', price:25000},
  {id:111, category:'Kids & Family', name:'Chicken Nugget Set', price:22000},
  {id:112, category:'Kids & Family', name:'Mini Pizza', price:28000},
  {id:113, category:'Kids & Family', name:'Family Platter', price:85000},

  /* Signature */
  {id:114, category:'Signature', name:'Cappuccino Signature', price:33000},
  {id:115, category:'Signature', name:'Es Kopi Gula Aren', price:30000},
  {id:116, category:'Signature', name:'Tropical Smoothie', price:27000},
  {id:117, category:'Signature', name:'Mojito Lemon Mint', price:25000},
  {id:118, category:'Signature', name:'Avocado Coffee', price:35000},
  {id:119, category:'Signature', name:'Coconut Latte', price:32000},
  {id:120, category:'Signature', name:'Blue Ocean Soda', price:23000},
  {id:121, category:'Signature', name:'Honey Lemon Tea', price:20000},

  /* Pastry */
  {id:122, category:'Pastry', name:'Waffle Ice Cream', price:30000},
  {id:123, category:'Pastry', name:'Apple Pie', price:27000},
  {id:124, category:'Pastry', name:'Crepes Strawberry', price:28000},
  {id:125, category:'Pastry', name:'Banana Split', price:33000},
  {id:126, category:'Pastry', name:'Pudding Coklat', price:20000},
  {id:127, category:'Pastry', name:'Cupcake Vanilla', price:18000},

  /* tambahan */
  {id:128, category:'Makanan Berat', name:'Spaghetti Carbonara', price:38000},
  {id:129, category:'Makanan Berat', name:'Fresh Garden Salad', price:28000},
  {id:130, category:'Makanan Berat', name:'Nasi Ayam Geprek', price:30000},
  {id:131, category:'Makanan Berat', name:'Nasi Ayam Penyet', price:32000},
  {id:132, category:'Makanan Berat', name:'Chicken Katsu Curry', price:42000},
  {id:133, category:'Makanan Berat', name:'Seafood Platter', price:60000},
  {id:134, category:'Makanan Berat', name:'Chicken Cordon Bleu', price:47000},
  {id:135, category:'Makanan Berat', name:'Chicken Stroganoff', price:50000}
];

/* ------------------ Tables default ------------------ */
const defaultTables = [
  {id:1, code:'A1', is_available:1},
  {id:2, code:'A2', is_available:1},
  {id:3, code:'B1', is_available:1},
  {id:4, code:'B2', is_available:1},
  {id:5, code:'C1', is_available:1}
];

const LS_TABLES = 'decana_tables_simple';
const LS_ORDERS = 'decana_orders_simple';

let cart = [];
let tables = [];

function rp(n){ return 'Rp '+Number(n).toLocaleString('id-ID'); }
function saveTables(){ localStorage.setItem(LS_TABLES, JSON.stringify(tables)); }
function loadTables(){ const j=localStorage.getItem(LS_TABLES); tables = j?JSON.parse(j):JSON.parse(JSON.stringify(defaultTables)); saveTables(); }
function saveOrders(order){ const j=localStorage.getItem(LS_ORDERS); const arr = j?JSON.parse(j):[]; arr.push(order); localStorage.setItem(LS_ORDERS, JSON.stringify(arr)); }

function renderCategories(){
  const cats = Array.from(new Set(menuData.map(m=>m.category))).sort();
  const sel = document.getElementById('categoryFilter');
  sel.innerHTML = '<option value="">Semua Kategori</option>' + cats.map(c=>`<option value="${c}">${c}</option>`).join('');
}

function renderMenuGrid(){
  const q = document.getElementById('searchInput').value.trim().toLowerCase();
  const cat = document.getElementById('categoryFilter').value;
  const grid = document.getElementById('menuGrid');

  const list = menuData.filter(m => {
    return (!cat || m.category === cat) &&
           (!q || m.name.toLowerCase().includes(q) || (m.category && m.category.toLowerCase().includes(q)));
  });

  grid.innerHTML = list.map(m => `
    <div class="menu-card">
      <h4>${m.name}</h4>
      <p class="small">${m.category}</p>
      <p class="small">${m.desc || ''}</p>
      <div class="price">${rp(m.price)}</div>
      <div style="margin-top:8px">
        <button onclick="addToCart(${m.id})">Tambah</button>
      </div>
    </div>
  `).join('');
}

function renderTables(){
  const sel = document.getElementById('tableSelect');
  sel.innerHTML = '<option value="">-- Pilih Meja Kosong --</option>';
  tables.forEach(t => {
    if(t.is_available === 1){
      const opt = document.createElement('option');
      opt.value = t.id;
      opt.textContent = t.code;
      sel.appendChild(opt);
    }
  });
}

function addToCart(id){
  const m = menuData.find(x=>x.id === id);
  if(!m) return;
  const e = cart.find(x=>x.id === id);
  if(e) e.qty++;
  else cart.push({id:m.id, name:m.name, price:m.price, qty:1});
  renderCart();
}
function changeQty(id, delta){
  const it = cart.find(c=>c.id===id); if(!it) return;
  it.qty = Math.max(1, it.qty + delta);
  renderCart();
}
function removeItem(id){
  cart = cart.filter(c=>c.id!==id);
  renderCart();
}
function clearCart(){
  cart = [];
  renderCart();
}
function renderCart(){
  const area = document.getElementById('cartArea');
  if(cart.length === 0){
    area.innerHTML = '<div class="center small">Keranjang kosong</div>';
    updateTotals();
    return;
  }
  area.innerHTML = cart.map(i=>`
    <div class="cart-item">
      <div>
        <div><strong>${i.name}</strong></div>
        <div class="small">${rp(i.price)} x ${i.qty} = ${rp(i.price*i.qty)}</div>
      </div>
      <div>
        <button onclick="changeQty(${i.id},-1)">-</button>
        <button onclick="changeQty(${i.id},1)">+</button>
        <button onclick="removeItem(${i.id})" class="secondary" style="margin-left:6px">Hapus</button>
      </div>
    </div>
  `).join('');
  updateTotals();
}
function updateTotals(){
  const subtotal = cart.reduce((s,i)=>s + i.price * i.qty, 0);
  const tax = Math.round(subtotal * 0.10);
  const total = subtotal + tax;
  document.getElementById('subtotal').textContent = rp(subtotal);
  document.getElementById('total').textContent = rp(total);
}

function placeOrder(){
  if(cart.length===0){ alert('Keranjang kosong.'); return; }
  const tableId = document.getElementById('tableSelect').value;
  if(!tableId){ alert('Pilih meja kosong terlebih dahulu.'); return; }
  const table = tables.find(t=>t.id == Number(tableId));
  if(!table || table.is_available !== 1){ alert('Meja tidak tersedia.'); renderTables(); return; }

  const subtotal = cart.reduce((s,i)=>s + i.price * i.qty, 0);
  const tax = Math.round(subtotal * 0.10);
  const total = subtotal + tax;
  const order = {
    id: 'ORD' + Date.now(),
    table_id: table.id,
    table_code: table.code,
    items: cart.map(i=>({menu_id:i.id,name:i.name,price:i.price,qty:i.qty})),
    subtotal, tax, total,
    created_at: new Date().toISOString(),
    status: 'Menunggu'
  };

  saveOrders(order);

  // tandai meja terisi
  table.is_available = 0;
  saveTables();
  renderTables();

  // kosongkan cart
  clearCart();
  alert('Pesanan tersimpan. Kode: ' + order.id + '\nMeja ' + order.table_code + ' ditandai TERISI.');
}

document.getElementById('searchInput').addEventListener('input', ()=> renderMenuGrid());
document.getElementById('categoryFilter').addEventListener('change', ()=> renderMenuGrid());
document.getElementById('confirmBtn').addEventListener('click', ()=> { if(confirm('Konfirmasi pesanan?')) placeOrder(); });
document.getElementById('clearBtn').addEventListener('click', ()=> { if(confirm('Kosongkan keranjang?')) clearCart(); });
document.getElementById('resetTables').addEventListener('click', ()=> { if(confirm('Reset semua meja ke KOSONG (debug)?')) { tables = JSON.parse(JSON.stringify(defaultTables)); saveTables(); renderTables(); alert('Selesai. Meja diset KOSONG.'); } });

function init(){
  loadTables();
  renderCategories();
  renderMenuGrid();
  renderTables();
  renderCart();
}
init();

window.addToCart = addToCart;
window.changeQty = changeQty;
window.removeItem = removeItem;
</script>
</body>
</html>
