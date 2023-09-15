<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
</head>
<body>
    <h1>Thank You for Your Submission</h1>
    
    <?php
    // Conecta a la base de datos y obtiene los datos según el número de caso
    $case_number = $_GET['case'];
    $db_connect = mysqli_connect('localhost', 'root', '', 'formulario');

    if ($db_connect) {
        $query = "SELECT nombre, departamento, empleado FROM contact WHERE id = $case_number";
        $result = mysqli_query($db_connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $cliente = $row['nombre'];
            $departamento = $row['departamento'];
            $empleado = $row['empleado'];
            
            echo "<p>Buenas tardes, señor " . $cliente . "</p>";
            echo "<p>Gracias por confiar en CONSULTORA SAS. Su Solicitud ha sido recibida y se ha abierto un ticket con id número " . $case_number . " desde el departamento de " . $departamento . " y será atendido por " . $empleado . ".</p>";
        } else {
            echo "<p>No se pudo encontrar información para el caso número " . $case_number . ".</p>";
        }
    } else {
        echo "<p>Error de conexión a la base de datos.</p>";
    }
    ?>
    
    <p><a href="index.php">Back to Home</a></p>
</body>
</html>
