<?php

class SalaModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=tpe1;charset=utf8', 'root', '');
    }

    public function getAll() {
        $query = $this->db->prepare('SELECT * FROM salas');
        $query->execute();
        $salas = $query->fetchAll(PDO::FETCH_OBJ);
        return $salas;
    }

    public function get($id) {
        $query = $this->db->prepare('SELECT * FROM salas WHERE id = ?');
        $query->execute([$id]);
        $sala = $query->fetch(PDO::FETCH_OBJ);
        return $sala;
    }

    public function insert($nombre, $capacidad){
        $query=$this->db->prepare('INSERT INTO salas (nombre, capacidad) VALUES(?, ?)');
        $query->execute([$nombre, $capacidad]);
        return $this->db->lastInsertId();
    }

    public function update($id, $nombre, $capacidad){
        $query=$this->db->prepare('UPDATE salas SET nombre = ?, capacidad = ? WHERE id = ?');
        return $query->execute([$nombre, $capacidad, $id]);
    }
}