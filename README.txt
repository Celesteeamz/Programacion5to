PROYECTO: Sistema de Registro de Alumnos (PHP + JSON)

------------------------------------
DESCRIPCIÓN DEL TEMA ELEGIDO
------------------------------------
El proyecto consiste en un sistema web para registrar alumnos utilizando PHP.
Los datos se almacenan en un archivo JSON que actúa como una base de datos.
El sistema permite:

• Agregar alumnos
• Listarlos organizados por curso
• Buscar por nombre o DNI
• Eliminar registros
• Mostrar notificaciones breves y no invasivas

El diseño utiliza estilo oscuro, formularios responsivos y un toast de mensajes.

------------------------------------
CÓMO EJECUTAR EL PROYECTO
------------------------------------
1. Instalar XAMPP, WAMP o Laragon.
2. Copiar la carpeta "proyecto-alumnos" dentro de:
   - Windows: C:/xampp/htdocs/
   - Linux: /opt/lampp/htdocs/
   - Laragon: C:/laragon/www/
3. Asegurarse de que la carpeta /data tenga permisos de escritura.
4. Abrir en el navegador:

   http://localhost/proyecto-alumnos/index.php

El proyecto no requiere base de datos, solo PHP 7.4+.

------------------------------------
FUNCIONES, ARRAYS Y CLASES IMPLEMENTADAS
------------------------------------

CLASES:
- Estudiante (clases/estudiante.php)
    • Atributos: nombre, dni, fecha, curso
    • Método: toArray() → convierte el objeto a array para guardarlo en JSON

ARRAYS:
- $students → contiene todos los alumnos cargados desde students.json
- $porCurso → agrupa los alumnos por curso para mostrarlos ordenados

FUNCIONES (PHP):
- file_get_contents() → leer el JSON
- file_put_contents() → guardar alumnos en el JSON
- json_decode() / json_encode() → procesar el archivo JSON
- array_filter() → buscar y eliminar alumnos
- ksort() → ordenar los cursos

FUNCIONES (JavaScript):
- showToast() → muestra notificaciones cortas y automáticas

Estructura
TP-PHP/
│
|__ assets/
│   |_ style.css
│   |_ script.js
|
|_ clases/
│   |_ estudiante.php
|
├── data/
│   |_ students.json
|
|_ img/
|   |_proaLogo.png
|
├── includes/
│   |_ header.php
│   |_ footer.php
|
├── index.php
└── README.txt
