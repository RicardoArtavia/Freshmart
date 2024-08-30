<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Nosotros</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">

   <div class="row">

      <div class="box">
         <img src="images/about-img-1.png" alt="">
         <h3>Por qué Freshmart?</h3>
         <p>FreshMart es más que un supermercado; es un destino para aquellos que buscan productos frescos, de alta calidad y a precios competitivos. Elegir FreshMart como tu supermercado preferido viene con una serie de beneficios que lo diferencian de otros en el mercado.</p>
         <a href="contact.php" class="btn">Contáctanos</a>
      </div>

      <div class="box">
       
         <h3>Te damos</h3>
         <p>Hemos diseñado nuestra tienda para ofrecer una experiencia de compra cómoda y agradable. Una plataforma de compras en línea fácil de usar, donde puedes realizar tu pedido desde la comodidad de tu hogar.  </p>
         <a href="shop.php" class="btn">Nuestra Tienda</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">Reseñas de clientes</h1>

   <div class="box-container">

      <div class="box">
         <p>Todo fresco siempre</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Diego</h3>
      </div>

      <div class="box">
         <p>Me encanta el diseño</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Sabrina</h3>
      </div>

      <div class="box">
         <p>Las mejores carnes para los asados</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Leandro</h3>
      </div>

      <div class="box">
         <p>Recomiendo las frutas, siempre exóticas</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Yulissa</h3>
      </div>

      <div class="box">
         <p>Tienen una buena selección de vinos en días festivos</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Joan</h3>
      </div>

      <div class="box">
      <img src="images/pic-2.png" alt="">

         <p>Cuando quiero algo especial, siempre es Freshmart</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Marissa</h3>
      </div>

   </div>

</section>



<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>