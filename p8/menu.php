<?php // menu_paginated_by_category.php
include "koneksi.php";

/* ========================== Helper: build extra GET params Exclude given keys (array) ========================== */
function build_extra_params_general($exclude_keys = []) {
    $params = "";
    foreach ($_GET as $k => $v) {
        if (in_array($k, $exclude_keys, true)) continue;
        $params .= "&" . urlencode($k) . "=" . urlencode($v);
    }
    return $params;
}

/* ========================== Helper: gambar path ========================== */
function gambar_path($g) {
    if (!empty($g) && file_exists(__DIR__ . '/' . $g)) return $g;
    if (!empty($g) && file_exists(__DIR__ . '/uploads/' . $g)) return 'uploads/' . $g;
    return file_exists(__DIR__ . '/uploads/default.jpg') ? 'uploads/default.jpg' : '';
}

/* ========================== Pagination renderer for N buttons (always clickable)
   - $param_name : GET parameter to use for page for this block (e.g. pn_cat5)
   - $current_pn : current page number for this block
   - $per_page : rows per page used to compute last
   - $total_rows : total rows in this category
   - $buttons : number of page buttons to show (here 5)
========================== */
function render_pagination_forceN($param_name, $current_pn, $per_page, $total_rows, $buttons = 5) {
    $last = (int)ceil($total_rows / $per_page);
    if ($last < 1) $last = 1;
    $pn = (int)$current_pn;
    if ($pn < 1) $pn = 1;

    // build extra GET params but exclude this param (we'll add it to links)
    $extra = build_extra_params_general([$param_name]);

    $html = '<ul class="pagination">';

    // prev
    if ($pn > 1) {
        $prev = $pn - 1;
        $html .= '<li><a href="?'.htmlspecialchars($param_name).'='.$prev.$extra.'">&laquo;</a></li>';
    } else {
        $html .= '<li class="disabled"><a>&laquo;</a></li>';
    }

    // sliding window centered on current page when possible
    $half = (int)floor($buttons / 2);
    $start = $pn - $half;
    if ($start < 1) $start = 1;
    $end = $start + $buttons - 1;

    // ensure we keep exactly $buttons in range (even if beyond last)
    // do not clamp by $last so pages beyond last remain clickable (open empty)
    for ($i = $start; $i <= $end; $i++) {
        if ($i == $pn) {
            $html .= '<li class="active"><a>'.htmlspecialchars($i).'</a></li>';
        } else {
            $html .= '<li><a href="?'.htmlspecialchars($param_name).'='.$i.$extra.'">'.htmlspecialchars($i).'</a></li>';
        }
    }

    // next (always allowed)
    $next = $pn + 1;
    $html .= '<li><a href="?'.htmlspecialchars($param_name).'='.$next.$extra.'">&raquo;</a></li>';

    $html .= '</ul>';
    return $html;
}

/* ========================== Ambil daftar kategori (jika ada) ========================== */
$categories = [];
$chk = @mysqli_query($koneksi, "SHOW TABLES LIKE 'kategori'");
if ($chk && mysqli_num_rows($chk) > 0) {
    $q = mysqli_query($koneksi, "SELECT id_kategori, nama_kategori FROM kategori ORDER BY nama_kategori");
    if ($q) {
        while ($r = mysqli_fetch_assoc($q)) $categories[] = $r;
        mysqli_free_result($q);
    }
}
if ($chk) mysqli_free_result($chk);

/* ========================== Jika user memilih filter single category -> tampilkan mode lama (semua menu pada 1 daftar) ========================== */
$filter_cat = (isset($_GET['cat']) && $_GET['cat'] !== "") ? (int)$_GET['cat'] : null;

if ($filter_cat !== null) {
    // --- existing single-list behaviour (preserve previous logic) ---
    // hitung total sesuai filter
    $stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) AS c FROM menu WHERE id_kategori = ?");
    if (!$stmt) die("Prepare failed: " . mysqli_error($koneksi));
    mysqli_stmt_bind_param($stmt, "i", $filter_cat);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $total = (int)mysqli_fetch_assoc($res)['c'];
    if ($res) mysqli_free_result($res);

    // limit from GET pn & ps (allow pn > last)
    $page_rows = isset($_GET['ps']) ? (int)$_GET['ps'] : 10;
    if ($page_rows < 1) $page_rows = 10;
    $pagenum = isset($_GET['pn']) ? (int)$_GET['pn'] : 1;
    if ($pagenum < 1) $pagenum = 1;
    $offset = ($pagenum - 1) * $page_rows;

    $sql = "SELECT * FROM menu WHERE id_kategori = ? ORDER BY id_menu DESC LIMIT ?, ?";
    $stmt2 = mysqli_prepare($koneksi, $sql);
    if (!$stmt2) die("Prepare failed: " . mysqli_error($koneksi));
    mysqli_stmt_bind_param($stmt2, "iii", $filter_cat, $offset, $page_rows);
    mysqli_stmt_execute($stmt2);
    $res2 = mysqli_stmt_get_result($stmt2);
    $menus = [];
    while ($row = mysqli_fetch_assoc($res2)) $menus[] = $row;
    mysqli_stmt_close($stmt2);
    if ($res2) mysqli_free_result($res2);

    // render single list HTML (reuse part of template below)
    $single_view = true;
} else {
    $single_view = false;
}

