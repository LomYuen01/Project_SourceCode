<?php include('partials/menu.php');
    $user_id = 1; // Temporary user_id

    $sql = "SELECT carts.cart_id, carts.quantity, tbl_food.id as food_id, tbl_food.title, tbl_food.normal_price
            FROM carts
            INNER JOIN tbl_food ON carts.food_id = tbl_food.id
            WHERE carts.user_id = $user_id";
    $result = $conn->query($sql);

    $total = 0;

?>


<style>
.home {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%;
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%;
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #04AA6D;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
</style>
<form action="" method="post" style="display: flex; flex-direction: row;">
<section class="home" style="width:70%; margin-left: 10%">
  <h2 style="display: block;  font-size:larger">Checkout</h2>
  <div class="row" style="width: 100%;">
    <div class="col-75">
      <div class="container">
          <div class="row">
            <div class="col-50" >
              <h3>Address</h3>
              <label for="fname"><i class="fa fa-user"></i> Full Name</label>
              <input type="text" id="fname" name="firstname" placeholder="Aaa Bbbbb">
              <label for="email"><i class="fa fa-envelope"></i> Email</label>
              <input type="text" id="email" name="email" placeholder="abc123@example.com">
              <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
              <input type="text" id="adr" name="address" placeholder="123, adc">
              <label for="city"><i class="fa fa-institution"></i>Taman</label>
              <input type="text" id="city" name="city" placeholder="Taman Kenanga Mewah">

              <div class="row">
                <div class="col-50">
                  <label for="zip">Postcode</label>
                  <select id="zip" name="zip" required>
                      <option value="">Select a postcode</option>
                      <option value="75100">75100</option>
                      <option value="75200">75200</option>
                      <option value="75250">75250</option>
                      <option value="75300">75300</option>
                      </select>
                </div>
                <div class="col-50">
                    <label for="state">State</label>
                    <select id="state" name="state">
                    <option value="Melaka">Melaka</option>
                  </select>
                  
              </div>
              </div>
            </div>
          </div>
        </div>

<div class="container" style="margin-top:2%;">
        <div class="row">
            <div class="col-50">
              <h3>Payment</h3>
              <label for="fname">Accepted Cards</label>
              <div class="icon-container">
                <i class="fa fa-cc-visa" style="color:navy;"></i>
                <i class="fa fa-cc-amex" style="color:blue;"></i>
                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                <i class="fa fa-cc-discover" style="color:orange;"></i>
              </div>
              <label for="cname">Name</label>
              <input type="text" id="cname" name="cardname" placeholder="Hooolely">
              <div style="display: block; width: 100%;">
                  <label for="ccnum">Credit card number</label>
                  <input type="tel" name="credit_card" 
                      id="credit_card_number"
                      placeholder="Card Number:"
                      class="form-control"
                      onkeypress='return formats(this,event)'
                      onkeyup="return numberValidation(event)"
                      style="display: block;">
              </div>
              <br><br>
              <div style="display: block; width: 100%;">
                  <label for="expmonth" style="display: block;">Exp Month</label>
                  <input type="text" id="expmonth" name="expmonth" placeholder="September">
              </div>
              <div class="row">
                <div class="col-50">
                  <label for="expyear">Exp Year</label>
                  <input type="text" id="expyear" name="expyear" placeholder="2018">
                </div>
                <div class="col-50">
                  <label for="cvv">CVV</label>
                  <input type="text" id="cvv" name="cvv" placeholder="352">
                </div>  
              </div>
            </div>
            </div>
          </div>
          
          <input type="submit" value="Continue to checkout" class="btn" style="border-radius: 18px; margin-top:10%">
        
      </div>
    </div>
    
</section>
<section style="margin-top: 20%;width:80%;">
          <div class="basket" style="width:90%;">
            <div class="basket-labels">
                <ul>
                    <li class="checkbox">No.</li>
                    <li class="item item-heading">Item</li>
                    <li class="price">Price</li>
                    <li class="quantity">Quantity</li>
                    <li class="subtotal">Subtotal</li>
                </ul>

            <?php
            if ($result->num_rows > 0) 
            {
              $count = 1;
              while ($row = $result->fetch_assoc()) 
              {
                echo '<div class="basket-product">';
                echo '<ul>';
                echo '<li class="checkbox">' . $count . '</li>';
                echo '<li class="item">';
                echo '<div class="product-details">';
                echo '<h2 style="font-size: 20px;">' . $row['title'] . '</h2>';
                echo '</div>';
                echo '</li>';
                echo '<li class="price">' . $row['normal_price'] . '</li>';
                echo '<li class="quantity">' . $row['quantity'] . '</li>';
                $subtotal = $row['normal_price'] * $row['quantity'];
                echo '<li class="subtotal">' . $subtotal . '</li>';
                $total += $subtotal;
                echo '</ul>';
                echo '</div>';
                $count++;
                }
                echo '<div class="basket-product">';
                echo '<ul>';
                echo '<li class="item" style="width: 90%;">';
                echo '<div class="product-details">';
                echo '<div style="display: flex; justify-content: space-between; text-align: right;">';
                echo '<h2 style="font-size: 20px; font-weight: bold;width:100%;">Total</h2>';
                echo '<div class="total" style="font-weight: bold; width:100%;">' . $total . '</div>';
                echo '</div>';
                echo '</div>';
            } 
            else 
            {
              echo '<div class="item" style="width: 100%; margin-left: 10%;">';
              echo '<div class="product-details">';
              echo '<h2 style="font-size: 60px;">Your cart is empty</h2>';
              echo '</div>';
              echo '</div>';
            }
            ?>
</section>
</form>

<div id="timer" style="position: fixed; top: 10%; left: 50%; transform: translateX(-50%); color: green; font-size: 32px;"></div>

<script>

var countDownDate = new Date().getTime() + 900000;
 

var x = setInterval(function() {
 
  var now = new Date().getTime();
 
  var distance = countDownDate - now;
 
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
 

  document.getElementById("timer").innerHTML = minutes + "m " + seconds + "s ";
 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = window.close();;
  }
}, 1000);

  function formats(ele,e) {
    if(ele.value.length<19) {
      ele.value= ele.value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
      return true;
    } else {
      return false;
    }
  }
    
  function numberValidation(e) {
    e.target.value = e.target.value.replace(/[^\d ]/g,'');
    return false;
  }

