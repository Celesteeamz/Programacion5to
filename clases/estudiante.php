<?php
// Clase Estudiante – POO con métodos, getters/setters y métodos estáticos

class Estudiante {
    private $nombre;
    private $dni;
    private $fecha;
    private $curso;

    // Propiedad estática de ejemplo (contador de alumnos creados)
    private static $contador = 0;

    public function __construct($nombre, $dni, $fecha, $curso) {
        $this->setNombre($nombre);
        $this->setDni($dni);
        $this->setFecha($fecha);
        $this->setCurso($curso);

        self::$contador++;
    }

    // Getters
    public function getNombre() { return $this->nombre; }
    public function getDni() { return $this->dni; }
    public function getFecha() { return $this->fecha; }
    public function getCurso() { return $this->curso; }

    // Setters con validaciones mínimas
    public function setNombre($nombre) { $this->nombre = trim($nombre); }
    
    public function setDni($dni) {
        $dni = trim($dni);
        $this->dni = $dni;
    }

    public function setFecha($fecha) { $this->fecha = $fecha; }
    public function setCurso($curso) { $this->curso = $curso; }

    // Conversión a array para JSON
    public function toArray() {
        return [
            "nombre" => $this->nombre,
            "dni"    => $this->dni,
            "fecha"  => $this->fecha,
            "curso"  => $this->curso
        ];
    }

    // Validaciones estáticas
    public static function validarDni($dni) {
        return preg_match('/^[0-9]{1,7}$/', $dni);
    }

    public static function validarFecha($fecha) {
        return strtotime($fecha) <= time();
    }

    public static function getContador() {
        return self::$contador;
    }
}
