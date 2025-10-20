<?php
class SalaView {
    public function showSalas($salas, $user) {
        require_once './app/views/layout/header.phtml';
        require_once './app/views/sala_list.phtml';
        require_once './app/views/layout/footer.phtml';
    }

    public function showAdminSalas($salas, $user) {
        require_once './app/views/layout/header.phtml';
        require_once './app/views/admin_sala_list.phtml';
        require_once './app/views/layout/footer.phtml';
    }

    public function showSalaForm($sala, $user, $error = null) {
        require_once './app/views/layout/header.phtml';
        require_once './app/views/sala_form.phtml';
        require_once './app/views/layout/footer.phtml';
    }
}