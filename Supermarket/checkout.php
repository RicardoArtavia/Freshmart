<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name);
   $number = $_POST['number'];
   $number = filter_var($number);
   $email = $_POST['email'];
   $email = filter_var($email);
   $method = $_POST['method'];
   $method = filter_var($method);
   $address = 'flat no. '. $_POST['flat'] .' '. $_POST['city'] .' '. $_POST['state'] .' '. $_POST['country'];
   $address = filter_var($address);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if($cart_query->rowCount() > 0){
      while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
         $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].' )';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $total_products = implode(', ', $cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

   if($cart_total == 0){
      $message[] = 'carrito vacío';
   }elseif($order_query->rowCount() > 0){
      $message[] = 'orden ya fue realizada!';
   }else{
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);
      $message[] = 'orden realizada con éxito!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart_items->execute([$user_id]);
      if($select_cart_items->rowCount() > 0){
         while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span>(<?= '$'.$fetch_cart_items['price'].'/- x '. $fetch_cart_items['quantity']; ?>)</span> </p>
   <?php
    }
   }else{
      echo '<p class="empty">tu carrito está vacío!</p>';
   }
   ?>
   <div class="grand-total">total : <span>₡<?= $cart_grand_total; ?>/-</span></div>
</section>

<section class="checkout-orders">

   <form action="" method="POST">

      <h3>Completa tu orden</h3>

      <div class="flex">
         <div class="inputBox">
            <span>nombre del cliente :</span>
            <input type="text" name="name"  class="box" required>
         </div>
         <div class="inputBox">
            <span>teléfono :</span>
            <input type="number" name="number"  class="box" required>
         </div>
         <div class="inputBox">
            <span>correo electrónico :</span>
            <input type="email" name="email"  class="box" required>
         </div>
         <div class="inputBox">
            <span>método de pago:</span>
            <select name="method" class="box" required>
               <option value="credit card">tarjeta</option>
               <option value="cash on delivery">efectivo contra entrega</option>
            </select>
         </div>
         <div class="inputBox">
            <span>dirección 1 :</span>
            <input type="text" name="flat"  class="box" required>
         </div>
         <div class="inputBox">
            <span>ciudad :</span>
            <input type="text" name="city"  class="box" required>
         </div>
         <div class="inputBox">
            <span>provincia :</span>
            <input type="text" name="state"  class="box" required>
         </div>
         <div class="inputBox">
            <span>país :</span>
            <input type="text" name="country"  class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="Realizar orden">

   </form>

</section>








<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>