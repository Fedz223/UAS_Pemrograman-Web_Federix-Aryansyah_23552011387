<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: /lumiere/login.php");
  exit;
}
