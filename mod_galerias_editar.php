<?php 
include "acessorestrito.php";

if ( !get("idgaleria",false) ) {
    header("Location: index.php?mod=galerias&erro=-1");
    exit();
} else {


    //detetar se este ficheiro foi solicitado com envio de dados, isto é, formulário foi submetido
    if ( post("idgaleria", false)  ) {

        $nome=post("galeria");
        $idgaleria=post("idgaleria");
        $user=session("user");

        //preprar o insert
        $sql="UPDATE  `galeria`
                SET   `galeria` = '$nome',
                    `user_email` =  '$user[email]'
                WHERE
                        `idgaleria`='$idgaleria' ";

        //echo $sql; //se quiser ver o comando sql gerado antes de ser executado no mysql

        $ok=query($sql);
        if ($ok) {
            $erro="Registo modificado com sucesso";
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
        header("Location: index.php?mod=galerias&erro=-2");
    }

}



?>

    <h2>Galerias - Editar Galeria</h2>
    <p><a href="index.php?mod=galerias" class="button">Voltar</a></p>
    <?php 
        if (isset($erro)) {
            echo "<p class='warning'>$erro</p>";
        }
    ?>
    <form method="post">
        <p>
            <label for="galeria">Galeria:</label>
            <input type="text" name="galeria" required value="<?php echo $galeria["galeria"]; ?>"  />
        </p>
        <input type="hidden" name="idgaleria" value="<?php echo $galeria["idgaleria"]; ?>" />
        <p><input type="submit" class="accent-button" value="Modificar" /></p>
    </form>
</body>
</html>