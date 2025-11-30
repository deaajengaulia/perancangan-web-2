<?php
// menu.php
$page = 'menu';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menu - DECANA Caffe & Resto</title>

  <style>
    :root{
      --accent-2: #7a4b2b;
      --card-bg: rgba(245,232,218,0.95);
      --max-width: 1200px;
    }

    /* reset */
    *{box-sizing:border-box;margin:0;padding:0}
    html,body{height:100%}
    body{
      font-family: "Poppins", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      color: #222;
      position: relative;
      line-height:1.45;
      min-height:100vh;
      overflow-x:hidden;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      /* gunakan gambar decana2.jpg sebagai background (letakkan di folder yang sama) */
      background: url('decana2.jpg') center/cover no-repeat fixed;
    }

    /* layer untuk membuat background "semu" (blur + tint + opacity) */
    body::before{
      content: "";
      position: fixed;
      inset: 0;
      z-index: -2;
      /* gradient tint untuk nuansa hangat */
      background: linear-gradient(180deg, rgba(0,0,0,0.18), rgba(0,0,0,0.36));
      /* buat efek samar pada gambar di belakang (backdrop pada browser modern) */
      backdrop-filter: blur(4px) saturate(105%);
      -webkit-backdrop-filter: blur(4px) saturate(105%);
    }

    /* overlay ringan tambahan supaya kartu lebih terbaca */
    body::after{
      content: "";
      position: fixed;
      inset: 0;
      z-index: -1;
      background: linear-gradient(180deg, rgba(255,250,243,0.03), rgba(92,61,46,0.06));
      pointer-events:none;
    }

    header{
      background: linear-gradient(90deg, rgba(92,61,46,0.95), rgba(120,70,40,0.95));
      color: #fff;
      text-align:center;
      padding:22px 12px;
      position:relative;
      z-index:1;
      box-shadow: 0 8px 26px rgba(0,0,0,0.35);
    }

    nav{
      margin-top:8px;
    }

    nav a{
      color: white;
      text-decoration: none;
      margin: 0 12px;
      font-weight:600;
    }

    nav a:hover{ text-decoration: underline; }
    nav a.active{ text-decoration: underline; }

    .container{
      max-width: var(--max-width);
      margin: 34px auto;
      padding: 18px;
      position: relative;
      z-index: 1; /* tampil di atas overlay */
    }

    .menu-section{
      padding: 40px 10px;
      margin-bottom: 36px;
    }

    .menu-section h2{
      text-align:center;
      color: #5c3d2e;
      margin-bottom:20px;
      font-size:1.9rem;
      text-shadow: 0 1px 0 rgba(255,255,255,0.3);
    }

    .menu-grid{
      display:grid;
      grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
      gap:22px;
    }

    .menu-item{
      background: var(--card-bg);
      border-radius:14px;
      overflow:hidden;
      text-align:center;
      box-shadow: 0 10px 30px rgba(0,0,0,0.12);
      transition: transform .22s ease, box-shadow .22s ease;
      backdrop-filter: blur(3px);
      -webkit-backdrop-filter: blur(3px);
    }

    .menu-item:hover{
      transform: translateY(-6px);
      box-shadow: 0 18px 40px rgba(0,0,0,0.18);
    }

    .menu-item img{
      width:100%;
      height:180px;
      object-fit:cover;
      display:block;
    }

    .menu-item h3{
      color: #5c3d2e;
      margin:10px 0 6px;
      font-size:1.05rem;
    }

    .menu-item p{
      font-size:0.95rem;
      padding: 0 12px 8px;
      color: #4a3b33;
      line-height:1.35;
    }

    /* Harga: lebih kecil dan tidak tebal */
    .menu-item span{
      display:block;
      font-weight:400;          /* tidak tebal */
      color: rgba(34,34,34,0.78); /* sedikit pudar agar tidak menonjol */
      margin:8px 0 16px;
      font-size:0.80rem;        /* dibuat lebih kecil */
      letter-spacing:0.2px;
    }

    footer{
      background: linear-gradient(90deg, rgba(92,61,46,0.95), rgba(120,70,40,0.95));
      color:#fff;
      text-align:center;
      padding:14px 8px;
      margin-top:18px;
      border-radius:10px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    }

    /* responsive */
    @media (max-width:480px){
      header{ padding:18px 8px; }
      .menu-section{ padding:24px 6px; }
      .menu-item img{ height:150px; }
      .menu-item span{ font-size:0.74rem; }
    }
  </style>
