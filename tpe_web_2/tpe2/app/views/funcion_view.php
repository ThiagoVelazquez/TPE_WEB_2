<?php
class FuncionView {
    public function showFunciones($funciones, $user) {
        require_once './app/views/layout/header.phtml';
        require_once './app/views/funcion_list.phtml';
        require_once './app/views/layout/footer.phtml';
    }

    public function showFuncion($funcion, $user) {
        require_once './app/views/layout/header.phtml';
        require_once './app/views/funcion_detail.phtml';
        require_once './app/views/layout/footer.phtml';
    }

    public function showFuncionesPorSala($funciones, $sala, $user) {
        require_once './app/views/layout/header.phtml';
        require_once './app/views/funciones_por_sala.phtml';
        require_once './app/views/layout/footer.phtml';
    }

    public function showAdminFunciones($funciones, $user) {
        require_once './app/views/layout/header.phtml';
        require_once './app/views/admin_funcion_list.phtml';
        require_once './app/views/layout/footer.phtml';
    }

    public function showFuncionForm($salas, $funcion, $user, $error = null) {
        require_once './app/views/layout/header.phtml';
        require_once './app/views/funcion_form.phtml';
        require_once './app/views/layout/footer.phtml';
    }
}