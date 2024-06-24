<?php
// Incluir el archivo de conexión
require_once 'conexion.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'consultarSecuenciaPorId') {
            // Aquí manejas la consulta del ID y devuelves la respuesta en JSON
            $id = $_POST['id'];
            $resultado = consultarSecuenciaPorId($id);

            // Comprueba si $resultado contiene datos
            if ($resultado) {
                echo json_encode($resultado);
                exit;
            } else {
                // Si no hay datos, devuelve un JSON vacío o un mensaje de error
                echo json_encode(array('error' => 'No se encontraron datos para el ID proporcionado'));
                exit;
            }
        }
    }
}

// Función para crear una nueva secuencia
function crearSecuencia($titulo, $descripcion, $objetivos, $curso, $elicitar, $enganchar, $explorar, $explicar, $elaborar, $evaluar, $extender)
{
    global $conn;

    // Preparar la consulta
    $sql = "INSERT INTO secuencias (titulo, descripcion, objetivos, id_curso, elicitar, enganchar, explorar, explicar, elaborar, evaluar, extender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    echo $sql;

    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("sssisssssss", $titulo, $descripcion, $objetivos, $curso, $elicitar, $enganchar, $explorar, $explicar, $elaborar, $evaluar, $extender);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        //echo "Secuencia creada con éxito";
        //return true; // Éxito
        header("Location: index.php?timestamp=" . time());
    } else {
        echo "Error al crear la secuencia";
        return false; // Falla
    }
}

// Función para actualizar una secuencia existente
function actualizarSecuencia($id, $titulo, $descripcion, $objetivos, $curso, $elicitar, $enganchar, $explorar, $explicar, $elaborar, $evaluar, $extender)
{
    global $conn;

    /*// Preparar la consulta
    //$sql = "UPDATE secuencias SET titulo = ?, descripcion = ?, objetivos = ?, id_curso = ?, elicitar = ?, enganchar = ?, explorar = ?, explicar = ?, elaborar = ?, evaluar = ?, extender = ? WHERE id = ?";
    
    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("sssisssssssi", $titulo, $descripcion, $objetivos, $curso, $elicitar, $enganchar, $explorar, $explicar, $elaborar, $evaluar, $extender, $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        return true; // Éxito
    } else {
        return false; // Falla
    }*/
    $sql = "UPDATE secuencias SET titulo = '" . $titulo . "', descripcion = '" . $descripcion . "', objetivos = '" . $objetivos . "', id_curso = '" . $curso . "', elicitar = '" . $elicitar . "', enganchar = '" . $enganchar . "', explorar = '" . $explorar . "', explicar = '" . $explicar . "', elaborar = '" . $elaborar . "', evaluar = '" . $evaluar . "', extender = '" . $extender . "' WHERE id = " . $id;

    // Ejecutar la consulta
    $resultado = mysqli_query($conn, $sql);

    if ($resultado) {
        //echo "La consulta se ejecutó correctamente.";
        header("Location: index.php?timestamp=". time());
    } else {
        echo "Error al ejecutar la consulta: " . mysqli_error($conn);
    }

    
}

// Función para eliminar una secuencia por su ID
function eliminarSecuencia($id)
{
    global $conn;

    // Preparar la consulta
    $sql = "DELETE FROM secuencias WHERE id = ?";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        header("Location: index.php?timestamp=" . time());
        return true; // Éxito
    } else {
        return false; // Falla
    }
}

?>

<?php
// Función para consultar una secuencia por su ID
function consultarSecuenciaPorId($id)
{

    global $conn;

    // Preparar la consulta
    $sql = "SELECT * FROM secuencias WHERE id = ?";

    // Preparar la declaración
    $stmt = $conn->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("i", $id);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();

    // Obtener la fila como un array asociativo
    $row = $result->fetch_assoc();

    // Cerrar la declaración
    $stmt->close();

    return json_encode($row);
}

// Función para consultar todas las secuencias
function consultarTodasLasSecuencias()
{
    global $conn;

    // Preparar la consulta
    $sql = "SELECT * FROM secuencias";
    echo $sql;
    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Array para almacenar todas las secuencias
    $secuencias = array();

    // Iterar sobre el resultado y almacenar cada secuencia en el array
    while ($row = $result->fetch_assoc()) {
        $secuencias[] = $row;
    }

    return $secuencias;
}
