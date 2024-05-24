<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de tu página</title>
    <!-- Enlace al archivo CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

    <!-- Enlace a los estilos personalizados -->
    <!-- Aquí puedes incluir tus propios estilos CSS si los tienes -->

</head>

<body>

    <div class="container">
        <div class="row">
            <?php
            // Tu código PHP para imprimir los botones aquí
            // Incluir el archivo CRUD
            require_once 'crud.php';

            // Tu código PHP aquí
            $data = array();
            $rolename = "";
            $idCurso = -1;
            // Verificar si se ha enviado un parámetro 'parametro' a través de la URL
            if (isset($_GET['parametro'])) {
                // Obtener el valor del parámetro 'parametro'
                $json_data_url = $_GET['parametro'];

                // Decodificar el JSON
                $data = json_decode(urldecode($json_data_url), true);

                $idCurso = $data[0];
                $rolename = $data[1];
                // Imprimir cada elemento del arreglo como un botón
                /* echo "idcurso " . $data[0];
                 for ($i = 1; $i < count($data); $i++) {
                     echo '<input type="checkbox" id="opcion' . $i . '" name="opcion' . $i . '" value="' . $data[$i] . '">
             <label for="opcion' . $i . '">' . $data[$i] . '</label><br>';
                     
                 }*/
            }


            // Obtener todas las secuencias
            // Obtener el ID del curso
            if (!isset($_POST['id_curso'])) {
                $curso = $idCurso;
            } else {
                $curso = $_POST['id_curso'];
            }
            // Obtener todas las secuencias del curso específico
            $secuencias = consultarSecuenciasPorCurso($curso);

            ?>
        </div>
    </div>

    <!-- Botón para abrir el modal -->
    <?php
    if ($rolename === "editingteacher") {
        ?>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-plus"></i>
        </button>
        <?php
    }
    ?>
    <h2>Listado de Secuencias</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Secuencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($secuencias as $secuencia) { ?>
                <tr>
                    <td>
                        <!-- Mostrar el texto "SEC" seguido del ID de la secuencia -->
                        <span data-toggle="tooltip">"<?php echo $secuencia['titulo']; ?>"
                            SEC<?php echo $secuencia['id']; ?></span>
                    </td>
                    <td>
                        <!-- Iconos para visualizar, editar y eliminar la secuencia -->

                        <a href="#" class="view-secuencia" data-id="<?php echo $secuencia['id']; ?>" data-toggle="modal"
                            data-target="#modalVer"><i class="fas fa-eye"></i></a>
                        <?php
                        if ($rolename === "editingteacher") {
                            ?>
                            <a href="#" class="editar-secuencia" data-id="<?php echo $secuencia['id']; ?>" data-toggle="modal"
                                data-target="#modalEditar"><i class="fas fa-edit"></i></a>
                            <?php
                        }
                        ?>
                        <?php
                        if ($rolename === "editingteacher") {
                            ?>
                            <a href="#" class="eliminar-secuencia" data-id="<?php echo $secuencia['id']; ?>" data-toggle="modal"
                                data-target="#modalEliminar"><i class="fas fa-trash-alt"></i></a>
                            <?php
                        }
                        ?>
                        <!-- Botón para descargar PDF -->
                        <a href="#" onclick="descargarPDF(<?php echo $secuencia['id']; ?>)" class="descargar-pdf">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>

    <!-- Agregar enlaces para scripts JS, por ejemplo Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- Inicializar tooltips de Bootstrap -->
    <!--<script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>-->

    <!-- Modal para crear la secuencia de aprendizaje -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva secuencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?php

                    ?>
                    <h2>Formulario</h2>
                    <form action="crud.php" method="POST">

                        <!-- Campo ID (oculto) -->
                        <input type="hidden" name="crear_secuencia" value="">

                        <!-- Campo Título -->
                        <div class="form-group">
                            <label for="Ctitulo">Título:</label>
                            <input type="text" class="form-control" id="Ctitulo" name="titulo">
                        </div>

                        <!-- Campo Descripción -->
                        <div class="form-group">
                            <label for="Cdescripcion">Descripción:</label>
                            <textarea class="form-control" id="Cdescripcion" name="descripcion" rows="3"></textarea>
                        </div>

                        <!-- Campo Objetivos -->
                        <div class="form-group">
                            <label for="Cobjetivos">Objetivos:</label>
                            <textarea class="form-control" id="Cobjetivos" name="objetivos" rows="3"></textarea>
                        </div>

                        <!-- Campo ID Curso (oculto) -->
                        <input type="hidden" name="id_curso" value="<?php echo $data[0]; ?>">

                        <!-- Campos de evaluación -->

                        <div class="form-group">
                            <label for="Celicitar">Elicitar:</label>
                            <input type="text" class="form-control" id="Celicitar" name="elicitar">
                        </div>
                        <div class="form-group">
                            <label for="Cenganchar">Enganchar:</label>
                            <input type="text" class="form-control" id="Cenganchar" name="enganchar">
                        </div>
                        <div class="form-group">
                            <label for="Cexplorar">Explorar:</label>
                            <input type="text" class="form-control" id="Cexplorar" name="explorar">
                        </div>
                        <div class="form-group">
                            <label for="Cexplicar">Explicar:</label>
                            <input type="text" class="form-control" id="Cexplicar" name="explicar">
                        </div>
                        <div class="form-group">
                            <label for="Celaborar">Elaborar:</label>
                            <input type="text" class="form-control" id="Celaborar" name="elaborar">
                        </div>
                        <div class="form-group">
                            <label for="Cevaluar">Evaluar:</label>
                            <input type="text" class="form-control" id="Cevaluar" name="evaluar">
                        </div>
                        <div class="form-group">
                            <label for="Cextender">Extender:</label>
                            <input type="text" class="form-control" id="Cextender" name="extender">
                        </div>

                        <!-- Botón de Enviar -->
                        <button type="submit" class="btn btn-primary">Enviar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para eliminar la secuencia -->
    <div class="modal fade eliminar-secuencia" id="modalEliminar" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Secuencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php

                    ?>
                    ¿Estás seguro de que deseas eliminar esta secuencia?
                    <form action="crud.php" method="POST">

                        <!-- Campo ID (oculto) -->
                        <input type="hidden" name="eliminar_secuencia" value="">

                        <!-- Campo Título -->
                        <div class="form-group">
                            <label for="titulo">
                                <p><strong>Título:</strong> <span id="titulo2"></span></p>
                            </label>
                        </div>

                        <!-- Campo ID de la secuencia a actualizar -->
                        <input type="hidden" name="id" value="" id="idSecuenciaEliminar">

                        <!-- Botón de Eliminar -->
                        <button type="submit" class="btn btn-danger">Aceptar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para visualizar la secuencia de aprendizaje -->
    <div class="modal fade view-secuencia" id="modalVer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles de la secuencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Aquí se mostrarán los datos de la secuencia -->
                    <p><strong>Título:</strong> <span id="secuencia-titulo"></span></p>
                    <p><strong>Descripción:</strong> <span id="secuencia-descripcion"></span></p>
                    <p><strong>Objetivos:</strong> <span id="secuencia-objetivos"></span></p>
                    <p><strong>Elicitar:</strong> <span id="secuencia-elicitar"></span></p>
                    <p><strong>Enganchar:</strong> <span id="secuencia-enganchar"></span></p>
                    <p><strong>Explorar:</strong> <span id="secuencia-explorar"></span></p>
                    <p><strong>Explicar:</strong> <span id="secuencia-explicar"></span></p>
                    <p><strong>Elaborar:</strong> <span id="secuencia-elaborar"></span></p>
                    <p><strong>Evaluar:</strong> <span id="secuencia-evaluar"></span></p>
                    <p><strong>Extender:</strong> <span id="secuencia-extender"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        // Manejar clic en el ícono de "ojo"
        $('.view-secuencia').click(function () {

            var secuenciaId = $(this).data('id');

            // Realizar una solicitud AJAX para obtener los datos de la secuencia
            $.ajax({
                type: 'POST',
                url: 'crud.php',
                data: {
                    action: 'consultarSecuenciaPorId',
                    id: secuenciaId
                },
                dataType: 'json',
                success: function (response) {

                    // Parsear la respuesta JSON
                    var secuencia = JSON.parse(response);

                    // Llena el modal con los datos de la secuencia 
                    $('#secuencia-titulo').text(secuencia.titulo);
                    $('#secuencia-descripcion').text(secuencia.descripcion);
                    $('#secuencia-objetivos').text(secuencia.objetivos);
                    $('#secuencia-elicitar').text(secuencia.elicitar);
                    $('#secuencia-enganchar').text(secuencia.enganchar);
                    $('#secuencia-explorar').text(secuencia.explorar);
                    $('#secuencia-explicar').text(secuencia.explicar);
                    $('#secuencia-elaborar').text(secuencia.elaborar);
                    $('#secuencia-etextuar').text(secuencia.evaluar);
                    $('#secuencia-extender').text(secuencia.extender);

                    // Abre el modal
                    $('#modalVer').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error('Hubo un problema al realizar la solicitud:', error);
                }
            });
        });

        // Manejar clic en el ícono de "editar"
        $('.editar-secuencia').click(function () {

            var secuenciaId = $(this).data('id');

            // Realizar una solicitud AJAX para obtener los datos de la secuencia
            $.ajax({
                type: 'POST',
                url: 'crud.php',
                data: {
                    action: 'consultarSecuenciaPorId',
                    id: secuenciaId
                },
                dataType: 'json',
                success: function (response) {

                    // Parsear la respuesta JSON
                    var secuencia = JSON.parse(response);

                    // Llena el modal con los datos de la secuencia 
                    $('#idSecuenciaEditar').val(secuencia.id);
                    $('#titulo').val(secuencia.titulo);
                    $('#descripcion').text(secuencia.descripcion);
                    $('#objetivos').text(secuencia.objetivos);
                    $('#elicitar').val(secuencia.elicitar);
                    $('#enganchar').val(secuencia.enganchar);
                    $('#explorar').val(secuencia.explorar);
                    $('#explicar').val(secuencia.explicar);
                    $('#elaborar').val(secuencia.elaborar);
                    $('#evaluar').val(secuencia.evaluar);
                    $('#extender').val(secuencia.extender);
                    $('#idcursoconsultado').val(secuencia.id_curso);

                    // Abre el modal
                    $('#modalEditar').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error('Hubo un problema al realizar la solicitud:', error);
                }
            });
        });

        // Manejar clic en el ícono de "eliminar"
        $('.eliminar-secuencia').click(function () {

            var secuenciaId = $(this).data('id');

            // Realizar una solicitud AJAX para obtener los datos de la secuencia
            $.ajax({
                type: 'POST',
                url: 'crud.php',
                data: {
                    action: 'consultarSecuenciaPorId',
                    id: secuenciaId
                },
                dataType: 'json',
                success: function (response) {

                    // Parsear la respuesta JSON
                    var secuencia = JSON.parse(response);

                    // Llena el modal con los datos de la secuencia 
                    $('#idSecuenciaEliminar').val(secuencia.id);
                    $('#titulo2').text(secuencia.titulo);

                    // Abre el modal
                    $('#modalEliminar').modal('show');
                },
                error: function (xhr, status, error) {
                    console.error('Hubo un problema al realizar la solicitud:', error);
                }
            });
        });

        function descargarPDF(idSecuencia) {
            // Realizar una solicitud AJAX para descargar el PDF
            $.ajax({
                type: 'POST',
                url: 'generar_pdf.php',
                data: {
                    id: idSecuencia
                },
                success: function (response) {
                    // Manejar la respuesta, por ejemplo, redirigir a la página de descarga
                    window.location.href = 'generar_pdf.php?id=' + idSecuencia;
                },
                error: function (xhr, status, error) {
                    console.error('Hubo un problema al generar el PDF:', error);
                }
            });
        }

    </script>



    <!-- Modal para actualizar la secuencia de aprendizaje -->
    <div class="modal fade editar-secuencia" id="modalEditar" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar secuencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php

                    ?>
                    <form action="crud.php" method="POST">

                        <!-- Campo ID (oculto) -->
                        <input type="hidden" name="actualizar_secuencia" value="">

                        <!-- Campo Título -->
                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" class="form-control" id="titulo" name="titulo">
                        </div>

                        <!-- Campo Descripción -->
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>

                        <!-- Campo Objetivos -->
                        <div class="form-group">
                            <label for="objetivos">Objetivos:</label>
                            <textarea class="form-control" id="objetivos" name="objetivos" rows="3"></textarea>
                        </div>

                        <!-- Campo ID Curso (oculto) -->
                        <input type="hidden" name="id_curso" value="" id="idcursoconsultado">

                        <!-- Campos de evaluación -->

                        <div class="form-group">
                            <label for="elicitar">Elicitar:</label>
                            <input type="text" class="form-control" id="elicitar" name="elicitar">
                        </div>
                        <div class="form-group">
                            <label for="enganchar">Enganchar:</label>
                            <input type="text" class="form-control" id="enganchar" name="enganchar">
                        </div>
                        <div class="form-group">
                            <label for="explorar">Explorar:</label>
                            <input type="text" class="form-control" id="explorar" name="explorar">
                        </div>
                        <div class="form-group">
                            <label for="explicar">Explicar:</label>
                            <input type="text" class="form-control" id="explicar" name="explicar">
                        </div>
                        <div class="form-group">
                            <label for="elaborar">Elaborar:</label>
                            <input type="text" class="form-control" id="elaborar" name="elaborar">
                        </div>
                        <div class="form-group">
                            <label for="evaluar">Evaluar:</label>
                            <input type="text" class="form-control" id="evaluar" name="evaluar">
                        </div>
                        <div class="form-group">
                            <label for="extender">Extender:</label>
                            <input type="text" class="form-control" id="extender" name="extender">
                        </div>
                        <!-- Campo ID de la secuencia a actualizar -->
                        <input type="hidden" name="id" value="" id="idSecuenciaEditar">

                        <!-- Botón de Enviar -->
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>





    <!-- Scripts de Bootstrap (jQuery, Popper.js y Bootstrap) -->
    <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>-->


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/adde491806.js" crossorigin="anonymous"></script>
    <!-- Otros scripts JavaScript -->
    <!-- Aquí puedes incluir tus propios scripts JavaScript si los tienes -->

</body>

</html>