</script>

<?php
ob_start(); // Turn on output buffering

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    // Get the data from Form
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $cardname = $_POST['cardname'];
    $cardnumber = $_POST['cardnumber'];
    $expmonth = $_POST['expmonth'];
    $expyear = $_POST['expyear'];
    $cvv = $_POST['cvv'];

    // SQL Query to save the data into Database
    $sql = "INSERT INTO tbl_info SET
        firstname = '$firstname',
        email = '$email',
        address = '$address',
        city = '$city',
        state = '$state',
        zip = '$zip',
        cardname = '$cardname',
        cardnumber = '$cardnumber',
        expmonth = '$expmonth',
        expyear = '$expyear',
        cvv = '$cvv'
    ";

    $user_id = 1; // Temporary user_id
    $food_id = $_POST['food_id'];
    $qty = $_POST['qty'];
    $finaltotal = $_POST['finaltotal'];
    $order_date = date('Y-m-d H:i:s'); 

    // Fetch the food_price and food_title from the tbl_food table
    $sql = "SELECT price, title FROM tbl_food WHERE id = $food_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $food_price = $row['price'];
        $food_title = $row['title'];
    }

    $sql = "INSERT INTO tbl_order SET
        food = '$food_title',
        price = '$food_price', 
        qty = '$qty', 
        total = '$finaltotal', 
        order_date = '$order_date', 
        user_id = '$user_id',
        food_id = '$food_id'
    ";

    // Executing Query and Saving Data into Database
    $res = mysqli_query($conn, $sql) or die(mysqli_error());

    // Check whether the (Query is executed) data is inserted or not and display appropriate message
    if($res==TRUE)
    {
        // Data Inserted
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "<div class='success'> Information Added Successfully. </div>";

        // Redirect to appropriate page
        header("location:".SITEURL.'menu.php');
    }
    else
    {
        // Failed to Insert Data
        // Create a Session Variable to Display Message
        $_SESSION['add'] = "<div class='error'> Failed to Add Information. Try Again Later. </div>";

        // Redirect to appropriate page
        header("location:".SITEURL.'menu.php');
    }
}

ob_end_flush(); // Send the output and turn off output buffering
?>