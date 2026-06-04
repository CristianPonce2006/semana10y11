<?php

/**
 * Inicia o reanuda la sesión.
 */
session_start();

/**
 * Se importa la clase UsuarioNegocio.
 */
require_once __DIR__ . '/../negocio/UsuarioNegocio.php';

/**
 * Verifica que el archivo sea ejecutado mediante POST.
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

/**
 * Verifica que existan los campos usuario y password.
 */
if (!isset($_POST['usuario']) || !isset($_POST['password'])) {
    header('Location: login.php?mensaje=Debe completar todos los campos');
    exit;
}

/**
 * Recibe y limpia los datos enviados desde el formulario.
 */
$usuario = trim($_POST['usuario']);
$password = trim($_POST['password']);

/**
 * Valida que los campos no estén vacíos.
 */
if (empty($usuario) || empty($password)) {
    header('Location: login.php?mensaje=Debe ingresar usuario y contraseña');
    exit;
}

/**
 * Crea una instancia de la capa de negocio.
 */
$usuarioNegocio = new UsuarioNegocio();

/**
 * Valida las credenciales del usuario.
 */
$datosUsuario = $usuarioNegocio->validarLogin($usuario, $password);

/**
 * Si las credenciales son incorrectas, retorna al login.
 */
if ($datosUsuario === null) {
    header('Location: login.php?mensaje=Usuario o contraseña incorrectos');
    exit;
}

/**
 * Regenera el ID de sesión para evitar fijación de sesión.
 */
session_regenerate_id(true);

/**
 * Guarda los datos principales del usuario autenticado.
 */
$_SESSION['idUsuario'] = $datosUsuario['IdUsuario'];
$_SESSION['nombreCompleto'] = $datosUsuario['NombreCompleto'];
$_SESSION['usuario'] = $datosUsuario['Usuario'];
$_SESSION['tipoCuenta'] = $datosUsuario['TipoCuenta'];

/**
 * Redirecciona según el tipo de cuenta.
 */
if ($datosUsuario['TipoCuenta'] === 'ADMINISTRADOR') {
    header('Location: admin/index.php');
    exit;
}

if ($datosUsuario['TipoCuenta'] === 'VENDEDOR') {
    header('Location: vendedor/index.php');
    exit;
}

header('Location: login.php?mensaje=Tipo de cuenta no válido');
exit;
