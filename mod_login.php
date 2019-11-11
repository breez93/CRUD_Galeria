<?php 

        //if ( !isset($_SESSION["autenticado"]) or $_SESSION["autenticado"]!=1) )
        if ( session("autenticado",0)==0 ) { ?>

                <?php echo "<p class='warning'>$erro</p>"; ?>
                <form method="post">
                    <p><label for="login">Login: </label>
                        <input type="email" name="login" required /><br>
                        <label for="password">password: </label>
                        <input type="password" name="password" required />
                    </p>
                    <p><input type="submit" class="accent-button" value="Autenticar" />
                    <a class="button" href="index.php?mod=register">Novo registo</a></p>
                </form>


        <?php } else {  
            


            echo "<p>Bem vindo <strong>".$_SESSION["user"]["nome"]."</strong></p>";
            echo "<p><a class=\"button\" href=\"logout.php\">Sair</a> <a class=\"button accent-button\" href=\"index.php?mod=perfil\">Perfil</a></p>";
            
         } 



