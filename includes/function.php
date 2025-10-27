<?php
// Cargar un archivo JSON
function load_json(string $path): array {
    if (!file_exists($path)) return [];
    $raw = file_get_contents($path);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

// Guardar un array en un archivo JSON
function save_json(string $path, array $data): bool {
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents($path, $json) !== false;
}

// Valor anterior del campo (rehidratación)
function old_field(string $name, array $source = []): string {
    return htmlspecialchars($source[$name] ?? '', ENT_QUOTES, 'UTF-8');
}

// Mostrar error debajo del campo
function field_error(string $name, array $errors = []): string {
    return isset($errors[$name]) ? "<p class='error'>{$errors[$name]}</p>" : "";
}
?>
