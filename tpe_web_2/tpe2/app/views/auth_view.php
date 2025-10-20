<?php
class AuthView {
    public function showLogin($error, $user) {
        require_once './app/views/layout/header.phtml';
        require_once './app/views/login_form.phtml';
        require_once './app/views/layout/footer.phtml';
    }
}