<?php
$host = "localhost";
$dbname = "db_sistema_web";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id_usuario, nombre, correo, activo, fecha_creacion FROM usuarios ORDER BY id_usuario DESC";
    $stmt = $pdo->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error al conectar con la base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios Registrados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container-wide">
    <h2>Usuarios Registrados</h2>
    
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Correo Electrónico</th>
                    <th>Estado</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: #6b7280;">No hay usuarios registrados todavía.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($usuario['id_usuario']); ?></strong></td>
                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                            <td><span class="badge"><?php echo $usuario['activo'] ? 'Activo' : 'Inactivo'; ?></span></td>
                            <td><?php echo htmlspecialchars($usuario['fecha_creacion']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="index.html" class="btn-secondary" style="max-width: 200px; margin: 20px auto 0 auto;">Volver al Formulario</a>
</div>

</body>
</html>
