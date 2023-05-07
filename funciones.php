<?php 

    function subir_imagen(){
        if(isset($_FILES["imagen_usuario"])){
            $extension = explode('.',$_FILES["imagen_usuario"]['name']);
            $nuevo_nommbre = rand().'.'.$extension[1];
            $ubicacion = './img/'.$nuevo_nommbre;
            move_uploaded_file($_FILES["imagen_usuario"]['tmp_name'],$ubicacion);
            return $nuevo_nommbre;
        }
    }

    function obtener_nombre_imagen($id_usuario){
        include('conexion.php');
        $stmp = $conexion->prepare("SELECT imagen from usuarios WHERE id = '$id_usuario'");
        $stmp->execute();
        $resultado = $stmp->fetchAll();
        foreach($resultado as $fila){
            return $fila['imagen'];
        }
    }

    function obtener_todos_registros(){
        include('conexion.php');
        $stmp = $conexion->prepare("SELECT * from usuarios");
        $stmp->execute();
        $resultado = $stmp->fetchAll();
        return $stmp->rowCount();
    }
