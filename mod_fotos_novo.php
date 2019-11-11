<?php 

include "acessorestrito.php";
$erro="";

if ( !get("idgaleria",false) ) {

    echo "<h2>Galeria desconhecida</h2>";
    echo "<p><a class=\"button\" href=\"index.php?mod=galerias\">Voltar</a></p>";

} else {

        //obter galeria
        $idgaleria=get("idgaleria");
        $sql="select * from galeria where idgaleria='$idgaleria'";
        $galerias=query($sql);
        $galeria=mysqli_fetch_array($galerias);
    
        //verificar se galeria existe
        if (mysqli_num_rows($galerias)==0)  {
    
            echo "<h2>Galeria desconhecida</h2>";
            echo "<p><a class=\"button\" href=\"index.php?mod=galerias\">Voltar</a></p>";
    
        } else {

            echo "<h2>$galeria[galeria]</h2>";


            //detetar se este ficheiro foi solicitado com envio de dados, isto é, formulário foi submetido
            if ( post("titulo", false)  ) {


                $titulo=post("titulo");
                $user=session("user");
                $galeria=post("galeria"); //aRRAY

                $ficheiro=files("ficheiro",false);

                $nomedoficheiro=  $ficheiro["name"];
                $tipoficheiro= $ficheiro["type"];
                $tamanho= $ficheiro["size"];

                $info = pathinfo($nomedoficheiro);

                if ( strtolower($info['extension'])=="jpg" or strtolower($info['extension'])=="png" ) {

                    //obter conteudo do ficheiro
                    $content=file_get_contents(  $ficheiro["tmp_name"] ); //ler conteúdo
                    $content=addslashes($content); //tratar plicas

                    //preparar o insert
                    $sql="INSERT INTO `foto` 
                                ( `titulo`, `user_email`,`content`, `name`, `mimetype` , `size`, `galeria_idgaleria`) 
                                VALUES (  '$titulo',  '$user[email]','$content','$nomedoficheiro', '$tipoficheiro' , '$tamanho','$idgaleria') ";
                    //echo $sql; //se quiser ver o comando sql gerado antes de ser executado no mysql

                    $ok=query($sql);


                    if ($ok) {
                        $erro.="Registo criado com sucesso";
                    } else {
                        $erro.="Erro ao criar o registo";
                    }


                } else {

                    $erro.="Formato de foto não aceite";
                }

            }
        

            if (isset($erro)) {
                echo "<p class='warning'>$erro</p>";
            }

            ?>
            <p><a class="button" href="index.php?mod=fotos&idgaleria=<?php echo $idgaleria; ?>">Voltar</a></p>
            <form method="post" enctype="multipart/form-data">
                <p>
                    <label for="ficheiro">Foto:</label>
                    <input type="file" name="ficheiro" required  />
                </p>
                <p>
                    <label for="titulo">Legenda:</label>
                    <input type="text" name="titulo" required  />
                </p>
                <!-- codigo da galeria enviado escondido do user -->
                <input type="hidden" name="galeria" value="<?php echo $idgaleria; ?>" />      
                <p><input class="accent-button" type="submit" value="criar" /></p>
            </form>

<?php

        }
    
}