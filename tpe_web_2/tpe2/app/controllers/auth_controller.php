<?php
require_once './app/models/user_model.php';
require_once './app/views/auth_view.php';

class AuthController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new AuthView();
    }

    public function showLogin($request) {
        $this->view->showLogin("", $request->user);
    }

    public function doLogin($request) {
        if(empty($_POST['nombre_usuario']) || empty($_POST['password'])) {
            $this->view->showLogin("faltan datos obligatorios", $request->user);
            return;
        }

        $usuario = $_POST['nombre_usuario'];
        $password = $_POST['password'];

        $userFromDB = $this->model->getByUsername($usuario);

        if($userFromDB && password_verify($password, $userFromDB->password)) {
            $_SESSION['USER_ID'] = $userFromDB->id;
            $_SESSION['USER_NAME'] = $userFromDB->nombre_usuario;
            header("Location: ".BASE_URL."admin_funciones");
        } else {
            $this->view->showLogin("usuario o contraseña incorrecta", $request->user);
        }
    }

    public function logout($request) {
        session_destroy();
        header("Location: ".BASE_URL."login");
    }
}