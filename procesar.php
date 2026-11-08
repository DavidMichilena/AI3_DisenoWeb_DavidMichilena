<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    
    $errores = [];

  
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    } elseif (strlen($nombre) < 3 || strlen($nombre) > 100) {
        $errores[] = "El nombre debe tener entre 3 y 100 caracteres.";
    }

    if (empty($correo)) {
        $errores[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido.";
    } elseif (strlen($correo) > 150) {
        $errores[] = "El correo electrónico es demasiado largo.";
    }

   
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Resultado del Registro</title>
        <style>
            body { font-family: 'Segoe UI', sans-serif; background: #f3f4f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin:0; }
            .box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 400px; width: 100%; text-align: center; }
            .error { color: #ef4444; margin-bottom: 10px; text-align: left; }
            .success { color: #10b981; font-size: 18px; font-weight: bold; margin-bottom: 15px; }
            .btn { display: inline-block; margin-top: 25px; padding: 10px 20px; background: #4f46e5; color: white; text-decoration: none; border-radius: 5px; font-weight: 600; }
            .btn:hover { background: #4338ca; }
        </style>
    </head>
    <body>
    <div class='box'>";

    if (!empty($errores)) {
        echo "<h2>Corregir errores:</h2>";
        foreach ($errores as $error) {
            echo "<p class='error'>• " . htmlspecialchars($error) . "</p>";
        }
        echo "<a href='index.html' class='btn'>Volver a intentar</a>";
    } else {
        
        $host = "localhost";
        $dbname = "db_sistema_web";
        $username = "root"; 
        $password = "";     
        try {
          
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
           
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           
            $sql = "INSERT INTO usuarios (nombre, correo) VALUES (:nombre, :correo)";
            $stmt = $pdo->prepare($sql);

            
            $stmt->execute([
                ':nombre' => $nombre,
                ':correo' => $correo
            ]);

           
            echo "<p class='success'>¡Usuario registrado con éxito!</p>";
            echo "<p>Los datos de <strong>" . htmlspecialchars($nombre) . "</strong> han sido guardados de manera segura en la base de datos.</p>";
            echo "<a href='index.html' class='btn'>Registrar otro usuario</a>";

        } catch (PDOException $e) {
           
            echo "<h2>Error de Base de Datos</h2>";
            
            
            if ($e->errorInfo[1] == 1062) {
                echo "<p class='error'>• El correo electrónico ya se encuentra registrado por otro usuario.</p>";
            } else {
               
                echo "<p class='error'>• Hubo un problema al procesar tu solicitud. Inténtalo más tarde.</p>";
                
            }
            echo "<a href='index.html' class='btn'>Volver a intentar</a>";
        }
    }

    echo "</div></body></html>";
} else {
    
    header("Location: index.html");
    exit();
}
?>