/* ========================== HTML output ========================== */
?><!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Menu - DECANA Caffe & Resto</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css">
<style>
:root{--card-bg:rgba(245,232,218,0.95);--max-width:1200px}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:"Poppins",system-ui,Arial;background:#f7f2ee;color:#222;line-height:1.45}
.container{max-width:var(--max-width);margin:28px auto;padding:18px}
.header{background:#7a4b2b;color:#fff;padding:18px;border-radius:8px;text-align:center;margin-bottom:18px}
.section{margin-bottom:26px}
.section h2{color:#5c3d2e;text-align:center;margin-bottom:12px}
.menu-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:18px}
.menu-item{background:var(--card-bg);border-radius:12px;overflow:hidden;text-align:center;padding-bottom:8px;box-shadow:0 8px 20px rgba(0,0,0,0.08)}
.menu-item img{width:100%;height:170px;object-fit:cover;display:block}
.menu-item h3{margin:10px 0 6px;color:#5c3d2e}
.menu-item p{padding:0 12px 8px;color:#4a3b33;font-size:.95rem;min-height:48px}
.menu-item span{display:block;margin-top:6px;color:rgba(34,34,34,.78);font-size:.9rem}
.cat-title{margin:6px 0 18px;text-align:center;color:#6b4f3f;font-weight:600}
.footer{margin-top:18px;padding:12px;text-align:center;background:#7a4b2b;color:#fff;border-radius:8px}
.pagination-controls{margin:18px 0;text-align:center}
.pagination{display:inline-block;padding-left:0;margin:0;border-radius:4px}
.pagination li{display:inline}
.pagination li a{color:#337ab7;padding:6px 10px;text-decoration:none;border:1px solid #ddd;margin-left:-1px;background:#fff}
.pagination li a:hover{background:#eee}
.pagination li.active a{background:#337ab7;color:#fff;border-color:#337ab7}
.pagination li.disabled a{color:#999;background:#f9f9f9;border-color:#eee;pointer-events:none}
@media(max-width:480px){.menu-item img{height:140px}}
.category-block{margin-bottom:28px;padding:12px;background:rgba(255,255,255,0.6);border-radius:10px}
.category-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px}
.category-header h3{margin:0}
</style>
</head>
<body>
<div class="container">
    <div class="header"><h1>☕ Menu Kopi & Makanan DECANA</h1></div>

    <!-- Filter & Rows per page (only used in single-view) -->
    <div class="row" style="margin-bottom:12px;align-items:center">
        <div class="col-sm-8">
            <form method="get" id="filterForm" class="form-inline">
                <label for="cat">Kategori:&nbsp;</label>
                <select name="cat" id="cat" class="form-control" onchange="document.getElementById('filterForm').submit()">
                    <option value="">-- Semua Kategori --</option>
                    <?php foreach($categories as $c): ?>
                        <option value="<?php echo (int)$c['id_kategori']; ?>" <?php if ($filter_cat === (int)$c['id_kategori']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($c['nama_kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                &nbsp;&nbsp;
                <label>Rows:&nbsp;</label>
                <select name="ps" onchange="document.getElementById('filterForm').submit()" class="form-control">
                    <option value="10"<?php if ((!isset($_GET['ps']) && 10==10) || (isset($_GET['ps']) && (int)$_GET['ps']==10)) echo ' selected'; ?>>10</option>
                    <option value="25"<?php if (isset($_GET['ps']) && (int)$_GET['ps']==25) echo ' selected'; ?>>25</option>
                    <option value="50"<?php if (isset($_GET['ps']) && (int)$_GET['ps']==50) echo ' selected'; ?>>50</option>
                </select>

                <?php // preserve non-filter params ?>
                <?php foreach ($_GET as $k => $v) {
                    if (in_array($k, ['cat','ps','pn'])) continue; // also skip per-category pn params to avoid accidental carry when switching filters
                    if (preg_match('/^pn_cat\d+$/', $k)) continue;
                    echo '<input type="hidden" name="'.htmlspecialchars($k).'" value="'.htmlspecialchars($v).'">';
                } ?>
            </form>
        </div>

        <div class="col-sm-4 text-right small">
            <?php if ($single_view): ?>
                Halaman <strong><?php echo (isset($_GET['pn']) ? (int)$_GET['pn'] : 1); ?></strong> dari <strong><?php echo max(1, (int)ceil($total / (isset($_GET['ps']) ? max(1,(int)$_GET['ps']) : 10))); ?></strong> — Total menu: <strong><?php echo $total; ?></strong>
            <?php else: ?>
                Menampilkan setiap kategori dengan maksimal <strong>8</strong> item per halaman kategori.
            <?php endif; ?>
        </div>
    </div>

    <!-- SINGLE CATEGORY VIEW (filter applied) -->
    <?php if ($single_view): ?>
        <section class="section">
            <?php if (empty($menus)): ?>
                <p style="text-align:center;color:#6b5146">Belum ada menu pada pilihan ini. <a href="tambah_menu.php">Tambah menu</a>.</p>
            <?php else: ?>
                <div class="menu-grid">
                    <?php foreach($menus as $m): $img = gambar_path($m['gambar'] ?? ''); ?>
                        <div class="menu-item" role="article">
                            <?php if ($img): ?>
                                <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($m['nama_menu'] ?? 'Menu'); ?>">
                            <?php else: ?>
                                <div style="height:170px;display:flex;align-items:center;justify-content:center;color:#8a6b5b">No image</div>
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($m['nama_menu'] ?? '-'); ?></h3>
                            <p><?php echo htmlspecialchars($m['deskripsi'] ?? '-'); ?></p>
                            <span>Rp<?php echo number_format((float)($m['harga'] ?? 0),0,',','.'); ?> — <?php echo htmlspecialchars($m['status'] ?? ''); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="pagination-controls">
                    <?php // reuse render_pagination_forceN but for single view use param "pn"
                    echo render_pagination_forceN('pn', isset($_GET['pn']) ? (int)$_GET['pn'] : 1, isset($_GET['ps']) ? max(1,(int)$_GET['ps']) : 10, $total, 10); ?>
                </div>
            <?php endif; ?>
        </section>

    <!-- MULTI-CATEGORY VIEW (default): display each category block with its own pagination (8 per page, 5 buttons) -->
    <?php else: ?>
        <?php foreach ($categories as $c): 
            $cid = (int)$c['id_kategori'];
            // per-category rows fixed to 8
            $per_cat = 8;
            $param_name = 'pn_cat' . $cid;
            $pagenum = isset($_GET[$param_name]) ? (int)$_GET[$param_name] : 1;
            if ($pagenum < 1) $pagenum = 1;
            $offset = ($pagenum - 1) * $per_cat;

            // count total for category
            $stmtc = mysqli_prepare($koneksi, "SELECT COUNT(*) AS c FROM menu WHERE id_kategori = ?");
            if (!$stmtc) {
                $total_cat = 0;
            } else {
                mysqli_stmt_bind_param($stmtc, "i", $cid);
                mysqli_stmt_execute($stmtc);
                $resc = mysqli_stmt_get_result($stmtc);
                $total_cat = (int)mysqli_fetch_assoc($resc)['c'];
                if ($resc) mysqli_free_result($resc);
                mysqli_stmt_close($stmtc);
            }

            // fetch items for this category with limit
            $items = [];
            $sql = "SELECT * FROM menu WHERE id_kategori = ? ORDER BY id_menu DESC LIMIT ?, ?";
            $stmti = mysqli_prepare($koneksi, $sql);
            if ($stmti) {
                mysqli_stmt_bind_param($stmti, "iii", $cid, $offset, $per_cat);
                mysqli_stmt_execute($stmti);
                $rsti = mysqli_stmt_get_result($stmti);
                while ($row = mysqli_fetch_assoc($rsti)) $items[] = $row;
                if ($rsti) mysqli_free_result($rsti);
                mysqli_stmt_close($stmti);
            }
        ?>
            <div class="category-block">
                <div class="category-header">
                    <h3 class="cat-title"><?php echo htmlspecialchars($c['nama_kategori']); ?></h3>
                    <div class="small">
                        <?php echo $total_cat; ?> item(s) &nbsp;|&nbsp; <a href="?cat=<?php echo $cid; ?>">Lihat semua</a>
                    </div>
                </div>

                <?php if (empty($items)): ?>
                    <p style="text-align:center;color:#6b5146">Belum ada menu pada kategori ini.</p>
                <?php else: ?>
                    <div class="menu-grid">
                        <?php foreach ($items as $m): $img = gambar_path($m['gambar'] ?? ''); ?>
                            <div class="menu-item" role="article">
                                <?php if ($img): ?>
                                    <img src="<?php echo htmlspecialchars($img); ?>" alt="<?php echo htmlspecialchars($m['nama_menu'] ?? 'Menu'); ?>">
                                <?php else: ?>
                                    <div style="height:170px;display:flex;align-items:center;justify-content:center;color:#8a6b5b">No image</div>
                                <?php endif; ?>
                                <h3><?php echo htmlspecialchars($m['nama_menu'] ?? '-'); ?></h3>
                                <p><?php echo htmlspecialchars($m['deskripsi'] ?? '-'); ?></p>
                                <span>Rp<?php echo number_format((float)($m['harga'] ?? 0),0,',','.'); ?> — <?php echo htmlspecialchars($m['status'] ?? ''); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="pagination-controls">
                    <?php // render 5 buttons per category, param name pn_cat{id}
                    echo render_pagination_forceN($param_name, $pagenum, $per_cat, $total_cat, 5); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="footer">© <?php echo date('Y'); ?> DECANA Caffe & Resto</div>
</div>
</body>
</html>
