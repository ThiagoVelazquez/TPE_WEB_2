<?php
require_once './app/models/funcion.model.php';

class FuncionApiController {
    private $model;
    
    public function __construct () {
        $this->model = new FuncionModel();
    }

    public function getFunciones($req, $res) {
        $sort = $req->query->sort ?? null;
        $order = $req->query->order ?? 'asc';
        $page = $req->query->page ?? 1;
        $limit = $req->query->limit ?? 10;
        $filterField = $req->query->filterField ?? null;
        $filterValue = $req->query->filterValue ?? null;

        $offset = ($page - 1) * $limit;

        $funciones = $this->model->getAll($sort, $order, $limit, $offset, $filterField, $filterValue);
        $total = $this->model->count($filterField, $filterValue);
        $totalPages = ceil($total / $limit);

        $response = [
            'data' => $funciones,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'totalPages' => $totalPages,
                'hasNext' => $page < $totalPages,
                'hasPrev' => $page > 1
            ]
        ];

        if ($filterField && $filterValue) {
            $response['filter'] = [
                'field' => $filterField,
                'value' => $filterValue
            ];
        }

        return $res->json($response);
    }

    public function getFuncion($req, $res) {
        $idFuncion = $req->params->id;
        $funcion = $this->model->get($idFuncion);

        if (!$funcion) {
            return $res->json("La función con el id=$idFuncion no existe", 404);
        }

        return $res->json($funcion);
    }

    public function updateFuncion($req, $res) {
        $idFuncion = $req->params->id;
        $funcion = $this->model->get($idFuncion);

        if (!$funcion) {
            return $res->json("La función con el id=$idFuncion no existe", 404);
        }

        if (empty($req->body->nombre) || empty($req->body->duracion) || empty($req->body->horarios) || empty($req->body->id_sala)) {
        return $res->json('Faltan datos', 400);
        }

    $nombre = $req->body->nombre;
    $duracion = $req->body->duracion;
    $horarios = $req->body->horarios;
    $id_sala = $req->body->id_sala;

    $this->model->update($idFuncion, $nombre, $duracion, $horarios, $id_sala);

    $updatedFuncion = $this->model->get($idFuncion);
    return $res->json($updatedFuncion);
}

public function deleteFuncion($req, $res) {
    $idFuncion = $req->params->id;
    $funcion = $this->model->get($idFuncion);

    if (!$funcion) {
        return $res->json("La función con el id=$idFuncion no existe", 404);
    }

    $this->model->remove($idFuncion);
    return $res->json(null, 204);
}

public function insertFuncion($req, $res) {
    if (empty($req->body->nombre) || empty($req->body->duracion) || empty($req->body->horarios) || empty($req->body->id_sala)) {
        return $res->json('Faltan datos', 400);
    }

    $nombre = $req->body->nombre;
    $duracion = $req->body->duracion;
    $horarios = $req->body->horarios;
    $id_sala = $req->body->id_sala;

    $newFuncionId = $this->model->insert($nombre, $duracion, $horarios, $id_sala);

    if ($newFuncionId == false) {
        return $res->json('Error del servidor', 500);
    }

    $newFuncion = $this->model->get($newFuncionId);
    return $res->json($newFuncion, 201);
    }
}