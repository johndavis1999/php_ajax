<?php
    include("conexion.php");
    include("funciones.php");

    if($_POST["operacion"] == "Crear"){
        $imagen= '';
        if($_FILES["imagen_usuario"]["name"] != ''){
            $imagen = subir_imagen();
        }
        $stmp = $conexion->prepare("INSERT INTO usuarios(nombre, apellido, imagen, telefono, correo)VALUES(:nombre, :apellido, :imagen, :telefono, :correo)");
        $resultado = $stmp->execute(
            array(
                ':nombre'    => $_POST["nombre"],
                ':apellido'    => $_POST["apellido"],
                ':telefono'    => $_POST["telefono"],
                ':correo'    => $_POST["correo"],
                ':imagen'    => $imagen
            )
        );
    
        if (!empty($resultado)) {
            echo 'Registro creado';
        }
    }


    if($_POST["operacion"] == "Editar"){
        $imagen= '';
        if($_FILES["imagen_usuario"]["name"] != ''){
            $imagen = subir_imagen();
        }else{
            $imagen = $_POST["imagen_usuario_oculta"];
        }
        $stmp = $conexion->prepare("UPDATE usuarios SET nombre=:nombre, apellido=:apellido, imagen=:imagen, telefono=:telefono, correo=:correo WHERE id = :id");
        $resultado = $stmp->execute(
            array(
                ':nombre'    => $_POST["nombre"],
                ':apellido'    => $_POST["apellido"],
                ':telefono'    => $_POST["telefono"],
                ':correo'    => $_POST["correo"],
                ':imagen'    => $imagen,
                ':id'    => $_POST["id_usuario"]
            )
        );
    
        if (!empty($resultado)) {
            echo 'Registro Actualizado';
        }
    }
