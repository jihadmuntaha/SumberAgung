<?php
session_start();
if (!isset($_SESSION['admin'])) header("Location: login.php");
include '../backend/koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM menu WHERE id=$id");
header("Location: dashboard.php");
?>
