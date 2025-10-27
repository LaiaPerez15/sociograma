<?php
require __DIR__ . '/includes/function.php';
include __DIR__ . '/includes/header.php';

$preguntas_file = __DIR__ . '/data/preguntas.json';
$preguntas_data = load_json($preguntas_file);
?>
<form action="process.php" method="post">
<?php
// Abrimos la grid para los campos normales (no 'preguntas')
echo "<div class='fields-grid two-columns'>";
foreach ($preguntas_data as $campo => $info) {
    if ($campo === 'preguntas') {
        // cerramos la grid antes de las preguntas
        echo "</div>";
        foreach ($info as $index => $preg) {
            echo "<fieldset><legend>{$preg['texto']}</legend>";
            echo "<div class='questions-wrap two-columns'>";
            foreach ($preg['opciones'] as $opcion) {
                $val = htmlspecialchars($opcion, ENT_QUOTES);
                $labelText = ucfirst($opcion);
                echo "<label class='question'>";
                echo "<input type='radio' name='pregunta" . ($index + 1) . "' value='$val' required>";
                echo "<span>" . $labelText . "</span>";
                echo "</label>";
            }
            echo "</div>";
            echo "</fieldset>";
        }
        // reabrimos la grid para los siguientes campos
        echo "<div class='fields-grid two-columns'>";
    } else {
        $tipo = $info['tipo'];
        $valor = $info['valor'] ?? '';
        // Determinar clase del fieldset: observaciones -> full-width, campos text -> half, resto ninguno
        $fsClass = '';
        if ($campo === 'observaciones') {
            $fsClass = 'full-width';
        } elseif ($tipo === 'text') {
            $fsClass = 'half';
        }
        echo $fsClass ? "<fieldset class='$fsClass'>" : "<fieldset>";
        echo "<legend>" . ucfirst(str_replace('_', ' ', $campo)) . "</legend>";
        switch ($tipo) {
            case 'text':
            case 'number':
            case 'date':
            case 'time':
            case 'color':
                echo "<input type='$tipo' name='$campo' value='$valor' required>";
                break;
            case 'textarea':
                echo "<textarea name='$campo' rows='4' cols='50'>$valor</textarea>";
                break;
            case 'select':
                echo "<select name='$campo' required>";
                foreach ($info['opciones'] as $op) {
                    echo "<option value='$op'>$op</option>";
                }
                echo "</select>";
                break;
            case 'radio':
                // Renderizar radios como burbujas (similar a preguntas)
                foreach ($info['opciones'] as $op) {
                    $val = htmlspecialchars($op, ENT_QUOTES);
                    $labelText = ucfirst(str_replace('_',' ',$op));
                    echo "<label class='question'><input type='radio' name='$campo' value='$val' required><span>" . $labelText . "</span></label>";
                }
                break;
            case 'checkbox':
                foreach ($info['opciones'] as $op) {
                    echo "<label class='question'><input type='checkbox' name='{$campo}[]' value='$op'><span>" . ucfirst($op) . "</span></label>";
                }
                break;
        }
        echo "</fieldset>";
    }
}
// cerramos la grid si quedó abierta
echo "</div>";
?>
<div style="margin-top:1rem">
    <input type="submit" class="btn full-width" value="Enviar">
</div>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
