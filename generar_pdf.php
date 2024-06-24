<?php
// incluye el archivo conexión
require_once 'conexion.php';
// Configura la conexión a la base de datos para usar UTF-8
$conn->set_charset("utf8mb4");
//incluid la libreria FPDF
require ('fpdf/fpdf.php');
// Obtener el ID del parámetro POST
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
// Validar el ID
if ($id <= 0) {
   die('ID inválido');
}
// Consulta para obtener los datos de la secuencia específica
$sql = "SELECT * FROM secuencias WHERE id = $id";
$result = $conn->query($sql);
// Crear el PDF
$pdf = new FPDF();
$pdf->SetMargins(20, 20, 20); // Establece los márgenes (izquierda, arriba, derecha)
$pdf->AddPage();
// Agregar la fuente Times en negrita y regular (asegúrate de tener los archivos de fuente necesarios)
$pdf->AddFont('times', 'B', 'timesb.php');
$pdf->AddFont('times', '', 'times.php');
$pdf->SetFont('times', '', 12);
// Iterar sobre los resultados de la consulta y agregarlos al PDF
while ($row = $result->fetch_assoc()) {
   $pdf->SetFont('times', 'B', 12);
   $pdf->MultiCell(0, 10, utf8_decode('Título'), 0, 1);
   $pdf->SetFont('times', '', 12);
   $pdf->MultiCell(0, 10, utf8_decode($row['titulo']), 0, 1);
   $pdf->Ln(); // Agregar salto de línea entre registros
   
   $pdf->SetFont('times', 'B', 12);
   $pdf->MultiCell(0, 10, utf8_decode('Descripción'), 0, 1);
   $pdf->SetFont('times', '', 12);
   $pdf->MultiCell(0, 10, utf8_decode($row['descripcion']), 0, 1);
   $pdf->Ln(); // Agregar salto de línea entre registros
   
   $pdf->SetFont('times', 'B', 12);
   $pdf->MultiCell(0, 10, 'Objetivos: ', 0, 1);
   $pdf->SetFont('times', '', 12);
   $pdf->MultiCell(0, 10, utf8_decode($row['objetivos']), 0, 1);
   $pdf->Ln(); // Agregar salto de línea entre registros
   
   $pdf->SetFont('times', 'B', 12);
   $pdf->MultiCell(0, 10, 'Elicitar: ', 0, 1);
   $pdf->SetFont('times', '', 12);
   $pdf->MultiCell(0, 10, utf8_decode($row['elicitar']), 0, 1);
   $pdf->Ln(); // Agregar salto de línea entre registros
   
   $pdf->SetFont('times', 'B', 12);
   $pdf->MultiCell(0, 10, 'Enganchar: ', 0, 1);
   $pdf->SetFont('times', '', 12);
   $pdf->MultiCell(0, 10, utf8_decode($row['enganchar']), 0, 1);
   $pdf->Ln(); // Agregar salto de línea entre registros
   
   $pdf->SetFont('times', 'B', 12);
   $pdf->MultiCell(0, 10, 'Explorar: ', 0, 1);
   $pdf->SetFont('times', '', 12);
   $pdf->MultiCell(0, 10, utf8_decode($row['explorar']), 0, 1);
   $pdf->Ln(); // Agregar salto de línea entre registros
   
   $pdf->SetFont('times', 'B', 12);
   $pdf->MultiCell(0, 10, 'Explicar: ', 0, 1);
   $pdf->SetFont('times', '', 12);
   $pdf->MultiCell(0, 10, utf8_decode($row['explicar']), 0, 1);
   $pdf->Ln(); // Agregar salto de línea entre registros
   
   $pdf->SetFont('times', 'B', 12);
   $pdf->MultiCell(0, 10, 'Elaborar: ', 0, 1);
   $pdf->SetFont('times', '', 12);
   $pdf->MultiCell(0, 10, utf8_decode($row['elaborar']), 0, 1);
   $pdf->Ln(); // Agregar salto de línea entre registros
   
   $pdf->SetFont('times', 'B', 12);
   $pdf->MultiCell(0, 10, 'Evaluar: ', 0, 1);
   $pdf->SetFont('times', '', 12);
   $pdf->MultiCell(0, 10, utf8_decode($row['evaluar']), 0, 1);
   $pdf->Ln(); // Agregar salto de línea entre registros
   
   $pdf->SetFont('times', 'B', 12);
   $pdf->MultiCell(0, 10, 'Extender: ', 0, 1);
   $pdf->SetFont('times', '', 12);
   $pdf->MultiCell(0, 10, utf8_decode($row['extender']), 0, 1);
   $pdf->Ln(); // Agregar salto de línea entre registros
}
// Salida del PDF
$pdf->Output('D', 'secuencia.pdf');
// Importante: No debe haber ninguna salida (echo, print, etc.) después de este punto
?>