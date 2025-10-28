<?php
require __DIR__ . '/includes/function.php';
include __DIR__ . '/includes/header.php';

$preguntas_file = __DIR__ . '/data/preguntas.json';
$preguntas_data = load_json($preguntas_file);
$total_preguntas = count($preguntas_data['preguntas']);
$mitad = ceil($total_preguntas / 2); // 10 y 10
?>

<main class="form-two-columns">
  <!-- COLUMNA IZQUIERDA: campos normales -->
  <div class="izquierda">
    <form action="process.php" method="post">
      <div class="fields-grid two-columns">
      <?php
      foreach ($preguntas_data as $campo => $info) {
          if ($campo === 'preguntas') continue;
          $tipo = $info['tipo'];
          $valor = $info['valor'] ?? '';
          $fsClass = $campo === 'observaciones' ? 'full-width' : ($tipo === 'text' ? 'half' : '');
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
                  echo "<textarea name='$campo' rows='4'>$valor</textarea>";
                  break;
              case 'select':
                  echo "<select name='$campo' required>";
                  foreach ($info['opciones'] as $op) {
                      $val = htmlspecialchars($op, ENT_QUOTES);
                      echo "<option value='$val'>$op</option>";
                  }
                  echo "</select>";
                  break;
              case 'radio':
                  foreach ($info['opciones'] as $op) {
                      $val = htmlspecialchars($op, ENT_QUOTES);
                      $labelText = ucfirst(str_replace('_',' ',$op));
                      echo "<label class='question'><input type='radio' name='$campo' value='$val' required><span>$labelText</span></label>";
                  }
                  break;
              case 'checkbox':
                  foreach ($info['opciones'] as $op) {
                      $val = htmlspecialchars($op, ENT_QUOTES);
                      echo "<label class='question'><input type='checkbox' name='{$campo}[]' value='$val'><span>" . ucfirst($op) . "</span></label>";
                  }
                  break;
          }
          echo "</fieldset>";
      }
      ?>
      </div>
      <div style="margin-top:1rem">
          <input type="submit" class="btn full-width" value="Enviar">
      </div>
    </form>
  </div>

  <!-- COLUMNA DERECHA: preguntas en 2 columnas de preguntas completas -->
  <div class="derecha">
    <div class="preguntas-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;overflow-y:auto;max-height:90vh;">
      <?php
      $col1 = array_slice($preguntas_data['preguntas'], 0, $mitad);
      $col2 = array_slice($preguntas_data['preguntas'], $mitad);

      // columna izquierda de preguntas
      echo "<div>";
      foreach ($col1 as $i => $preg) {
          echo "<fieldset><legend>{$preg['texto']}</legend>";
          echo "<div class='questions-wrap two-columns'>";
          foreach ($preg['opciones'] as $op) {
              $val = htmlspecialchars($op, ENT_QUOTES);
              $labelText = ucfirst($op);
              echo "<label class='question'><input type='radio' name='pregunta" . ($i + 1) . "' value='$val' required><span>$labelText</span></label>";
          }
          echo "</div></fieldset>";
      }
      echo "</div>";

      // columna derecha de preguntas
      echo "<div>";
      foreach ($col2 as $i => $preg) {
          $index = $i + $mitad;
          echo "<fieldset><legend>{$preg['texto']}</legend>";
          echo "<div class='questions-wrap two-columns'>";
          foreach ($preg['opciones'] as $op) {
              $val = htmlspecialchars($op, ENT_QUOTES);
              $labelText = ucfirst($op);
              echo "<label class='question'><input type='radio' name='pregunta" . ($index + 1) . "' value='$val' required><span>$labelText</span></label>";
          }
          echo "</div></fieldset>";
      }
      echo "</div>";
      ?>
    </div>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
