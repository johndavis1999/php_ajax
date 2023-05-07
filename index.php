<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="css/estilos.css">
  </head>
  <body>
    <div class="container fondo">
        <h1 class="text-center">CRUD PHP CON AJAX</h1>

        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">
                    <!-- Button trigger modal -->
                    <button id="botonCrear" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUsuario">
                    <i class="bi bi-plus-circle"></i> Crear
                    </button>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="table-responsive">
            <table id="datos_usuario" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombres</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Foto</th>
                        <th>Fecha de creacion</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Crear usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="formulario" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nombre">Ingrese el nombre:</label>
                            <input id="nombre" class="form-control" type="text" name="nombre">
                        </div>
                        <div class="form-group">
                            <label for="apellido">Ingrese el apellido:</label>
                            <input id="apellido" class="form-control" type="text" name="apellido">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Ingrese el telefono:</label>
                            <input id="telefono" class="form-control" type="text" name="telefono">
                        </div>
                        <div class="form-group">
                            <label for="correo">Ingrese el correo:</label>
                            <input id="correo" class="form-control" type="email" name="correo">
                        </div>
                        <div class="form-group">
                            <label for="imagen_usuario">Selecciona una imagen</label>
                            <input id="imagen_usuario" class="form-control" type="file" name="imagen_usuario">
                        </div>
                        <span id="imagen_subida"></span>
                        <div class="modal-footer">
                            <input type="hidden" name="id_usuario" id="id_usuario">
                            <input type="hidden" name="operacion" id="operacion">
                            <button type="submit" name="action" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script text="text/javascript">
        $(document).ready(function(){ 
            $("#botonCrear").click(function(){
                $("#formulario")[0].reset();
                $(".modal-title").text("Crear Usuario");
                $("#action").val("Crear");
                $("#operacion").val("Crear");
                $("#imagen_subida").html("");
            })
            //mostrar datos
            var dataTable = $('#datos_usuario').DataTable({
                "processing":true,
                "serverSide":true,
                "order":[],
                "ajax":{
                    url:"obtener_registros.php",
                    type:"POST"
                },
                "columsDefs":[
                    {
                    "targets":[0,3,4],
                    "orderable":false,
                    },
                ]
            });
            //crear
            $(document).on('submit','#formulario',function(event){
                event.preventDefault();
                var nombres = $("#nombre").val();
                var apellido = $("#apellido").val();
                var telefono = $("#telefono").val();
                var correo = $("#correo").val();
                var extension = $("#imagen_usuario").val().split('.').pop().toLowerCase();

                if(extension != ''){
                    if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
                    {
                        alert("Fomato de imagen inválido");
                        $('#imagen_usuario').val('');
                        return false;
                    }
                }
                if(nombre != '' && apellido != '' && correo != ''){
                    $.ajax({
                        url:"crear.php",
                        method:'POST',
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        success:function(data)
                        {
                            alert(data);
                            $('#formulario')[0].reset();
                            $('#modalUsuario').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
                }
                else{
                    alert("Algunos campos son obligatorios");
                }
            });
            // editar
            $(document).on('click','.editar',function(){
                var id_usuario = $(this).attr("id");
                $.ajax({
                    url:"obtener_registro.php",
                    method:"POST",
                    data:{id_usuario:id_usuario},
                    dataType:"json",
                    success:function(data){
                        $('#modalUsuario').modal('show');
                        $('#nombre').val(data.nombre);
                        $('#apellido').val(data.apellido);
                        $('#telefono').val(data.telefono);
                        $('#correo').val(data.correo);
                        $('.modal-title').text("Editar Usuario");
                        $('#id_usuario').val(id_usuario);
                        $('#imagen_subida').html(data.imagen_usuario);
                        $('#action').val("Editar");
                        $('#operacion').val("Editar");
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        console.log(textStatus, errorThrown);
                    }
                })
            });
            //borrar
            $(document).on('click','.borrar',function(){
                var id_usuario = $(this).attr("id");
                if(confirm("Esta seguro de borrar este registro: " + id_usuario)){
                    $.ajax({
                        url:"borrar.php",
                        method:"POST",
                        data:{id_usuario:id_usuario},
                        success:function(data){
                            alert(data);
                            dataTable.ajax.reload();
                        }
                    })
                }
                else{
                    return false;
                }
            })

        }); 
    </script>
  </body>
</html>