</head>
<body>
  <header>
    <h1>☕ Menu Kopi & Makanan DECANA</h1>
    <nav>
      <a href="index2.php" class="<?php echo ($page === 'home') ? 'active' : ''; ?>">Beranda</a>
      <a href="menu2.php" class="<?php echo ($page === 'menu') ? 'active' : ''; ?>">Menu</a>
      <a href="pemesanan.php" class="<?php echo ($page === 'pemesanan') ? 'active' : ''; ?>">Pemesanan</a>
      <a href="tentang.php" class="<?php echo ($page === 'tentang') ? 'active' : ''; ?>">Tentang Kami</a>
      <a href="bangku.php" class="<?php echo ($page === 'bangku') ? 'active' : ''; ?>">Meja Customers</a>
    </nav>
  </header>

  <div class="container">
    <!-- ========== MENU KOPI ========== -->
    <section class="menu-section">
      <h2>Menu Kopi</h2>
      <div class="menu-grid">
        <div class="menu-item"><img src="espreso.jpeg" alt="Espresso"><h3>Espresso</h3><p>Kopi murni dengan cita rasa pekat dan aroma kuat.</p><span>Rp20.000</span></div>
        <div class="menu-item"><img src="Aericano.jpeg" alt="Americano"><h3>Americano</h3><p>Campuran espresso dengan air panas untuk rasa ringan.</p><span>Rp22.000</span></div>
        <div class="menu-item"><img src="caffe late.jpg" alt="Coffe Latte"><h3>Coffe Latte</h3><p>Kopi susu lembut dengan buih yang creamy.</p><span>Rp25.000</span></div>
        <div class="menu-item"><img src="cappucino.jpg" alt="Cappuccino"><h3>Cappuccino</h3><p>Perpaduan sempurna espresso, susu, dan busa halus.</p><span>Rp27.000</span></div>
        <div class="menu-item"><img src="mocha.jpg" alt="Mocha"><h3>Mocha</h3><p>Kombinasi coklat, kopi, dan susu yang manis.</p><span>Rp28.000</span></div>
        <div class="menu-item"><img src="iced coffe.jpg" alt="Iced Coffee"><h3>Iced Coffee</h3><p>Kopi dingin dengan rasa segar untuk siang hari.</p><span>Rp24.000</span></div>
        <div class="menu-item"><img src="caramel.jpg" alt="Caramel Macchiato"><h3>Caramel Macchiato</h3><p>Rasa manis karamel berpadu lembut dengan espresso.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="affogato.jpg" alt="Affogato"><h3>Affogato</h3><p>Perpaduan es krim vanilla dan espresso hangat.</p><span>Rp32.000</span></div>

        <!-- tambahan menu kopi banyak -->
        <div class="menu-item"><img src="Flat White.jpg" alt="Flat White"><h3>Flat White</h3><p>Espresso dengan susu yang dipanaskan lembut, tekstur halus.</p><span>Rp26.000</span></div>
        <div class="menu-item"><img src="Piccolo Latte.jpg" alt="Piccolo Latte"><h3>Piccolo Latte</h3><p>Mini latte dengan rasa pekat dan creamy.</p><span>Rp24.000</span></div>
        <div class="menu-item"><img src="Long Black.jpg" alt="Long Black"><h3>Long Black</h3><p>Versi Americano dengan body lebih kuat.</p><span>Rp23.000</span></div>
        <div class="menu-item"><img src="Cortado.jpg" alt="Cortado"><h3>Cortado</h3><p>Perpaduan espresso dan sedikit susu untuk rasa seimbang.</p><span>Rp27.000</span></div>
        <div class="menu-item"><img src="Vienna Coffee.jpg" alt="Vienna Coffee"><h3>Vienna Coffee</h3><p>Espresso dengan krim manis di atasnya.</p><span>Rp29.000</span></div>
        <div class="menu-item"><img src="Hazelnut Latte.jpg" alt="Hazelnut Latte"><h3>Hazelnut Latte</h3><p>Latte dengan sirup hazelnut, aroma kacang lembut.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="Salted Caramel Latte.jpg" alt="Salted Caramel Latte"><h3>Salted Caramel Latte</h3><p>Manis gurih karamel dengan sentuhan garam.</p><span>Rp31.000</span></div>
        <div class="menu-item"><img src="Cold Brew.jpg" alt="Cold Brew"><h3>Cold Brew</h3><p>Kopi seduhan dingin dengan rasa halus dan rendah asam.</p><span>Rp28.000</span></div>
        <div class="menu-item"><img src="Nitro Coffee.jpg" alt="Nitro Coffee"><h3>Nitro Coffee</h3><p>Kopi dingin berkarbonasi dengan tekstur creamy tanpa susu.</p><span>Rp35.000</span></div>
        <div class="menu-item"><img src="Irish Coffee.jpg" alt="Irish Coffee"><h3>Irish Coffee</h3><p>Espresso hangat dengan sirup karamel (non-alkohol versi kami).</p><span>Rp36.000</span></div>
      </div>
    </section>

    <!-- ========== MENU NON-KOPI ========== -->
    <section class="menu-section">
      <h2>Minuman Non-Kopi</h2>
      <div class="menu-grid">
        <div class="menu-item"><img src="machalatte.jpg" alt="Matcha Latte"><h3>Matcha Latte</h3><p>Teh hijau dengan susu lembut dan rasa manis alami.</p><span>Rp27.000</span></div>
        <div class="menu-item"><img src="redfelfet latte.jpg" alt="Red Velvet Latte"><h3>Red Velvet Latte</h3><p>Minuman unik dengan rasa coklat dan warna cantik.</p><span>Rp28.000</span></div>
        <div class="menu-item"><img src="hot chocolate.jpg" alt="Hot Chocolate"><h3>Hot Chocolate</h3><p>Cokelat panas yang manis dan menenangkan.</p><span>Rp25.000</span></div>
        <div class="menu-item"><img src="milshake vanila.jpg" alt="Milkshake Vanilla"><h3>Milkshake Vanilla</h3><p>Minuman susu kental manis rasa vanilla lembut.</p><span>Rp26.000</span></div>
        <div class="menu-item"><img src="teh lemon.jpg" alt="Teh Lemon"><h3>Teh Lemon</h3><p>Segarnya teh dingin dengan aroma lemon segar.</p><span>Rp20.000</span></div>
        <div class="menu-item"><img src="gren tee latte.jpg" alt="Green Tea Latte"><h3>Green Tea Latte</h3><p>Campuran teh hijau dan susu yang lembut.</p><span>Rp25.000</span></div>

        <!-- tambahan non-kopi -->
        <div class="menu-item"><img src="Chai Latte.jpg" alt="Chai Latte"><h3>Chai Latte</h3><p>Teh rempah hangat dengan susu, wangi dan nyaman.</p><span>Rp26.000</span></div>
        <div class="menu-item"><img src="Ginger Tea.jpg" alt="Ginger Tea"><h3>Ginger Tea</h3><p>Teh jahe segar, cocok untuk badan hangat.</p><span>Rp18.000</span></div>
        <div class="menu-item"><img src="Homemade Lemonade.jpg" alt="Homemade Lemonade"><h3>Homemade Lemonade</h3><p>Lemon segar, manis seimbang, menyegarkan.</p><span>Rp22.000</span></div>
        <div class="menu-item"><img src="Mango Smoothie.jpg" alt="Mango Smoothie"><h3>Mango Smoothie</h3><p>Buah mangga asli di-blend dengan susu atau yoghurt.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="Iced Peach Tea.jpg" alt="Iced Peach Tea"><h3>Iced Peach Tea</h3><p>Teh buah persik dingin, manis dan harum.</p><span>Rp22.000</span></div>
        <div class="menu-item"><img src="Sparkling Berry.jpg" alt="Sparkling Berry"><h3>Sparkling Berry</h3><p>Minuman soda ringan dengan campuran berry segar.</p><span>Rp29.000</span></div>
        <div class="menu-item"><img src="Vanilla Latte (Non-Coffee).jpg" alt="Vanilla Latte (Non-Coffee)"><h3>Vanilla Latte (Non-Coffee)</h3><p>Versi susu vanilla hangat tanpa kopi (decaf style).</p><span>Rp24.000</span></div>
      </div>
    </section>

    <!-- ========== MAKANAN BERAT ========== -->
    <section class="menu-section">
      <h2>Makanan Berat</h2>
      <div class="menu-grid">
        <div class="menu-item"><img src="nasi goreng spesial.jpg" alt="Nasi Goreng Spesial"><h3>Nasi Goreng Spesial</h3><p>Dilengkapi ayam, telur, dan kerupuk renyah.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="mie goreng jawaa.jpg" alt="Mie Goreng Jawa"><h3>Mie Goreng Jawa</h3><p>Mie tradisional dengan bumbu khas pedas manis.</p><span>Rp28.000</span></div>
        <div class="menu-item"><img src="sop iga sapi.jpg" alt="Sop Iga Sapi"><h3>Sop Iga Sapi</h3><p>Daging iga empuk dalam kuah gurih menggugah selera.</p><span>Rp45.000</span></div>
        <div class="menu-item"><img src="chicken steak.jpg" alt="Chicken Steak"><h3>Chicken Steak</h3><p>Dada ayam panggang dengan saus lada hitam.</p><span>Rp40.000</span></div>
        <div class="menu-item"><img src="pasta carbonara.jpg" alt="Pasta Carbonara"><h3>Pasta Carbonara</h3><p>Spaghetti creamy dengan saus keju dan jamur.</p><span>Rp35.000</span></div>
        <div class="menu-item"><img src="Grilled Salmon.jpg" alt="Grilled Salmon"><h3>Grilled Salmon</h3><p>Ikan salmon panggang dengan lemon dan butter.</p><span>Rp55.000</span></div>

        <!-- tambahan makanan berat -->
        <div class="menu-item"><img src="Beef Burger.jpg" alt="Beef Burger"><h3>Beef Burger</h3><p>Patty sapi tebal dengan sayur segar dan saus spesial.</p><span>Rp38.000</span></div>
        <div class="menu-item"><img src="Ribeye Steak.jpg" alt="Ribeye Steak"><h3>Ribeye Steak</h3><p>Steak premium dengan saus jamur, pilihan medium-rare.</p><span>Rp85.000</span></div>
        <div class="menu-item"><img src="Nasi Campur DECANA.jpg" alt="Nasi Campur DECANA"><h3>Nasi Campur DECANA</h3><p>Campuran lauk lokal pilihan, cocok untuk makan berat.</p><span>Rp33.000</span></div>
        <div class="menu-item"><img src="Chicken Caesar Salad.jpg" alt="Chicken Caesar Salad"><h3>Chicken Caesar Salad</h3><p>Salad segar dengan ayam panggang dan saus caesar.</p><span>Rp32.000</span></div>
        <div class="menu-item"><img src="Fish & Chips.jpg" alt="Fish & Chips"><h3>Fish & Chips</h3><p>Potongan ikan tepung renyah disajikan dengan kentang goreng.</p><span>Rp36.000</span></div>
        <div class="menu-item"><img src="Ramen Spesial.jpg" alt="Ramen Spesial"><h3>Ramen Spesial</h3><p>Mie kaldu kental dengan topping telur dan daging.</p><span>Rp40.000</span></div>
      </div>
    </section>

    <!-- ========== MAKANAN RINGAN & DESSERT ========== -->
    <section class="menu-section">
      <h2>Makanan Ringan & Dessert</h2>
      <div class="menu-grid">
        <div class="menu-item"><img src="donat coklat.jpg" alt="Donat Cokelat"><h3>Donat Cokelat</h3><p>Donat lembut dengan topping cokelat premium.</p><span>Rp15.000</span></div>
        <div class="menu-item"><img src="Cheesecake.jpg" alt="Cheesecake"><h3>Cheesecake</h3><p>Kue keju lembut dengan rasa manis seimbang.</p><span>Rp25.000</span></div>
        <div class="menu-item"><img src="Brownies Panggang.jpg" alt="Brownies Panggang"><h3>Brownies Panggang</h3><p>Brownies cokelat klasik dengan tekstur fudgy.</p><span>Rp20.000</span></div>
        <div class="menu-item"><img src="Croissant Butter.jpg" alt="Croissant Butter"><h3>Croissant Butter</h3><p>Roti lapis lembut dengan aroma butter yang harum.</p><span>Rp18.000</span></div>
        <div class="menu-item"><img src="French Fries.jpg" alt="French Fries"><h3>French Fries</h3><p>Kentang goreng renyah dengan saus pilihan.</p><span>Rp17.000</span></div>
        <div class="menu-item"><img src="pancake.jpg" alt="Pancake Maple"><h3>Pancake Maple</h3><p>Pancake lembut disajikan dengan madu maple asli.</p><span>Rp22.000</span></div>

        <!-- tambahan dessert & snack -->
        <div class="menu-item"><img src="Waffle Berry.jpg" alt="Waffle Berry"><h3>Waffle Berry</h3><p>Waffle hangat disajikan dengan berry dan cream.</p><span>Rp28.000</span></div>
        <div class="menu-item"><img src="Tiramisu.jpg" alt="Tiramisu"><h3>Tiramisu</h3><p>Classic tiramisu lembut dengan rasa kopi halus.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="Ice Cream Sundae.jpg" alt="Ice Cream Sundae"><h3>Ice Cream Sundae</h3><p>Es krim dengan topping cokelat, kacang, dan saus.</p><span>Rp24.000</span></div>
        <div class="menu-item"><img src="Banana Foster.jpg" alt="Banana Foster"><h3>Banana Foster</h3><p>Pisang karamel disajikan hangat dengan vanilla.</p><span>Rp27.000</span></div>
        <div class="menu-item"><img src="Chocolate Chip Cookies.jpg" alt="Chocolate Chip Cookies"><h3>Chocolate Chip Cookies</h3><p>Cookies renyah dengan potongan cokelat pekat.</p><span>Rp12.000</span></div>
        <div class="menu-item"><img src="Fruit Salad.jpg" alt="Fruit Salad"><h3>Fruit Salad</h3><p>Campuran buah segar dipotong rapi, sehat dan segar.</p><span>Rp20.000</span></div>
        <div class="menu-item"><img src="Donat Isi Custard.jpg" alt="Donat Isi Custard"><h3>Donat Isi Custard</h3><p>Donat lembut berisi vanilla custard.</p><span>Rp18.000</span></div>
      </div>
    </section>

    <!-- ========== TAMBAHAN MENU KOPI ========== -->
    <section class="menu-section">
      <h2>Menu Kopi Spesial Lainnya</h2>
      <div class="menu-grid">
        <div class="menu-item"><img src="Cappuccino Signature.jpg" alt="Cappuccino Signature"><h3>Cappuccino Signature</h3><p>Cappuccino premium khas DECANA dengan foam tebal dan rasa bold.</p><span>Rp33.000</span></div>
        <div class="menu-item"><img src="Espresso Con Panna.jpg" alt="Espresso Con Panna"><h3>Espresso Con Panna</h3><p>Espresso disajikan dengan whipped cream di atasnya.</p><span>Rp32.000</span></div>
        <div class="menu-item"><img src="Macchiato.jpg" alt="Macchiato"><h3>Macchiato</h3><p>Espresso pekat dengan sedikit busa susu, rasa klasik Italia.</p><span>Rp28.000</span></div>
        <div class="menu-item"><img src="Iced Caramel Latte.jpg" alt="Iced Caramel Latte"><h3>Iced Caramel Latte</h3><p>Campuran espresso, susu dingin, dan sirup karamel manis.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="Mocha Frappe.jpg" alt="Mocha Frappe"><h3>Mocha Frappe</h3><p>Minuman blended es kopi coklat lembut dan segar.</p><span>Rp34.000</span></div>
        <div class="menu-item"><img src="Iced Hazelnut Coffee.jpg" alt="Iced Hazelnut Coffee"><h3>Iced Hazelnut Coffee</h3><p>Kopi dingin dengan sirup hazelnut dan susu.</p><span>Rp33.000</span></div>
        <div class="menu-item"><img src="Double Espresso.jpg" alt="Double Espresso"><h3>Double Espresso</h3><p>Dua shot espresso untuk penikmat rasa kopi sejati.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="Kopi Tubruk.jpg" alt="Kopi Tubruk"><h3>Kopi Tubruk</h3><p>Kopi tradisional Indonesia dengan aroma khas nusantara.</p><span>Rp15.000</span></div>
      </div>
    </section>

    <!-- ========== TAMBAHAN MINUMAN NON-KOPI ========== -->
    <section class="menu-section">
      <h2>Minuman Segar & Non-Kopi Tambahan</h2>
      <div class="menu-grid">
        <div class="menu-item"><img src="Strawberry Smoothie.jpg" alt="Strawberry Smoothie"><h3>Strawberry Smoothie</h3><p>Minuman segar dari buah stroberi asli dan susu.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="Blueberry Smoothie.jpg" alt="Blueberry Smoothie"><h3>Blueberry Smoothie</h3><p>Campuran blueberry, madu, dan susu lembut.</p><span>Rp32.000</span></div>
        <div class="menu-item"><img src="Chocolate Milkshake.jpg" alt="Chocolate Milkshake"><h3>Chocolate Milkshake</h3><p>Milkshake coklat kental dengan whipped cream.</p><span>Rp28.000</span></div>
        <div class="menu-item"><img src="Avocado Float.jpg" alt="Avocado Float"><h3>Avocado Float</h3><p>Jus alpukat dengan topping es krim coklat.</p><span>Rp33.000</span></div>
        <div class="menu-item"><img src="Thai Tea.jpg" alt="Thai Tea"><h3>Thai Tea</h3><p>Teh Thailand manis dengan susu kental yang creamy.</p><span>Rp25.000</span></div>
        <div class="menu-item"><img src="Tropical Punch.jpg" alt="Tropical Punch"><h3>Tropical Punch</h3><p>Campuran berbagai buah tropis segar dengan soda.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="Lychee Tea.jpg" alt="Lychee Tea"><h3>Lychee Tea</h3><p>Teh manis dengan potongan buah leci segar.</p><span>Rp24.000</span></div>
        <div class="menu-item"><img src="Honey Lemon Tea.jpg" alt="Honey Lemon Tea"><h3>Honey Lemon Tea</h3><p>Teh lemon dengan tambahan madu alami.</p><span>Rp23.000</span></div>
      </div>
    </section>

    <!-- ========== TAMBAHAN MAKANAN BERAT ========== -->
    <section class="menu-section">
      <h2>Makanan Berat Tambahan</h2>
      <div class="menu-grid">
        <div class="menu-item"><img src="Beef Teriyaki Rice.jpg" alt="Beef Teriyaki Rice"><h3>Beef Teriyaki Rice</h3><p>Daging sapi lembut dengan saus teriyaki gurih manis.</p><span>Rp42.000</span></div>
        <div class="menu-item"><img src="Chicken Katsu Rice.jpg" alt="Chicken Katsu Rice"><h3>Chicken Katsu Rice</h3><p>Ayam crispy dengan saus khas Jepang dan nasi hangat.</p><span>Rp38.000</span></div>
        <div class="menu-item"><img src="Spaghetti Bolognese.jpg" alt="Spaghetti Bolognese"><h3>Spaghetti Bolognese</h3><p>Pasta saus tomat daging cincang ala Italia.</p><span>Rp36.000</span></div>
        <div class="menu-item"><img src="Seafood Fried Rice.jpg" alt="Seafood Fried Rice"><h3>Seafood Fried Rice</h3><p>Nasi goreng dengan udang, cumi, dan bumbu khas.</p><span>Rp40.000</span></div>
        <div class="menu-item"><img src="Chicken Teriyaki Bowl.jpg" alt="Chicken Teriyaki Bowl"><h3>Chicken Teriyaki Bowl</h3><p>Potongan ayam manis gurih di atas nasi Jepang.</p><span>Rp37.000</span></div>
        <div class="menu-item"><img src="Spaghetti Aglio Olio.jpg" alt="Spaghetti Aglio Olio"><h3>Spaghetti Aglio Olio</h3><p>Pasta sederhana dengan minyak zaitun, cabai, dan bawang.</p><span>Rp34.000</span></div>
        <div class="menu-item"><img src="Beef Stroganoff.jpg" alt="Beef Stroganoff"><h3>Beef Stroganoff</h3><p>Masakan daging sapi lembut dengan saus krim jamur.</p><span>Rp50.000</span></div>
        <div class="menu-item"><img src="Fried Chicken Deluxe.jpg" alt="Fried Chicken Deluxe"><h3>Fried Chicken Deluxe</h3><p>Ayam goreng tepung renyah dengan saus pedas manis.</p><span>Rp35.000</span></div>
      </div>
    </section>

    <!-- ========== TAMBAHAN DESSERT & SNACK ========== -->
    <section class="menu-section">
      <h2>Dessert & Snack Tambahan</h2>
      <div class="menu-grid">
        <div class="menu-item"><img src="Cinnamon Roll.jpg" alt="Cinnamon Roll"><h3>Cinnamon Roll</h3><p>Roti gulung kayu manis dengan glaze manis di atasnya.</p><span>Rp22.000</span></div>
        <div class="menu-item"><img src="Chocolate Lava Cake.jpg" alt="Chocolate Lava Cake"><h3>Chocolate Lava Cake</h3><p>Kue coklat panas dengan lelehan coklat di tengahnya.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="Oreo Cheesecake.jpg" alt="Oreo Cheesecake"><h3>Oreo Cheesecake</h3><p>Cheesecake lembut dengan taburan remah oreo.</p><span>Rp28.000</span></div>
        <div class="menu-item"><img src="Mini Churros.jpg" alt="Mini Churros"><h3>Mini Churros</h3><p>Camilan goreng tabur gula dan saus coklat.</p><span>Rp20.000</span></div>
        <div class="menu-item"><img src="Mozzarella Sticks.jpg" alt="Mozzarella Sticks"><h3>Mozzarella Sticks</h3><p>Keju mozzarella goreng dengan saus marinara.</p><span>Rp25.000</span></div>
        <div class="menu-item"><img src="Garlic Bread.jpg" alt="Garlic Bread"><h3>Garlic Bread</h3><p>Roti panggang dengan mentega dan bawang putih harum.</p><span>Rp18.000</span></div>
        <div class="menu-item"><img src="Pudding Caramel.jpg" alt="Pudding Caramel"><h3>Pudding Caramel</h3><p>Puding lembut dengan lapisan saus karamel manis.</p><span>Rp19.000</span></div>
        <div class="menu-item"><img src="Mango Pudding.jpg" alt="Mango Pudding"><h3>Mango Pudding</h3><p>Puding buah mangga segar yang lembut dan harum.</p><span>Rp20.000</span></div>
      </div>
    </section>

    <!-- ========== MENU ANAK & KELUARGA ========== -->
    <section class="menu-section">
      <h2>Menu Anak & Keluarga</h2>
      <div class="menu-grid">
        <div class="menu-item"><img src="Mini Pancake Kids.jpg" alt="Mini Pancake Kids"><h3>Mini Pancake Kids</h3><p>Pancake mini lucu dengan topping madu dan buah segar.</p><span>Rp20.000</span></div>
        <div class="menu-item"><img src="Mac and Cheese.jpg" alt="Mac and Cheese"><h3>Mac and Cheese</h3><p>Pasta lembut dengan saus keju kental favorit anak-anak.</p><span>Rp25.000</span></div>
        <div class="menu-item"><img src="Chicken Nugget Set.jpg" alt="Chicken Nugget Set"><h3>Chicken Nugget Set</h3><p>Nugget ayam renyah dengan kentang dan saus tomat.</p><span>Rp22.000</span></div>
        <div class="menu-item"><img src="Mini Pizza.jpg" alt="Mini Pizza"><h3>Mini Pizza</h3><p>Piza ukuran kecil dengan topping keju dan sosis ayam.</p><span>Rp28.000</span></div>
        <div class="menu-item"><img src="Family Platter.jpg" alt="Family Platter"><h3>Family Platter</h3><p>Porsi besar berisi ayam, sosis, kentang, dan salad untuk keluarga.</p><span>Rp85.000</span></div>
      </div>
    </section>

    <!-- ========== MINUMAN SIGNATURE ========== -->
    <section class="menu-section">
      <h2>Minuman Signature</h2>
      <div class="menu-grid">
        <div class="menu-item"><img src="Cappuccino Signature.jpg" alt="Cappuccino Signature"><h3>Cappuccino Signature</h3><p>Kopi cappuccino khas DECANA dengan sentuhan rempah rahasia.</p><span>Rp33.000</span></div>
        <div class="menu-item"><img src="Es Kopi Gula Aren.jpg" alt="Es Kopi Gula Aren"><h3>Es Kopi Gula Aren</h3><p>Espresso dingin dengan susu segar dan gula aren asli.</p><span>Rp30.000</span></div>
        <div class="menu-item"><img src="Tropical Smoothie.jpg" alt="Tropical Smoothie"><h3>Tropical Smoothie</h3><p>Campuran buah mangga, nanas, dan jeruk segar.</p><span>Rp27.000</span></div>
        <div class="menu-item"><img src="Mojito Lemon Mint.jpg" alt="Mojito Lemon Mint"><h3>Mojito Lemon Mint</h3><p>Minuman soda segar dengan daun mint dan lemon.</p><span>Rp25.000</span></div>
        <div class="menu-item"><img src="Avocado Coffee.jpg" alt="Avocado Coffee"><h3>Avocado Coffee</h3><p>Perpaduan alpukat, susu, dan espresso, creamy dan unik.</p><span>Rp35.000</span></div>
        <div class="menu-item"><img src="Coconut Latte.jpg" alt="Coconut Latte"><h3>Coconut Latte</h3><p>Kopi susu dengan rasa kelapa khas tropis.</p><span>Rp32.000</span></div>
        <div class="menu-item"><img src="Blue Ocean Soda.jpg" alt="Blue Ocean Soda"><h3>Blue Ocean Soda</h3><p>Minuman bersoda warna biru segar dengan aroma citrus.</p><span>Rp23.000</span></div>
        <div class="menu-item"><img src="Honey Lemon Tea.jpg" alt="Honey Lemon Tea"><h3>Honey Lemon Tea</h3><p>Teh madu lemon hangat yang menenangkan tenggorokan.</p><span>Rp20.000</span></div>
      </div>
    </section>

    <footer>
      <p>© <?php echo date('Y'); ?> DECANA Caffe & Resto | Semua Hak Dilindungi</p>
    </footer>
  </div>
</body>
</html>
