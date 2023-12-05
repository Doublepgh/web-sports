<?php 

require 'database.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Usuarios</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php 
	require 'partials/header.php'
	?>

	<?php if(!empty($message)): ?>
		<p><?= $message?></p>
		<?php
		endif
		?>

	

	<h1> Bienvenido USUARIO </h1> <br><br>
	<h2>Lista de mensajes enviados </h2>
	
	
</body>
</html>