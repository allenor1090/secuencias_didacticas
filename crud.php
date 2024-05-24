<?php
// Incluir el funciones CRUD
require_once 'funciones.php';

// Verificar si se ha enviado una solicitud POST para crear una nueva secuencia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crear_secuencia"])) {
    // Recuperar los datos del formulario
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $objetivos = $_POST["objetivos"];
    $curso = $_POST["id_curso"];
    $elicitar = $_POST["elicitar"];
    $enganchar = $_POST["enganchar"];
    $explorar = $_POST["explorar"];
    $explicar = $_POST["explicar"];
    $elaborar = $_POST["elaborar"];
    $evaluar = $_POST["evaluar"];
    $extender = $_POST["extender"];

    // Llamar a la función para crear una nueva secuencia
    if (crearSecuencia($titulo, $descripcion, $objetivos, (int) $curso, $elicitar, $enganchar, $explorar, $explicar, $elaborar, $evaluar, $extender)) {
        //echo "Secuencia creada exitosamente.";
        header("Location: index.php");
    } else {
        echo "Error al crear la secuencia.";
    }
}

// Verificar si se ha enviado una solicitud POST para actualizar una secuencia existente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar_secuencia"])) {
    // Recuperar los datos del formulario
    $id = $_POST["id"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $objetivos = $_POST["objetivos"];
    $curso = $_POST["id_curso"];
    $elicitar = $_POST["elicitar"];
    $enganchar = $_POST["enganchar"];
    $explorar = $_POST["explorar"];
    $explicar = $_POST["explicar"];
    $elaborar = $_POST["elaborar"];
    $evaluar = $_POST["evaluar"];
    $extender = $_POST["extender"];

    // Llamar a la función para actualizar la secuencia
    if (actualizarSecuencia((int) $id, $titulo, $descripcion, $objetivos, (int) $curso, $elicitar, $enganchar, $explorar, $explicar, $elaborar, $evaluar, $extender)) {
        echo "Secuencia actualizada exitosamente.";
        //header("Location: index.php");
    } else {
        echo "Error al actualizar la secuencia.";
    }
}

// Verificar si se ha enviado una solicitud POST para eliminar una secuencia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar_secuencia"])) {
    // Recuperar el ID de la secuencia a eliminar
    $id = $_POST["id"];

    // Llamar a la función para eliminar la secuencia
    if (eliminarSecuencia($id)) {
        echo "Secuencia eliminada exitosamente.";
        //header("Location: index.php");
    } else {
        echo "Error al eliminar la secuencia.";
    }
}

// Verificar si se ha enviado una solicitud POST para consultar una secuencia por su ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["consultarSecuenciaPorId"])) {
    // Recuperar el ID de la secuencia a consultar
    $id = $_POST["id"];

    // Llamar a la función para consultar la secuencia por su ID
    $secuencia = consultarSecuenciaPorId($id);

    //devolver los datos de la secuencia como json
    echo json_encode($secuencia);
    if ($secuencia) {
        // Haz algo con la secuencia consultada
        echo "Consulta por ID exitosa.";
        //header("Location: index.php");
    } else {
        echo "No se encontró ninguna secuencia con ese ID.";
    }
}

// Verificar si se ha enviado una solicitud POST para consultar todas las secuencias
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["consultar_todas_las_secuencias"])) {
    // Llamar a la función para consultar todas las secuencias
    $secuencias = consultarTodasLasSecuencias();

    if ($secuencias) {
        // Haz algo con las secuencias consultadas
        echo "Consulta de todas las secuencias exitosa.";
        //header("Location: index.php");
    } else {
        echo "No se encontraron secuencias.";
    }
}

// Función para consultar todas las secuencias de un curso específico
function consultarSecuenciasPorCurso($curso) {
    global $conn;

    $secuencias = array();

    // Preparar la consulta con la cláusula WHERE para filtrar por ID de curso
    $sql = "SELECT * FROM secuencias WHERE id_curso = ?";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    if($stmt){
    // Vincular parámetro
    $stmt->bind_param("i", $curso);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();

    // Array para almacenar todas las secuencias
   

    // Iterar sobre el resultado y almacenar cada secuencia en el array
    while ($row = $result->fetch_assoc()) {
        $secuencias[] = $row;
    }

    $_POST['secuencias'] = $secuencias;
    }else{
        echo "No hay secuencias";
    }
    return $secuencias;
}

?>
