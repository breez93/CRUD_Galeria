<?php 

include "acessorestrito.php";

//detetar se este ficheiro foi solicitado com envio de dados, isto é, formulário foi submetido
if ( post("galeria", false)  ) {

    $galeria=post("galeria");
    $user=session("user");

    //preprar o insert
    $sql="INSERT INTO `galeria` 
                ( `galeria`, `user_email`) 
                VALUES ( '$galeria', '$user[email]') ";
    //echo $sql; //se quiser ver o comando sql gerado antes de ser executado no mysql

    $ok=query($sql);
    if ($ok) {
        $erro="Registo criado com sucesso";
    } else {
        $erro="Erro ao criar o registo";
    }


}
?>

    <h2>Galerias - Nova galeria</h2>
    <p><a class="button" href="index.php?mod=galerias">Voltar</a></p>
    <?php 
        if (isset($erro)) {
            echo "<p class='warning'>$erro</p>";
        }
    ?>
    <form method="post">
        <p>
            <label for="galeria">Galeria:</label>
            <input type="text" name="galeria" required  />
        </p>
        <p><input type="submit" value="Criar" clasS="accent-button" /></p>
    </form>
</body>
</html>