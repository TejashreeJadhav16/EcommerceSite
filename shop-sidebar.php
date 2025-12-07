<?php
// Ensure $category is defined by the page (e.g., $category='Bedsheets')
if(!isset($category)) $category = 'Bedsheets';

// Fetch all products for the current category
$query = "SELECT * FROM products WHERE category='$category'";
$result = mysqli_query($conn, $query);

// Arrays to collect filters
$colors = [];
$sizes = [];
$price_ranges = [
    '0-1000' => 0,
    '1001-3000' => 0,
    '3001-5000' => 0,
    '5001-7000' => 0,
    '7001-10000' => 0,
];

$totalProducts = 0;

while($row = mysqli_fetch_assoc($result)) {
    $totalProducts++;

    // Colors
    if(!empty($row['color'])) {
        foreach(explode(',', $row['color']) as $c) {
            $c = trim($c);
            if($c != '') $colors[$c] = ($colors[$c] ?? 0) + 1;
        }
    }

    // Sizes
    if(!empty($row['size'])) {
        foreach(explode(',', $row['size']) as $s) {
            $s = trim($s);
            if($s != '') $sizes[$s] = ($sizes[$s] ?? 0) + 1;
        }
    }

    // Price ranges
    $price = $row['price'];
    if($price <= 1000) $price_ranges['0-1000']++;
    elseif($price <= 3000) $price_ranges['1001-3000']++;
    elseif($price <= 5000) $price_ranges['3001-5000']++;
    elseif($price <= 7000) $price_ranges['5001-7000']++;
    elseif($price <= 10000) $price_ranges['7001-10000']++;
}
?>

<!-- Price Filter -->
<h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by Price</span></h5>
<div class="bg-light p-4 mb-30">
    <form>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" checked id="price-all">
            <label class="custom-control-label" for="price-all">All Prices</label>
            <span class="badge border font-weight-normal"><?= $totalProducts ?></span>
        </div>
        <?php foreach($price_ranges as $range => $count):
            $label = explode('-', $range);
        ?>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" id="price-<?= str_replace('-', '_', $range) ?>">
            <label class="custom-control-label" for="price-<?= str_replace('-', '_', $range) ?>">₹<?= number_format($label[0]) ?> - ₹<?= number_format($label[1]) ?></label>
            <span class="badge border font-weight-normal"><?= $count ?></span>
        </div>
        <?php endforeach; ?>
    </form>
</div>

<!-- Color Filter -->
<h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by Color</span></h5>
<div class="bg-light p-4 mb-30">
    <form>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" checked id="color-all">
            <label class="custom-control-label" for="color-all">All Colors</label>
            <span class="badge border font-weight-normal"><?= array_sum($colors) ?></span>
        </div>
        <?php foreach($colors as $color => $count): ?>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" id="color-<?= strtolower(str_replace(' ', '-', $color)) ?>">
            <label class="custom-control-label" for="color-<?= strtolower(str_replace(' ', '-', $color)) ?>"><?= $color ?></label>
            <span class="badge border font-weight-normal"><?= $count ?></span>
        </div>
        <?php endforeach; ?>
    </form>
</div>

<!-- Size Filter -->
<h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by Size</span></h5>
<div class="bg-light p-4 mb-30">
    <form>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" checked id="size-all">
            <label class="custom-control-label" for="size-all">All Sizes</label>
            <span class="badge border font-weight-normal"><?= array_sum($sizes) ?></span>
        </div>
        <?php foreach($sizes as $size => $count): ?>
        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
            <input type="checkbox" class="custom-control-input" id="size-<?= strtolower($size) ?>">
            <label class="custom-control-label" for="size-<?= strtolower($size) ?>"><?= $size ?></label>
            <span class="badge border font-weight-normal"><?= $count ?></span>
        </div>
        <?php endforeach; ?>
    </form>
</div>
<!-- Shop Sidebar End -->
