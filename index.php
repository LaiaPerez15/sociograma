<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="process.php">
        <label>Tu nombre:</label>
        <input type="text" name="nombre" required minlength=3>

        <label>¿Con quién te gusta trabajar?</label>
        <input type="text" name="positivo" required>

        <label>¿Con quién prefieres no trabajar?</label>
        <input type="text" name="negativo" required>

        <label>Motivo:</label>
        <textarea name="motivo"></textarea>

            // mas inputs please

        <button type="submit">Enviar</button>
    </form>
</body>
</html>
