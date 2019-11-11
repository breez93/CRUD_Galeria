<?php include "config.php"; 

$erro=""; 
$login=post("login",false);
$password=post("password",false);
if ( $login and $password ) { //tentativa de autenticação
    //todo: aceder à base de dadsos e verificar se user está na tabela de users
    $sql="select * from user where email like '$login' and password like '$password' ";
    $dados=mysqli_query($ligacao1,$sql);
    $linha=mysqli_fetch_array($dados);

    //if (isset($_POST["login"]) and $_POST["login"]=="user" and isset($_POST["password"]) and $_POST["password"]=="123" ) {
    if ( $linha ) { //se existe pelo menos uma linha
        $_SESSION["autenticado"]=1; //defino uma variável de sessão
        $_SESSION["user"]=$linha;
    } else {
        unset($_SESSION["autenticado"]);//destruir por segurança
        unset($_SESSION["user"]);//destruir por segurança
        $erro="Login incorreto"; //indicar mensagem de erro
        session_destroy();
    }
} 
//if ( isset($_POST["logout"]) ) {
if ( post("logout") ) { //se foi solicitado o logout
    unset($_SESSION["autenticado"]); //destruir
    unset($_SESSION["user"]);//destruir por segurança~
    session_destroy();
}

if (get("erro")==-1) {
    $erro="Página de acesso restrito.";
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Galeria</title>
    <link rel="stylesheet" type="text/css" href="https://taniarascia.github.io/primitive/css/main.css" />
    <style>
    .warning {
        font-weight:bold;
        font-style: italic;
    }
    .accent-button-warning {
        border-color: palevioletred !important;
        background: palevioletred !important;
    }
    .accent-button-warning:hover {
        border-color: mediumvioletred !important;
        background: mediumvioletred !important;
    }
    body {
        background: #eee;
    }
    main {
        padding:20px 0;
        background: #fff;
    }
    nav {
        background: #bbb;
        padding:10px 20px;
    }
    header {
        padding:10px 20px;
    }
    footer {
        padding:10px 20px;
    }
    </style>
</head>
<body>
<header>
    <div class="container">
        <h1>Galeria</h1>
    </div>
</header>
<nav>
    <a class="button" href="index.php">Home</a> 
    <a class="button" href="index.php?mod=galerias">Galerias</a>
    <?php if ( session("autenticado",0)==1 ) {  ?>
        <a class="button accent-warning" href="index.php?mod=perfil">Perfil <?php echo $_SESSION["user"]["nome"]; ?></a>
    <a class="button accent-warning" href="logout.php">Logout</a>
    <?php } ?>
</nav>
<main>
    <div class="container">
        


    <?php 
            $mod="mod_" .  get("mod","login")  .  ".php";
            //echo "\n<!-- $mod -->\n";
            if (file_exists($mod)) {
                include "$mod";
            } else {
                include "mod_default.php";
            }

        ?>
    </div>
</main>
<footer>
    <div class="container">
            <p class="text-center">Copyright DAAI1/LIC ITM</p>
    </div>
</footer>
</body>
</html>