<?php
require_once __DIR__ . '/../models/sala_model.php';
require_once __DIR__ . '/../views/sala_view.php';

class SalaController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new SalaModel();
        $this->view = new SalaView();
    }

    public function showSalas($request) {
        $salas = $this->model->getAll();
        $this->view->showSalas($salas, $request->user);
    }

    public function adminSalas($request) {
        $salas = $this->model->getAll();
        $this->view->showAdminSalas($salas, $request->user);
    }

    public function showAddSala($request) {
        $this->view->showSalaForm(null, $request->user);
    }

    public function addSala($request) {
        if(empty($_POST['codigo_sala']) || empty($_POST['cantidad_max_personas'])) {
            $this->view->showSalaForm(null, $request->user, "Complete todos los campos");
            return;
        }

        $data = [
            'codigo_sala' => $_POST['codigo_sala'],
            'cantidad_max_personas' => $_POST['cantidad_max_personas'],
            'precio' => $_POST['precio']
        ];

        $this->model->create($data);
        header("Location: ".BASE_URL."admin_salas");
    }

    public function showEditSala($request) {
        $sala = $this->model->getById($request->id);
        $this->view->showSalaForm($sala, $request->user);
    }

    public function editSala($request) {
        if(empty($_POST['codigo_sala']) || empty($_POST['cantidad_max_personas'])) {
            $sala = $this->model->getById($request->id);
            $this->view->showSalaForm($sala, $request->user, "Complete todos los campos");
            return;
        }

        $data = [
            'codigo_sala' => $_POST['codigo_sala'],
            'cantidad_max_personas' => $_POST['cantidad_max_personas'],
            'precio' => $_POST['precio']
        ];

        $this->model->update($request->id, $data);
        header("Location: ".BASE_URL."admin_salas");
    }

    public function deleteSala($request) {
        $this->model->delete($request->id);
        header("Location: ".BASE_URL."admin_salas");
    }
}