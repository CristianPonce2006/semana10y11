<?php
session_start();
session_unset();
session_destroy();
header('Location: ../index.php?mensaje=Sesión cerrada correctamente');
exit;