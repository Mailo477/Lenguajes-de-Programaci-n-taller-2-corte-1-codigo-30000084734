<?php
$connect = mysqli_connect('localhost', 'root', '', 'formulario');

$email = isset($_POST['email']) ? $_POST['email'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';
$cliente = isset($_POST['cliente']) ? $_POST['cliente'] : '';
$departamento = isset($_POST['departamento']) ? $_POST['departamento'] : '';

$email_error = '';
$message_error = '';
$cliente_error = '';
$departamento_error = '';

// Define los arreglos de empleados por departamento
$empleadosAtencionCliente = ['Maria Becerra', 'Julian Corredor', 'Natalia Acosta', 'Jaider Morales'];
$empleadosSoporteTecnico = ['Jaime Rubiano', 'Maria Garcia', 'Pedro Sanchez', 'Arley Ramirez'];
$empleadosFacturacion = ['Gabriel Barrera', 'Jose Lopez', 'Camilo Lopez', 'Wendy Dueñas'];

if (count($_POST)) {
    $errors = 0;

    if ($_POST['email'] == '') {
        $email_error = 'Por favor ingrese una dirección de Email';
        $errors++;
    }

    if ($_POST['message'] == '') {
        $message_error = 'Por favor ingrese un mensaje';
        $errors++;
    }

    if ($_POST['cliente'] == '') {
        $cliente_error = 'Por favor ingrese su nombre';
        $errors++;
    }

    if ($_POST['departamento'] == '') {
        $departamento_error = 'Por favor seleccione un departamento';
        $errors++;
    }

    if ($errors == 0) {
        $empleado = '';

        if ($departamento == 'AtencionCliente') {
            $empleado = $empleadosAtencionCliente[array_rand($empleadosAtencionCliente)];
        } elseif ($departamento == 'SoporteTecnico') {
            $empleado = $empleadosSoporteTecnico[array_rand($empleadosSoporteTecnico)];
        } elseif ($departamento == 'Facturacion') {
            $empleado = $empleadosFacturacion[array_rand($empleadosFacturacion)];
        }

        $query = 'INSERT INTO contact (
                email,
                message,
                nombre,
                departamento,
                empleado
            ) VALUES (
                "' . addslashes($_POST['email']) . '",
                "' . addslashes($_POST['message']) . '",
                "' . addslashes($_POST['cliente']) . '",
                "' . addslashes($_POST['departamento']) . '",
                "' . addslashes($empleado) . '"
            )';
        mysqli_query($connect, $query);

        $case_number = mysqli_insert_id($connect);

        $message = 'You have received a contact form submission:

Email: ' . $_POST['email'] . '
Message: ' . $_POST['message'];

        mail('poveda.geovanny@hotmail.com',
            'Contact Form Submission',
            $message);

        header('Location: thankyou.php?case=' . $case_number);
        die();
    }
}
?>
<!doctype html>
<html>
<head>
    <title>PHP Contact Form</title>
</head>
<body>

<h1>PHP Contact Form</h1>

<form method="post" action="index.php">
    Email Address:
    <br>
    <input type="text" name="email" value="<?php echo $email; ?>">
    <?php echo $email_error; ?>

    <br><br>

    Message:
    <br>
    <textarea name="message"><?php echo $message; ?></textarea>
    <?php echo $message_error; ?>

    <br><br>

    Nombre:
    <br>
    <input type="text" name="cliente" value="<?php echo $cliente; ?>">
    <?php echo $cliente_error; ?>

    <br><br>

    Departamento:
    <br>
    <select name="departamento">
        <option value="" <?php if ($departamento == '') echo 'selected="selected"'; ?>>Select Department</option>
        <option value="AtencionCliente" <?php if ($departamento == 'AtencionCliente') echo 'selected="selected"'; ?>>Atención al Cliente</option>
        <option value="SoporteTecnico" <?php if ($departamento == 'SoporteTecnico') echo 'selected="selected"'; ?>>Soporte Técnico</option>
        <option value="Facturacion" <?php if ($departamento == 'Facturacion') echo 'selected="selected"'; ?>>Facturación</option>
    </select>
    <?php echo $departamento_error; ?>

    <br><br>

    <input type="submit" value="Submit">

</form>

</body>
</html>
