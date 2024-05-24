<?php
// incluye el archivo conexión
require_once 'conexion.php';
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
$pdf->AddPage();
// Configurar fuente y tamaño de texto
$pdf->SetFont('Arial', '', 12);
// Iterar sobre los resultados de la consulta y agregarlos al PDF
while ($row = $result->fetch_assoc()) {
   $pdf->Cell(0, 10, 'Titulo: ' . $row['titulo'], 0, 1);
   $pdf->Cell(0, 10, 'Descripcion: ' . $row['descripcion'], 0, 1);
   $pdf->Cell(0, 10, 'Objetivos: ' . $row['objetivos'], 0, 1);
   $pdf->Cell(0, 10, 'Elicitar: ' . $row['elicitar'], 0, 1);
   $pdf->Cell(0, 10, 'Enganchar: ' . $row['enganchar'], 0, 1);
   $pdf->Cell(0, 10, 'Explorar: ' . $row['explorar'], 0, 1);
   $pdf->Cell(0, 10, 'Explicar: ' . $row['explicar'], 0, 1);
   $pdf->Cell(0, 10, 'Elaborar: ' . $row['elaborar'], 0, 1);
   $pdf->Cell(0, 10, 'Evaluar: ' . $row['evaluar'], 0, 1);
   $pdf->Cell(0, 10, 'Extender: ' . $row['extender'], 0, 1);
   // Agregar más datos si es necesario
   // ...
   $pdf->Ln(); // Agregar salto de línea entre registros
}

// Salida del PDF
$pdf->Output('D','secuencia.pdf');
// Importante: No debe haber ninguna salida (echo, print, etc.) después de este punto
?>