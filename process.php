<?php
require __DIR__ . '/includes/function.php';

$base_file = __DIR__ . '/data/preguntas.json';
$respuestas_file = __DIR__ . '/data/sociograma.json';

$base = load_json($base_file);

$nuevo = [];

foreach ($base as $campo => $info) {
    if ($campo === 'preguntas') {
        $nuevo['preguntas'] = [];
        foreach ($info as $index => $preg) {
            $name = 'pregunta' . ($index + 1);
            $respuesta = $_POST[$name] ?? '';
            $nuevo['preguntas'][] = [
                'texto' => $preg['texto'],
                'respuesta' => $respuesta,
                'tipo' => $preg['tipo'],
                'opciones' => $preg['opciones']
            ];
        }
    } else {
        if ($info['tipo'] === 'checkbox') {
            $nuevo[$campo] = $_POST[$campo] ?? [];
        } else {
            $nuevo[$campo] = $_POST[$campo] ?? '';
        }
    }
}

// Guardar respuestas
$respuestas = load_json($respuestas_file);
$respuestas[] = $nuevo;
save_json($respuestas_file, $respuestas);

echo "<h2>¡Gracias por enviar tu formulario!</h2>";
echo "<p>Tu respuesta ha sido guardada correctamente.</p>";
echo "<a href='index.php'>Volver al formulario</a>";
