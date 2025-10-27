<?php
require __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// Variables vacías por defecto
$old_field = $old_field ?? [];
$errors = $errors ?? [];
?>

<form method="POST" action="process.php" novalidate>
    <fieldset>
        <legend>Identificación</legend>
        <label for="nombre">Tu nombre:</label>
        <input type="text" id="nombre" name="nombre" minlength="3" required
               value="<?= old_field('nombre', $old_field) ?>">
        <?= field_error('nombre', $errors) ?>

        <label for="grupo">Grupo:</label>
        <select id="grupo" name="grupo" required>
            <option value="">Selecciona...</option>
            <option value="DAW1">DAW1</option>
            <option value="DAW2">DAW2</option>
        </select>

        <label for="email">Correo (opcional):</label>
        <input type="email" id="email" name="email"
               value="<?= old_field('email', $old_field) ?>">
    </fieldset>

    <fieldset>
        <legend>Preferencias de colaboración</legend>
        <label for="positivo">¿Con quién te gusta trabajar?</label>
        <input type="text" id="positivo" name="positivo" required
               value="<?= old_field('positivo', $old_field) ?>">
        <?= field_error('positivo', $errors) ?>

        <label for="negativo">¿Con quién prefieres no trabajar?</label>
        <input type="text" id="negativo" name="negativo" required
               value="<?= old_field('negativo', $old_field) ?>">
        <?= field_error('negativo', $errors) ?>

        <label for="motivo">Motivo (opcional):</label>
        <textarea id="motivo" name="motivo"><?= old_field('motivo', $old_field) ?></textarea>
    </fieldset>

    <fieldset>
        <legend>Rol y habilidades</legend>
        <label>Rol habitual:</label>
        <label><input type="radio" name="rol_habitual" value="frontend"> Frontend</label>
        <label><input type="radio" name="rol_habitual" value="backend"> Backend</label>
        <label><input type="radio" name="rol_habitual" value="fullstack"> Fullstack</label>
        <label><input type="radio" name="rol_habitual" value="devops"> DevOps</label>

        <label for="lenguaje_fuerte">Lenguaje más fuerte:</label>
        <select id="lenguaje_fuerte" name="lenguaje_fuerte">
            <option value="">Selecciona...</option>
            <option>PHP</option>
            <option>JavaScript</option>
            <option>Python</option>
            <option>Java</option>
            <option>Otro</option>
        </select>
    </fieldset>

    <fieldset>
        <legend>Organización</legend>
        <label for="fecha_respuesta">Fecha:</label>
        <input type="date" id="fecha_respuesta" name="fecha_respuesta" required>
    </fieldset>

    <button type="submit">Enviar</button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
