<?php 
 
include "acessorestrito.php";

if ( !get("idgaleria",false) ) {
    header("Location: galerias.php?erro=-1");
    exit();
} else {


    //detetar se este ficheiro foi solicitado com envio de dados, isto é, formulário foi submetido
    if ( post("idgaleria", false)  ) {

        $idgaleria=post("idgaleria");


        //preprar o insert
        $sql="delete from  `galeria`
                
                WHERE
                        `idgaleria`='$idgaleria' ";

        //echo $sql; //se quiser ver o comando sql gerado antes de ser executado no mysql

        $ok=query($sql);
        if ($ok) {
            //$erro="Registo eliminado com sucesso";
            header("Location: index.php?mod=galerias&erro=-3");
            exit();
        } else {
            $erro="Erro ao modificar o registo";
        }



    }


    $idgaleria=get("idgaleria");
    $sql="select * from galeria where idgaleria='$idgaleria' ";
    $dados=query($sql);
    if ($dados and mysqli_num_rows($dados)>0) {
        $galeria=mysqli_fetch_array($dados);
        //print_r($galeria);
    } else {
        header("Location: galerias.php?erro=-2");
    }

}



?>


    <h2>galerias - Eliminar Galeria</h2>
    <p><a class="button" href="index.php?mod=galerias">Voltar</a></p>
    <?php 
        if (isset($erro)) {
            echo "<p class='warning'>$erro</p>";
        }
    ?>
    <form method="post">
        <p>
            <label for="galeria">Galeria:</label>
            <input type="text" name="galeria" required readonly value="<?php echo $galeria["galeria"]; ?>"  />
        </p>
        <p>Nota: Todas as fotos serão também removidas.</p>
        <input type="hidden" name="idgaleria" value="<?php echo $galeria["idgaleria"]; ?>" />
        <p><input type="submit" class="accent-button-warning" value="Eliminar" /></p>
    </form>
</body>
</html>