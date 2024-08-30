<?php 

include 'config.php';

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);

   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $cpass = md5($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);

   $image_size = $_FILES['image']['size'];

   $image_tmp_name = $_FILES['image']['tmp_name'];

   $image_folder = 'uploaded_img/'.$image;

   $select = $conn->prepare("SELECT * FROM users WHERE email = ?");
   $select->execute([$email]);

   if($select->rowCount() > 0){
      $message[] = 'Este correo ya existe!';
   } else {
      if($pass != $cpass){
         $message[] = 'Contraseñas no coinciden!';
      } else {
         $insert = $conn->prepare("INSERT INTO users (name, email, password, image) VALUES (?, ?, ?, ?)");
         $insert->execute([$name, $email, $pass, $image]);

         if($insert){
            if($image_size > 2000000){
               $message[] = 'La imagen es muy grande!';
            } else {
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'Nuevo registro exitoso!';
               
               header('location:login.php'); // redirige a nueva página
            }
         }
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">  
   <title>Registrarse</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/components.css">
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<section class="form-container">
   <form action="" enctype="multipart/form-data" method="POST">
      <h3>Crea una cuenta</h3>
      <input type="text" name="name" class="box" placeholder="ingresar nombre" required>
      <input type="email" name="email" class="box" placeholder="correo electrónico" required>
      <input type="password" name="pass" class="box" placeholder="ingresa contraseña" required>
      <input type="password" name="cpass" class="box" placeholder="confirma contraseña" required>
      <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="Registrar Usuario" class="btn" name="submit">
      <p>Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
   </form>
</section>

</body>
</html>
