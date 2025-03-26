<?php
session_start();
if (isset($_SESSION['admin'])) {
    echo "Welcome, " . $_SESSION['admin'];
}
?>