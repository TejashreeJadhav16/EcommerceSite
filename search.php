<?php
session_start();
include 'include/db.php'; // your database connection

// Get search query
$search = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Results for "<?php echo htmlspecialchars($search); ?>"</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="css/style.css" rel="stylesheet">
<style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f8f8f8; }
    .search-result { background: #fff; border: 1px solid #ddd; border-radius: 5px; padding: 15px; margin-bottom: 15px; display: flex; gap: 15px; align-items: center; }
    .search-result img { width: 120px; height: 120px; object-fit: cover; border-radius: 5px; }
    .search-result-details { flex: 1; }
    .search-result h3 { margin: 0 0 5px 0; color: #007bff; }
    .search-result p { margin: 0 0 5px 0; color: #555; }
    .search-result .price { font-weight: bold; color: #28a745; margin-top: 5px; }
    .search-result a.cart-btn { display: inline-block; margin-top: 5px; padding: 5px 10px; background: #007bff; color: #fff; border-radius: 3px; text-decoration: none; }
    .search-result a.cart-btn:hover { background: #0056b3; }
</style>
</head>
<body>

<h1>Search Results</h1>
<p>Showing results for: <strong><?php echo htmlspecialchars($search); ?></strong></p>

<?php
if($search != '') {
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $image = !empty($row['image']) ? $row['image'] : 'img/default-product.png';
            $productName = htmlspecialchars($row['name']);
            $productDesc = htmlspecialchars($row['description']);
            $productPrice = number_format($row['price'], 2);
            $productId = $row['id'];

            echo '<div class="search-result">';
            echo '<img src="'.htmlspecialchars($image).'" alt="'.$productName.'">';
            echo '<div class="search-result-details">';
            echo '<h3>'.$productName.'</h3>';
            echo '<p>'.$productDesc.'</p>';
            echo '<p class="price">₹ '.$productPrice.'</p>';
            echo '<a href="cart.php?add='.$productId.'" class="cart-btn"><i class="fa fa-shopping-cart"></i> Add to Cart</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>No products found for "<strong>'.htmlspecialchars($search).'</strong>".</p>';
    }
} else {
    echo '<p>Please enter a search query.</p>';
}

mysqli_close($conn);
?>

</body>
</html>
