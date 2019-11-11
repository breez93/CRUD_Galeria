<?php    

    session_start();

    $host="127.0.0.1";
    $user="root"; 
    $pass="admin"; 
    $bd="galeria"; 

    $ligacao1=mysqli_connect($host,$user,$pass,$bd); 
    mysqli_set_charset($ligacao1,"utf8");

    function query($instrucao_sql) {
        global $ligacao1; //importar variável do escopo global
        $resultado=mysqli_query( $ligacao1, $instrucao_sql);
        return $resultado;
    }

    function post($nome,$def="") {
        return isset($_POST[$nome]) ? $_POST[$nome] : $def;  
    }

    function get($nome,$def="") {
        return isset($_GET[$nome]) ? $_GET[$nome] : $def;  
    }

    function session($nome,$def="") {
        return isset($_SESSION[$nome]) ? $_SESSION[$nome] : $def;  
    }

    function files($nome,$def="") {
        return (isset($_FILES[$nome]) and $_FILES[$nome]["error"]==0) ? $_FILES[$nome] : $def;  
    }