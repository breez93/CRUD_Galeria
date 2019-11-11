<?php 

include "acessorestrito.php";

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
        echo "<p><a class=\"button accent-button\" href=\"index.php?mod=fotos_novo&idgaleria=$idgaleria\">Adicionar foto</a></p>";
 
        if (isset($erro)) {
            echo "<p class='warning'>$erro</p>";
        }

        //tirar fotos da galeria        
        $sql="SELECT idfoto,titulo from foto     
                where galeria_idgaleria='$idgaleria'
                order by idfoto asc";
        //echo $sql;
        $fotos=query($sql);

        echo "<div class=\"flex-row\">";
        while($foto = mysqli_fetch_array($fotos)) {

            echo "<div class=\"flex-large\">
                    <a href=\"index.php?mod=fotos_editar&idgaleria=$idgaleria&idfoto=$foto[idfoto]\">
                        <img class=\"responsive-image\" src=\"fotos.php?idfoto=$foto[idfoto]\"  title=\"$foto[titulo]\" />
                        <br>$foto[titulo]
                    </a>

                  </div>";

        }
        echo "</div>";
    
    }
    
}