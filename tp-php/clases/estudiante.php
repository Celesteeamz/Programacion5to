<?php
class Estudiante {
    public $nombre;
    public $dni;
    public $fecha;
    public $curso;

    public function __construct($nombre, $dni, $fecha, $curso) {
        $this->nombre = $nombre;
        $this->dni = $dni;
        $this->fecha = $fecha;
        $this->curso = $curso;
    }

    public function toArray() {
        return [
            'nombre' => $this->nombre,
            'dni' => $this->dni,
            'fecha' => $this->fecha,
            'curso' => $this->curso
        ];
    }
}
