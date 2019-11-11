<?php 

//Se já estiver autenticado, não pode fazer registo
if (isset($_SESSION["user"]) or isset($_SESSION["autenticado"])) {
    header("Location: index.php?erro=-2");
    exit();
}

$erro="";






    //detetar se este ficheiro foi solicitado com envio de dados, isto é, formulário foi submetido
    if ( post("nome", false) && post("email", false)  && post("password", false) ) {


        $nome=post("nome");
        $email=post("email");
        $password=post("password"); 

        //preparar o insert
        $sql="INSERT INTO `user` 
                    ( `nome`, `email`,`password`) 
                    VALUES (  '$nome',  '$email','$password') ";
        //echo $sql; //se quiser ver o comando sql gerado antes de ser executado no mysql

        $ok=query($sql);


        if ($ok) {
            $erro.="Registo criado com sucesso. Pode agora <a class=\"button accent-button\" href=\"index.php\">autenticar-se</a>.";
        } else {
            $erro.="Erro ao criar o registo.";
        }



    }


    if (isset($erro)) {
        echo "<p class='warning'>$erro</p>";
    }

    ?>
    <h2>Registar</h2>
    
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
            <input type="text" name="nome" required  />
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" required  />
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" id="p1" name="password" required  />
        </p>
        <p>
            <label for="password2">Password (repetir):</label>
            <input type="password" id="p2" name="password2" required  />
        </p>          
        <p><input class="accent-button" type="submit" value="Registar" /></p>
    </form>
