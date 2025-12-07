<?php
session_start();
include("include/db.php");

// ✅ Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=wishlist");
    exit;
}
$user_id = $_SESSION['user_id'];

// ✅ ADD to wishlist
if (isset($_GET['add'])) {
    $product_id = (int)$_GET['add'];

    // Check if already in wishlist
    $check = $conn->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows === 0) {
        // Insert new wishlist item
        $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $stmt->close();
    }
    $check->close();

    header("Location: wishlist.php");
    exit;
}

// ✅ REMOVE from wishlist
if (isset($_GET['remove'])) {
    $wishlist_id = (int)$_GET['remove'];
    $stmt = $conn->prepare("DELETE FROM wishlist WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $wishlist_id, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: wishlist.php");
    exit;
}

// If no action, just redirect back
header("Location: wishlist.php");
exit;
