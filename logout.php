<?php

include "config.php";
unset($_SESSION["autenticado"]); //destruir
unset($_SESSION["user"]);//destruir por segurança
session_destroy();
header("Location: index.php");