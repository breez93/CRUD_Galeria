<?php 
include "acessorestrito.php";

//detetar se este ficheiro foi solicitado com envio de dados, isto é, formulário foi submetido
if ( post("iduser", false)  ) {

    $nome=post("nome");
    $iduser=post("iduser");
    $email=post("email");
    $password=post("password",false);

    //preprar o update

    if ($password) { //com a modificação da pass
        $sql="UPDATE  `user`
                SET   
                    `nome` = '$nome',
                    `email` =  '$email',
                    `password` =  '$password'
                WHERE
                        `email`='$iduser' ";
    } else { //sem a modificação da pass
        $sql="UPDATE  `user`
                SET   
                    `nome` = '$nome',
                    `email` =  '$email'
                    
                WHERE
                    `email`='$iduser' ";
    }
    //echo $sql; //se quiser ver o comando sql gerado antes de ser executado no mysql

    $ok=query($sql);
    if ($ok) {
        $erro="Registo modificado com sucesso";

        //importante, modificar os dados da sessão para atualizar dados
        $sql="select * from user where email='".$_SESSION["user"]["email"]."' ";
        $dados=query($sql);
        $_SESSION["user"]=mysqli_fetch_array($dados);

    } else {
        $erro="Erro ao modificar o registo";
    }

}


$sql="select * from user where email='".$_SESSION["user"]["email"]."' ";
$dados=query($sql);
if ($dados and mysqli_num_rows($dados)>0) {
    $user=mysqli_fetch_array($dados);
    //print_r($user);
} else {
    header("Location: index.php?mod=users&erro=-2");
    exit();
}





?>

    <h2>Editar Perfil</h2>
    <?php 
        if (isset($erro)) {
            echo "<p class='warning'>$erro</p>";
        }
    ?>
    <script>
        function validar() {
            if (p1.value!=p2.value) {
                alert('Passwords não coincidem');
                return false;
            } else {
                return true;
            }
        }
    </script>
    <form method="post" onsubmit="return validar()">
        <p>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required value="<?php echo $user["nome"]; ?>"  />
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" required  value="<?php echo $user["email"]; ?>" />
        </p>
        <p>
            <label for="password">Password (apenas se desejar modificar):</label>
            <input type="password" id="p1" name="password"   />
        </p>
        <p>
            <label for="password2">Password (repetir):</label>
            <input type="password" id="p2" name="password2"   />
        </p>  
        <input type="hidden" name="iduser" value="<?php  echo $user["email"]; ?>" />        
        <p><input class="accent-button" type="submit" value="Modificar" /></p>
    </form>
</body>
</html>