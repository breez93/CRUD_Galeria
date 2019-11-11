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
    if ( post("titulo",false) ) {

        $titulo=post("titulo");
        $ficheiro=files("ficheiro",false);

        //se foi recebido um ficheiro para alterar
        if ($ficheiro) {
                
            $nomedoficheiro= $ficheiro["name"];
            $tipoficheiro= $ficheiro["type"];
            $tamanho= $ficheiro["size"];

            $info = pathinfo($nomedoficheiro);

            if ( strtolower($info['extension'])=="jpg" or strtolower($info['extension'])=="png" ) {

                //obter conteudo do ficheiro
                $content=file_get_contents(  $ficheiro["tmp_name"] ); //ler conteúdo
                $content=addslashes($content); //tratar plicas

                //preparar o insert
                $sql="UPDATE `foto` 
                        SET  
                             `titulo`='$titulo', 
                             `content`='$content', 
                             `name`='$nomedoficheiro',
                             `mimetype`='$tipoficheiro', 
                             `size`='$tamanho'
                        WHERE
                             `idfoto`='$idfoto' ";
                //echo $sql; //se quiser ver o comando sql gerado antes de ser executado no mysql

                $ok=query($sql);


                if ($ok) {
                    $erro.="Registo modificado com sucesso";
                } else {
                    $erro.="Erro ao modificar o registo";
                }


            } else {

                $erro.="Formato de foto não aceite";
                
            }

        } else { //se não foi recebido foto, update parcial

                //preparar o insert
                $sql="UPDATE `foto` 
                        SET  
                             `titulo`='$titulo'
                        WHERE
                             `idfoto`='$idfoto' ";
                //echo $sql; //se quiser ver o comando sql gerado antes de ser executado no mysql

                $ok=query($sql);

                if ($ok) {
                    $erro.="Registo modificado com sucesso";
                } else {
                    $erro.="Erro ao modificar o registo";
                }

        }



    } 


    $sql="select * from foto where idfoto='$idfoto' ";
    $fotos=query($sql);
    if ($fotos and mysqli_num_rows($fotos)>0) {
        $foto=mysqli_fetch_array($fotos);
        //print_r($foto);
    } else {
        header("Location: index.php?mod=fotos&erro=-1");
        exit();
    }

}



?>

    <h2><?php echo $galeria["galeria"] ?> - Editar Foto</h2>
    <p><a href="index.php?mod=fotos&idgaleria=<?php echo $idgaleria; ?>" class="button">Voltar</a></p>

    <?php 
        if (isset($erro)) {
            echo "<p class='warning'>$erro</p>";
        }
    ?>

    <img src="fotos.php?idfoto=<?php echo $foto["idfoto"]; ?>" title="<?php echo $foto["titulo"]; ?>" />
    
    <form method="post" enctype="multipart/form-data">
        <p>
            <label for="ficheiro">Substituir Foto:</label>
            <input type="file" name="ficheiro"  />
        </p>
        <p>
            <label for="titulo">Legenda:</label>
            <input type="text" name="titulo" value="<?php echo $foto["titulo"] ?>" required  />
        </p>
        <!-- codigo da galeria enviado escondido do user -->
        <input type="hidden" name="galeria" value="<?php echo $idgaleria; ?>" />
        <input type="hidden" name="foto" value="<?php echo $foto["idfoto"]; ?>" />      
        <p><input class="accent-button" type="submit" value="Modificar" />
            <a class="button accent-button-warning" href="index.php?mod=fotos_eliminar&idgaleria=<?php echo $idgaleria; ?>&idfoto=<?php echo $idfoto; ?>">Eliminar</a>
        </p>
    </form>


</body>
</html>