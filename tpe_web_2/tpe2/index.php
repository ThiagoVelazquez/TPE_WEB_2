<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/app/controllers/sala_controller.php';
require_once __DIR__ . '/app/controllers/funcion_controller.php';
require_once __DIR__ . '/app/controllers/auth_controller.php';
require_once __DIR__ . '/app/middlewares/session.middleware.php';
require_once __DIR__ . '/app/middlewares/guard.middleware.php';

session_start();

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'home';
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);

$request = new StdClass();
$request = (new SessionMiddleware())->run($request);

switch ($params[0]) {
    case 'home':
        $controller = new SalaController();
        $controller->showSalas($request);
        break;
    case 'salas':
        $controller = new SalaController();
        $controller->showSalas($request);
        break;
    case 'funciones_por_sala':
        $controller = new FuncionController();
        $request->id = $params[1] ?? null;
        $controller->showFuncionesPorSala($request);
        break;
    case 'funciones':
        $controller = new FuncionController();
        $controller->showFunciones($request);
        break;
    case 'funcion':
        $controller = new FuncionController();
        $request->id = $params[1] ?? null;
        $controller->showFuncion($request);
        break;
    case 'login':
        $controller = new AuthController();
        $controller->showLogin($request);
        break;
    case 'do_login':
        $controller = new AuthController();
        $controller->doLogin($request);
        break;
    case 'logout':
        $request = (new GuardMiddleware())->run($request);
        $controller = new AuthController();
        $controller->logout($request);
        break;
    case 'admin_funciones':
        $request = (new GuardMiddleware())->run($request);
        $controller = new FuncionController();
        $controller->adminFunciones($request);
        break;
    case 'admin_funcion_add':
        $request = (new GuardMiddleware())->run($request);
        $controller = new FuncionController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->addFuncion($request);
        } else {
            $controller->showAddFuncion($request);
        }
        break;
    case 'admin_funcion_edit':
        $request = (new GuardMiddleware())->run($request);
        $controller = new FuncionController();
        $request->id = $params[1] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->editFuncion($request);
        } else {
            $controller->showEditFuncion($request);
        }
        break;
    case 'admin_funcion_delete':
        $request = (new GuardMiddleware())->run($request);
        $controller = new FuncionController();
        $request->id = $params[1] ?? null;
        $controller->deleteFuncion($request);
        break;
    case 'admin_salas':
        $request = (new GuardMiddleware())->run($request);
        $controller = new SalaController();
        $controller->adminSalas($request);
        break;
    case 'admin_sala_add':
        $request = (new GuardMiddleware())->run($request);
        $controller = new SalaController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->addSala($request);
        } else {
            $controller->showAddSala($request);
        }
        break;
    case 'admin_sala_edit':
        $request = (new GuardMiddleware())->run($request);
        $controller = new SalaController();
        $request->id = $params[1] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->editSala($request);
        } else {
            $controller->showEditSala($request);
        }
        break;
    case 'admin_sala_delete':
        $request = (new GuardMiddleware())->run($request);
        $controller = new SalaController();
        $request->id = $params[1] ?? null;
        $controller->deleteSala($request);
        break;
    default:
        echo "404 - página no encontrada";
        break;
}