<?php
require __DIR__ . '/includes/functions.php';
// 1) Aceptamos solo POST. Si no, volvemos al formulario.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}
// 2) Recoger y limpiar lo mínimo (trim para quitar espacios)
$input = [
    'nombre' => trim($_POST['nombre'] ?? ''),
    'positivo' => trim($_POST['positivo'] ?? ''),
    'negativo' => trim($_POST['negativo'] ?? ''),
    'motivo' => trim($_POST['motivo'] ?? '')
];
// 3) Validar (muy básico)
$errors = [];
if (strlen($input['nombre']) < 3) {
    $errors['nombre'] = 'El nombre debe tener al menos 3 caracteres.';
}
if ($input['positivo'] === '') {
    $errors['positivo'] = 'Indica al menos una persona con la que te gusta trabajar.';
}
if ($input['negativo'] === '') {
    $errors['negativo'] = 'Indica al menos una persona con la que prefieres no trabajar.';
}
// 4) Si hay errores: rehidratar (volver a index con $old_field y $errors)
if ($errors) {
    // IMPORTANTE: definimos $old_field y $errors antes de incluir index.php
    $old_field = $input;
    include __DIR__ . '/includes/header.php';
    // Reutilizamos el mismo index para no duplicar el formulario:
    // truco simple: hacemos include del formulario “central”
    // Si prefieres, puedes extraer el <form> a partials/form.php y requerirlo aquí.
?>
    <main class="container">
        <h1>Sociograma DAW</h1>
        <p>Corrige los errores e inténtalo de nuevo.</p>
        <form method="POST" action="process.php" novalidate>
            <label>Tu nombre:</label>
            <input type="text" name="nombre" value="<?= old_field('nombre', $old_field) ?>">
            <?= field_error('nombre', $errors) ?>
            <label>¿Con quién te gusta trabajar?</label>
            <input type="text" name="positivo" value="<?= old_field('positivo', $old_field) ?>">
            <?= field_error('positivo', $errors) ?>
            <label>¿Con quién prefieres no trabajar?</label>
            <input type="text" name="negativo" value="<?= old_field('negativo', $old_field) ?>">
            <?= field_error('negativo', $errors) ?>
            <label>Motivo (opcional):</label>
            <textarea name="motivo"><?= old_field('motivo', $old_field) ?></textarea>
            <?= field_error('motivo', $errors) ?>
            <button type="submit">Enviar</button>
        </form>
    </main>
<?php
    include __DIR__ . '/includes/footer.php';
    exit;
}
// 5) Si todo está bien: guardar en JSON y confirmar
$file = __DIR__ . '/data/sociograma.json';
$todo = load_json($file);
$registro = [
    'nombre' => $input['nombre'],
    'positivo' => $input['positivo'],
    'negativo' => $input['negativo'],
    'motivo' => $input['motivo'],
    'fecha' => date('Y-m-d H:i:s')
];
$todo[] = $registro;
if (!save_json($file, $todo)) {
    http_response_code(500);
    echo 'Error guardando los datos. Inténtalo más tarde.';
    exit;
}
// 6) Confirmación muy simple
include __DIR__ . '/includes/header.php';
?>
<main class="container">
    <h2>Gracias, <?= htmlspecialchars($input['nombre']) ?>. Tu respuesta se ha guardado correctamente.</h2>
    <p>Total de respuestas recogidas: <strong><?= count($todo) ?></strong></p>
    <p><a href="index.php">Volver al formulario</a></p>
    <p>También puedes ver todas las respuestas en JSON: <a href="api.php">api.php</a></p>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>