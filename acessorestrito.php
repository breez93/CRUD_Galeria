<?php

//proteção para páginas de acesso restrito
if (!isset($_SESSION["user"]) or $_SESSION["autenticado"]!=1) {
    header("Location: index.php?erro=-1");
    exit();
}
