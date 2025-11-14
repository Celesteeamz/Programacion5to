<?php
//Celeste Muñoz. 
//Registro de alumnos.
//Este proyecto es una aplicación web desarrollada en PHP que permite registrar, administrar y buscar alumnos de una institución educativa.
include 'clases/estudiante.php';

$dataFile = 'data/students.json';

// Crear carpeta y archivo si no existen
if (!file_exists('data')) mkdir('data', 0777, true);
if (!file_exists($dataFile)) file_put_contents($dataFile, json_encode([]));

// Cargar alumnos
$students = json_decode(file_get_contents($dataFile), true) ?? [];

// --- AGREGAR ALUMNO ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['accion'] ?? '') === 'agregar') {
    $nombre = trim($_POST['nombre'] ?? '');
    $dni    = trim($_POST['dni'] ?? '');
    $fecha  = trim($_POST['fecha'] ?? '');
    $curso  = trim($_POST['curso'] ?? '');

    if ($nombre && $dni && $fecha && $curso) {
        $nuevo = new Estudiante($nombre, $dni, $fecha, $curso);
        $students[] = $nuevo->toArray();
        file_put_contents($dataFile, json_encode($students, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo "<script>showToast('Alumno agregado correctamente');</script>";
    } else {
        echo "<script>showToast('Completá todos los campos');</script>";
    }
}

// --- ELIMINAR ALUMNO ---
if (isset($_GET['eliminar'])) {
    $dniEliminar = $_GET['eliminar'];
    $students = array_filter($students, fn($a) => $a['dni'] !== $dniEliminar);
    file_put_contents($dataFile, json_encode(array_values($students), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "<script>showToast('Alumno eliminado');</script>";
}

// --- BÚSQUEDA ---
$busqueda = strtolower(trim($_GET['buscar'] ?? ''));
if ($busqueda) {
    $students = array_filter($students, function ($a) use ($busqueda) {
        return str_contains(strtolower($a['nombre']), $busqueda) || str_contains(strtolower($a['dni']), $busqueda);
    });
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro de Alumnos </title>
<style>
/* Fondo y tipografía */
body {
    margin:0; padding:0; background: #2a292c;
    font-family:Poppins,sans-serif; color:#e7e7e7;
}
.container { width:90%; max-width:1000px; margin:40px auto; }

/* Card */
.card {
    background: rgba(20,22,28,0.85);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    padding:25px;
    border-radius:16px;
    margin-bottom:28px;
    border:1px solid rgba(255,255,255,0.12);
    box-shadow:0 6px 20px rgba(0,0,0,0.55);
}
.card h2,h3 { margin-top:0; color:#fff; }

/* Formulario alineado */
.form-row { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:15px; }
.form-col { flex:1; min-width:150px; display:flex; flex-direction:column; }
.form-col.button-col { flex:0 0 50px; }

/* Inputs y select */
input, select {
    padding:12px; border-radius:10px; background:rgba(255,255,255,0.08);
    color:#fff; border:1px solid rgba(255,255,255,0.25); font-size:15px; outline:none;
}
input::placeholder, select::placeholder { color:#bbb; }
input:focus, select:focus { border-color:#4f8cff; box-shadow:0 0 8px rgba(79,140,255,0.6); }

/* Select con opciones */
select option { background:#1a1d23; color:#fff; }

button {
    background:#4f8cff; color:#fff; padding:12px; border:none;
    border-radius:10px; font-weight:600; cursor:pointer; transition:0.2s;
}
button:hover { background:#6aa0ff; }

/* Tabla */
table { width:100%; border-collapse:collapse; margin-top:10px; }
table th, table td { padding:10px; text-align:left; border-bottom:1px solid rgba(255,255,255,0.1); }
table th { background:rgba(255,255,255,0.08); }

.toast {
    position:fixed; top:20px; right:20px; background:#3ae8a9; color:#083c2c;
    padding:10px 16px; border-radius:8px; font-weight:600; font-size:14px;
    box-shadow:0 4px 12px rgba(0,0,0,0.35); opacity:0; transform:translateY(-10px);
    transition:opacity 0.4s ease, transform 0.4s ease; z-index:9999;
}
.toast.show { opacity:1; transform:translateY(0); }
</style>
</head>
<body>
<div class="container">
<div class="text-center mb-4">
    <img src="img/proaLogo.png" alt="Logo PROA" 
         style="width: 90px; margin-bottom: 10px; filter: drop-shadow(0 0 8px rgba(255,255,255,0.25));">
    <h2 style="margin-top: 8px;">Registro de Alumnos</h2>
</div>

<!-- Formulario -->
<form method="POST" class="card">
<input type="hidden" name="accion" value="agregar">
<div class="form-row">
    <div class="form-col">
        <label>Nombre Completo</label>
        <input type="text" name="nombre" placeholder="Nombre completo" required>
    </div>
    <div class="form-col">
        <label>DNI</label>
        <input type="number" name="dni" maxlength="7" placeholder="DNI" required>
    </div>
    <div class="form-col">
        <label>Fecha de nacimiento</label>
        <input type="date" name="fecha" required>
    </div>
    <div class="form-col">
        <label>Curso</label>
        <select name="curso" required>
            <option value="">Seleccionar...</option>
            <?php for($i=1;$i<=6;$i++): ?>
                <option value="<?= $i ?>"><?= $i ?>°</option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="form-col button-col">
        <button type="submit">+</button>
    </div>
</div>
</form>

<!-- Buscador -->
<form method="GET" class="card" style="margin-bottom:20px;">
<div class="form-row">
    <div class="form-col">
        <input type="text" name="buscar" placeholder="Buscar por nombre o DNI" value="<?= htmlspecialchars($busqueda) ?>">
    </div>
    <div class="form-col button-col">
        <button type="submit">Buscar</button>
    </div>
    <div class="form-col button-col">
        <a href="index.php" style="padding:12px 18px; background:#555; color:#fff; border-radius:10px; text-decoration:none;">Limpiar</a>
    </div>
</div>
</form>

<!-- Listado de alumnos -->
<?php
if(!empty($students)):
    $porCurso=[];
    foreach($students as $a){ $curso=$a['curso'] ?? 'Sin curso'; $porCurso[$curso][]=$a; }
    ksort($porCurso);
    foreach($porCurso as $curso=>$grupo):
?>
<div class="card">
<h3>Curso <?= $curso ?></h3>
<table>
<thead><tr><th>Nombre</th><th>DNI</th><th>Fecha Nac.</th><th>Acción</th></tr></thead>
<tbody>
<?php foreach($grupo as $alumno): ?>
<tr>
<td><?= htmlspecialchars($alumno['nombre']) ?></td>
<td><?= htmlspecialchars($alumno['dni']) ?></td>
<td><?= htmlspecialchars($alumno['fecha']) ?></td>
<td><a href="?eliminar=<?= $alumno['dni'] ?>" style="color:#ff4f4f; text-decoration:none;">Eliminar</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php endforeach; else: ?>
<p class="card">No hay alumnos registrados.</p>
<?php endif; ?>
</div>

<script>
// Toast 
function showToast(msg){
    let t=document.createElement('div');
    t.className='toast';
    t.textContent=msg;
    document.body.appendChild(t);
    setTimeout(()=>t.classList.add('show'),10);
    setTimeout(()=>{
        t.classList.remove('show');
        setTimeout(()=>t.remove(),400);
    },1000);
}
</script>
</body>
</html>

