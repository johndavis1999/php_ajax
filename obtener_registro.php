<?php

    include("conexion.php");
    include("funciones.php");

    if(isset($_POST["id_usuario"])){
        $salida = array();
        $stmp = $conexion->prepare("SELECT * from usuarios WHERE id = '".$_POST["id_usuario"]."' LIMIT 1");
        $stmp->execute();
        $resultado = $stmp->fetchAll();
        foreach($resultado as $fila){
            $salida["nombre"] = $fila["nombre"];
            $salida["apellido"] = $fila["apellido"];
            $salida["telefono"] = $fila["telefono"];
            $salida["correo"] = $fila["correo"];
            if($fila["imagen"] != ""){
                $salida["imagen_usuario"] = '<img src="img/' . $fila["imagen"]. '" class="img-thumbnail" width="50" height="50"/><input type="hidden" name="imagen_usuario_oculta" value="'.$fila["imagen"].'"/>';
            }else{
                $salida["imagen_usuario"] = '<input type="hidden" name="imagen_usuario_oculta" value="" />';
            }
        }
        echo json_encode($salida);
    }