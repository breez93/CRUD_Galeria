<?php 

include "acessorestrito.php";

if ( get("erro")=="-1" ) {
    $erro="Não indicou o código da galeria";
}


?>

    <h2>Galerias</h2>
    <p><a class="button" href="index.php?mod=galerias_nova">Nova galeria</a></p>

    <?php 
    if (isset($erro)) {
        echo "<p class='warning'>$erro</p>";
    }
    
    echo "<table>
            <tr> 
                <th>Galeria</th>
                <th>Fotos</th>
                <th>Ação</th>
            </tr>";

    $galerias=query("select *, (select count(idfoto) from foto where galeria_idgaleria=galeria.idgaleria) as total from galeria order by galeria asc");
    while($galeria = mysqli_fetch_array($galerias)) {

        echo "<tr>
                    <td>$galeria[galeria]</td>
                    <td>$galeria[total] fotos</td>
                    <td>
                        <a class=\"button accent-button\" href=\"index.php?mod=galerias_editar&idgaleria=$galeria[idgaleria]\">Editar</a>
                        <a class=\"button accent-button-warning\" href=\"index.php?mod=galerias_remover&idgaleria=$galeria[idgaleria]\">Eliminar</a>
                        <a class=\"button accent-button\" href=\"index.php?mod=fotos&idgaleria=$galeria[idgaleria]\">Fotos</a>
                    </td>
                </tr>";

    }

    echo "</table>";
    
    
    ?>
</body>
</html>