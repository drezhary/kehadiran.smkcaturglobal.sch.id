<?php
session_start();

// Hapus session dan redirect ke halaman login
session_unset();
session_destroy();
header('Location: ../index.php');
exit();
