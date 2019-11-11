<?php 

    include "config.php";
    include "acessorestrito.php";

    $sql="select * from foto where idfoto='".$_GET["idfoto"]."'";
    $fotos=query($sql);
    $linha=mysqli_fetch_array($fotos);

    //informar o browser que o que vai receber não é HTML mas sim um ...
    header("Content-type: ".  $linha["mimetype"] ); //...ficheiro do type
    header("Content-length: ". $linha["size"] ); //tamanho
    header("Content-Disposition: inline; filename=\"".$linha["name"]."\" "); //repor nome original

    echo $linha["content"];

    
