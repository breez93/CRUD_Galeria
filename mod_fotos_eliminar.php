<?php 

include "acessorestrito.php";


if ( !get("idgaleria",false) ) {
    header("Location: index.php?mod=fotos&erro=-1");
    exit();
} else if( !get("idfoto",false) ) {
    header("Location: index.php?mod=fotos&erro=-2");
    exit();
} else {

    $idgaleria=get("idgaleria");
    $sql="select * from galeria where idgaleria='$idgaleria' ";
    $dados=query($sql);
    if ($dados and mysqli_num_rows($dados)>0) {
        $galeria=mysqli_fetch_array($dados);
        //print_r($galeria);
    } else {
        header("Location: index.php?mod=galerias&erro=-1");
        exit();
    }


    $idfoto=get("idfoto",0);


    //detetar se este ficheiro foi solicitado com envio de dados, isto é, formulário foi submetido
    if ( post("foto",false) ) {


        //preparar o delete
        $sql="DELETE from `foto` 
                WHERE
                        `idfoto`='$idfoto' ";
        //echo $sql; //se quiser ver o comando sql gerado antes de ser executado no mysql

        $ok=query($sql);

        if ($ok) {
            $erro.="Registo eliminado com sucesso";
            header("Location: index.php?mod=fotos&idgaleria=$idgaleria&ok=1");
            exit();
        } else {
            $erro.="Erro ao modificar o registo";
        }


    } 


    $sql="select * from foto where idfoto='$idfoto' ";
    $fotos=query($sql);
    if ($fotos and mysqli_num_rows($fotos)>0) {
        $foto=mysqli_fetch_array($fotos);
        //print_r($foto);
    } else {
        header("Location: index.php?mod=fotos&idgaleria=$idgaleria&erro=-2");
        exit();
    }

}



?>

    <h2><?php echo $galeria["galeria"] ?> - Eliminar Foto</h2>
    <p><a href="index.php?mod=fotos&idgaleria=<?php echo $idgaleria; ?>" class="button">Voltar</a></p>

    <?php 
        if (isset($erro)) {
            echo "<p class='warning'>$erro</p>";
        }
    ?>

    <img src="fotos.php?idfoto=<?php echo $foto["idfoto"]; ?>" title="<?php echo $foto["titulo"]; ?>" />
    
    <form method="post" enctype="multipart/form-data">

        <p><?php echo $foto["titulo"] ?></p>
        <!-- codigo da galeria enviado escondido do user -->
        <input type="hidden" name="galeria" value="<?php echo $idgaleria; ?>" />
        <input type="hidden" name="foto" value="<?php echo $foto["idfoto"]; ?>" />      
        <p><input class="accent-button-warning" type="submit" value="Eliminar" />
            <a class="button accent-button" href="index.php?mod=fotos_editar&idgaleria=<?php echo $idgaleria; ?>&idfoto=<?php echo $idfoto; ?>">Editar</a>
        </p>
    </form>


</body>
</html>