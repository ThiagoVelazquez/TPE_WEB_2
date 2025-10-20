<?php
require_once './app/models/funcion_model.php';
require_once './app/models/sala_model.php';
require_once './app/views/funcion_view.php';

class FuncionController {
    private $model;
    private $salaModel;
    private $view;

    public function __construct() {
        $this->model = new FuncionModel();
        $this->salaModel = new SalaModel();
        $this->view = new FuncionView();
    }

    public function showFunciones($request) {
        $funciones = $this->model->getAll();
        $this->view->showFunciones($funciones, $request->user);
    }

    public function showFuncion($request) {
        $funcion = $this->model->getById($request->id);
        $this->view->showFuncion($funcion, $request->user);
    }

    public function showFuncionesPorSala($request) {
        $id_sala = $request->id;
        $sala = $this->salaModel->getById($id_sala);
        $funciones = $this->model->getBySalaId($id_sala);
        $this->view->showFuncionesPorSala($funciones, $sala, $request->user);
    }

    public function adminFunciones($request) {
        $funciones = $this->model->getAll();
        $this->view->showAdminFunciones($funciones, $request->user);
    }

    public function showAddFuncion($request) {
        $salas = $this->salaModel->getAll();
        $this->view->showFuncionForm($salas, null, $request->user);
    }

    public function addFuncion($request) {
        if(empty($_POST['nombre']) || empty($_POST['id_sala'])) {
            $salas = $this->salaModel->getAll();
            $this->view->showFuncionForm($salas, null, $request->user, "complete todos los campos");
            return;
        }

        $data = [
            'id_sala' => $_POST['id_sala'],
            'nombre' => $_POST['nombre'],
            'duracion' => $_POST['duracion'],
            'horarios' => $_POST['horarios']
        ];

        $this->model->create($data);
        header("Location: ".BASE_URL."admin_funciones");
    }

    public function showEditFuncion($request) {
        $funcion = $this->model->getById($request->id);
        $salas = $this->salaModel->getAll();
        $this->view->showFuncionForm($salas, $funcion, $request->user);
    }

    public function editFuncion($request) {
        if(empty($_POST['nombre']) || empty($_POST['id_sala'])) {
            $funcion = $this->model->getById($request->id);
            $salas = $this->salaModel->getAll();
            $this->view->showFuncionForm($salas, $funcion, $request->user, "complete todos los campos");
            return;
        }

        $data = [
            'id_sala' => $_POST['id_sala'],
            'nombre' => $_POST['nombre'],
            'duracion' => $_POST['duracion'],
            'horarios' => $_POST['horarios']
        ];

        $this->model->update($request->id, $data);
        header("Location: ".BASE_URL."admin_funciones");
    }

    public function deleteFuncion($request) {
        $this->model->delete($request->id);
        header("Location: ".BASE_URL."admin_funciones");
    }
}