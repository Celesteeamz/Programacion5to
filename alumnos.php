<?php
echo "<div class='container mt-5'>";
echo "<h3 class='mb-4'>Alumnos Registrados</h3>";

if (!empty($students)) {
    // Agrupar alumnos por curso
    $porCurso = [];
    foreach ($students as $alumno) {
        $curso = $alumno['curso'] ?? 'Sin curso';
        $porCurso[$curso][] = $alumno;
    }

    ksort($porCurso);
    foreach ($porCurso as $curso => $grupo) {
        echo "<div class='card mb-4'>";
        echo "<div class='card-header bg-primary text-white'><strong>Curso $curso</strong></div>";
        echo "<div class='card-body'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Nombre</th><th>DNI</th><th>Fecha de Nacimiento</th><th>Acción</th></tr></thead><tbody>";
        foreach ($grupo as $a) {
            $nombre = htmlspecialchars($a['nombre'] ?? '');
            $dni = htmlspecialchars($a['dni'] ?? '');
            $fecha = htmlspecialchars($a['fecha'] ?? '');
            echo "<tr>
                    <td>$nombre</td>
                    <td>$dni</td>
                    <td>$fecha</td>
                    <td>
                        <a href='?eliminar=$dni' class='btn btn-danger btn-sm'>Eliminar</a>
                    </td>
                 </tr>";
        }
        echo "</tbody></table></div></div></div>";
    }
} else {
    echo "<p class='text-muted'>No hay alumnos registrados todavía.</p>";
}
echo "</div>";
?>
