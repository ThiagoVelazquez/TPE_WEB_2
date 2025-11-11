<?php

class SalasApiController {

    private $model;
    private $view;

    public function __construct() {
        $this->model = new SalaModel();
    }

    public function getAll($request, $response) {
        $salas = $this->model->getAll();
        $response->json($salas);
    }

    public function get($request, $response) {
        $id = $request->params->ID;
        $sala = $this->model->get($id);

        if ($sala) {
            $response->json($sala);
        } else {    
            $response->json(['error'=>'Sala no encontrada'], 404);
        }
    }
}