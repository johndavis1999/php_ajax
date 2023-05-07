<?php
    include("conexion.php");
    include("funciones.php");

    if(isset($_POST["id_usuario"])){
        $imagen= obtener_nombre_imagen($_POST["id_usuario"]);

        if($imagen != ''){
            unlink("img/". $imagen);
        }
        $stmp = $conexion->prepare("DELETE FROM usuarios WHERE id = :id");
        $resultado = $stmp->execute(
            array(
                ':id'    => $_POST["id_usuario"]
            )
        );
    
        if (!empty($resultado)) {
            echo 'Registro eliminado';
        }
    }
