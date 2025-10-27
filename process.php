<?php
require __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$input = [
    'nombre'   => trim($_POST['nombre'] ?? ''),
    'grupo'    => trim($_POST['grupo'] ?? ''),
    'email'    => trim($_POST['email'] ?? ''),
    'positivo' => trim($_POST['positivo'] ?? ''),
    'negativo' => trim($_POST['negativo'] ?? ''),
    'motivo'   => trim($_POST['motivo'] ?? ''),
    'rol_habitual' => $_POST['rol_habitual'] ?? '',
    'lenguaje_fuerte' => $_POST['lenguaje_fuerte'] ?? '',
    'fecha_respuesta' => $_POST['fecha_respuesta'] ?? ''
];

$errors = [];

if (strlen($input['nombre']) < 3) {
    $errors['nombre'] = 'El nombre debe tener al menos 3 caracteres.';
}
if ($input['positivo'] === '') {
    $errors['positivo'] = 'Debes indicar con quién te gusta trabajar.';
}
if ($input['negativo'] === '') {
    $errors['negativo'] = 'Debes indicar con quién prefieres no trabajar.';
}

if ($errors) {
    $old_field = $input;
    include __DIR__ . '/includes/header.php';
    echo "<h2>Corrige los errores y vuelve a intentarlo.</h2>";
    include __DIR__ . '/index.php';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$file = __DIR__ . '/data/sociograma.json';
$todo = load_json($file);

$registro = $input;
$registro['fecha_guardado'] = date('Y-m-d H:i:s');

$todo[] = $registro;
save_json($file, $todo);

include __DIR__ . '/includes/header.php';
?>
<h2>Gracias, <?= htmlspecialchars($input['nombre']) ?>. Tus datos se han guardado correctamente.</h2>
<p>Total de respuestas guardadas: <strong><?= count($todo) ?></strong></p>
<p><a href="index.php">Volver al formulario</a></p>
<p>Ver todas las respuestas en JSON: <a href="api.php">api.php</a></p>
<?php include __DIR__ . '/includes/footer.php'; ?>
