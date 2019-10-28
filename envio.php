<?php 
setlocale(LC_ALL,"es_CO");
//SETEAR VARIABLES
$nombre = $_POST['nombrecompleto'];
$email = $_POST['email'];
$celular = $_POST['celular'];
//Comprobamos si se obtuvieron de manera correcta
if (isset($nombre) && !empty($nombre) && isset($email) && !empty($email) && isset($celular) && !empty($celular)) {
		$fechaactual = getdate();
		$fecha= "$fechaactual[mday]/ $fechaactual[month]/ $fechaactual[year]";
		$hora = "$fechaactual[hours]: $fechaactual[minutes]: $fechaactual[seconds]"; 
		//Conectamos a la base de datos para enviar los datos
		$conn = mysqli_connect("localhost", "root", "", "db_sonria");      
		if (!$conn) {
			die("Failed to connect: " . mysqli_connect_error());
		}
		else{  
			//Envio del mail
			//Seteo de variables para el envío del mail
			$to = "jforeroe@gmail.com";
			$subject = "Datos - Landing Sonría";
			$message = "
			<html>
			<head>
			<title>SONRIA TEST MAIL</title>
			</head>
			<body>
			<h2>Message from lead:</h2>
			<p><strong>Nombre Completo: ".$nombre."</strong></p>
			<p><strong>Email: ".$email."</strong></p>
			<p><strong>Celular: ".$celular."</strong></p>
			<p><strong>Fecha: ".$fecha."</strong></p>
			<p><strong>Hora: ".$hora."</strong></p>
			</body>
			</html>
			";
			// Enviar contenid como HTML
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// Headers de Envío
			$headers .= 'From: ZAV <info@localhost.com>' . "\r\n";
			//Realizamos la inserción de los datos
			$sql = "INSERT INTO listadeinscritos (Nombre, Correo, Celular, Fecha)
				VALUES ('$nombre','$email','$celular','$fecha')";  
			if (mysqli_query($conn, $sql)) { 
				//Si fue correcto insertamos los datos como ultima fila
				$latest_id =  mysqli_insert_id($conn);
				//Validamos el envío del mail
				if(mail($to,$subject,$message,$headers)){
					header("Location: gracias.html"); 
				}
				else{
					echo "Error enviando el mail.";
				}
			} 
			else { 
				echo "Error al guardar datos : " . $sql . "<br>" . mysqli_error($conn);
			}
		}
		//Cerrar Conexion
		mysqli_close($conn); 		
} 
else {
	echo "<h1>¡ERROR! No se ha podido procesar los datos, intente nuevamente</h1>";
}
?>