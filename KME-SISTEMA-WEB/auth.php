<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estaLogueado() {
    return isset($_SESSION["usuario_autenticado"]) && $_SESSION["usuario_autenticado"] === true;
}

function require_login() {
    if (!estaLogueado()) {
        header("Location: login.php");
        exit;
    }
}