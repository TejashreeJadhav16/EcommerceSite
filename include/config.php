<?php
$conn = mysqli_connect("localhost", "root", "", "nidra_homes");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
