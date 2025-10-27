<?php
require __DIR__ . '/includes/function.php';
include __DIR__ . '/includes/header.php';

$preguntas_file = __DIR__ . '/data/preguntas.json';
$preguntas_data = load_json($preguntas_file);
?>
<form class="form-two-columns" action="process.php" method="post">
<form action="process.php" method="post">
<?php
foreach ($preguntas_data as $campo => $info) {
    if ($campo === 'preguntas') {
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
    } else {
        $tipo = $info['tipo'];
        $valor = $info['valor'] ?? '';
        echo "<fieldset>";
        echo "<legend>" . ucfirst(str_replace('_',' ',$campo)) . "</legend>";
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
            case 'checkbox':
                foreach ($info['opciones'] as $op) {
                    echo "<input type='checkbox' name='{$campo}[]' value='$op'> $op<br>";
                }
                break;
        }
        echo "</fieldset><br>";
    }
}
?>
<input type="submit" value="Enviar">
</form>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
