<?php
include('../include/db.php'); // Database connection

// Check if 'id' is provided
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare statement to delete product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        // Successfully deleted
        $stmt->close();
        header("Location: products.php?msg=deleted"); // Redirect to products page with success message
        exit();
    } else {
        // Error deleting
        echo "Error deleting product: " . $stmt->error;
    }
} else {
    echo "Invalid product ID.";
}
?>
