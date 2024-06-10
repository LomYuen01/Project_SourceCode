<?php 
  include('partials/menu.php');
  $user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : "";

  $selected_payment_method = $_GET['payment'];

  // Generate a random verification code
  $verification_code = rand(100000, 999999);
  $_SESSION['verification_code'] = $verification_code;

  // Delete the existing verification code for the user
  $sql_delete = "DELETE FROM tbl_checkout_verification WHERE customer_id = $user_id";
  $conn->query($sql_delete);

  // Insert the new verification code for the user
  $sql_insert = "INSERT INTO tbl_checkout_verification (customer_id, verification_code) VALUES ($user_id, $verification_code)";
  $conn->query($sql_insert);


  // Fetch the cart items for the user
  $sql_cart_items = "SELECT id, food_id, variation, quantity, size FROM tbl_cart_items WHERE customer_id = $user_id";
  $result_cart_items = $conn->query($sql_cart_items);

  if ($result_cart_items->num_rows > 0) {
      while ($cart_item = $result_cart_items->fetch_assoc()) {
          $cart_item_id = $cart_item['id'];
          $food_id = $cart_item['food_id'];
          $size = $cart_item['size'];
          
          // Fetch the current price based on food_id and size
          $sql_food = "SELECT normal_price, large_price FROM tbl_food WHERE id = $food_id";
          $result_food = $conn->query($sql_food);
          
          if ($result_food->num_rows > 0) {
              $food = $result_food->fetch_assoc();
              $price = ($size == 'Large') ? $food['large_price'] : $food['normal_price'];

              // Update the price in tbl_cart_items
              $sql_update_cart_item = "UPDATE tbl_cart_items SET price = $price WHERE id = $cart_item_id";
              if (!$conn->query($sql_update_cart_item)) {
                  echo "Error updating price: " . $conn->error;
              }
          }
      }
  }

  // Existing code to fetch saved addresses
  $sql_fetch_addresses = "SELECT * FROM tbl_customer_address WHERE customer_id = $user_id";
  $result_addresses = $conn->query($sql_fetch_addresses);
  $saved_addresses = [];
  if ($result_addresses->num_rows > 0) {
      while ($row = $result_addresses->fetch_assoc()) {
          $saved_addresses[] = $row;
      }
  }

  if (isset($_POST['order'])) {
      $submitted_code = $_SESSION['verification_code'];
      
      // Fetch the verification details
      $sql_check_verification = "SELECT * FROM tbl_checkout_verification WHERE customer_id = $user_id";
      $result_verification = $conn->query($sql_check_verification);

      if ($result_verification->num_rows > 0) {
          $verification = $result_verification->fetch_assoc();
          $stored_code = $verification['verification_code'];
          $stored_timestamp = strtotime($verification['timestamp']);
          $current_time = time();
          
          if ($submitted_code != $stored_code) {
              echo "<script>alert('You have multiple checkout pages open. Please use the latest one.'); window.location.href='cart.php';</script>";
              exit;
          } elseif (($current_time - $stored_timestamp) > 900) { // 15 minutes
              echo "<script>alert('Your session has expired. Please try again.'); window.location.href='cart.php';</script>";
              exit;
          } else {
              
              $selected_payment_method = $_POST['payment_method']; // Assuming this is how you get the payment method

              if ($selected_payment_method == 'cod') {
                  $address_id = 1;
              } else {
                  $firstname = $_POST['firstname'];
                  $email = $_POST['email'];
                  $address = $_POST['address'];
                  $phone = $_POST['phone'];
                  $city = $_POST['city'];
                  $state = $_POST['state'];
                  $zip = $_POST['zip'];

                  // Verify email
                  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // Handle invalid email
                    echo "Invalid email format";
                  } else {
                    // Proceed with the rest of the code if the email is valid
                  }
                  
                  $cardname = isset($_POST['cardname']) ? $_POST['cardname'] : "";
                  $cardnumber = isset($_POST['credit_card']) ? $_POST['credit_card'] : "";
                  $expmonth = isset($_POST['expmonth']) ? $_POST['expmonth'] : "";
                  $expyear = isset($_POST['expyear']) ? $_POST['expyear'] : "";
                  $cvv = isset($_POST['cvv']) ? $_POST['cvv'] : "";

                  // Check if address already exists
                  $sql_check_address = "SELECT id FROM tbl_order_address WHERE
                      firstname = '$firstname' AND
                      email = '$email' AND
                      phone = '$phone' AND
                      address = '$address' AND 
                      city = '$city' AND
                      state = '$state' AND
                      zip = '$zip' AND
                      customer_id = '$user_id'
                  ";
                  $result_address = $conn->query($sql_check_address);
                  
                  if ($result_address->num_rows > 0) {
                      $row_address = $result_address->fetch_assoc();
                      $address_id = $row_address['id'];
                  } else {
                      // Insert into tbl_order_address
                      $sql_address = "INSERT INTO tbl_order_address SET
                          firstname = '$firstname',
                          email = '$email',
                          address = '$address', 
                          city = '$city',
                          phone = '$phone',
                          state = '$state',
                          zip = '$zip',
                          customer_id = '$user_id'
                      ";
                      
                      if ($conn->query($sql_address) === TRUE) {
                          $address_id = $conn->insert_id; // Get the last inserted ID
                      } else {
                          echo "Error: " . $sql_address . "<br>" . $conn->error;
                          exit;
                      }
                  }
              }
              
              $selected_payment_method = $_GET['payment']; // or $_POST['payment'] if you used a POST request

              if (strtolower($selected_payment_method) == 'cod') {
                  $paymethod_id = 1;
                  $insert_id = 1;
              } else {
                  // Check if payment method already exists
                  $sql_check_paymethod = "SELECT id FROM tbl_customer_paymethod WHERE
                      cardname = '$cardname' AND
                      cardnumber = '$cardnumber' AND
                      expmonth = '$expmonth' AND
                      expyear = '$expyear' AND
                      cvv = '$cvv' AND
                      customer_id = '$user_id'
                  ";
                  $result_paymethod = $conn->query($sql_check_paymethod);

                  if ($result_paymethod->num_rows > 0) {
                      $row_paymethod = $result_paymethod->fetch_assoc();
                      $paymethod_id = $row_paymethod['id'];
                  } else {
                      // Insert into tbl_customer_paymethod
                      $sql_paymethod = "INSERT INTO tbl_customer_paymethod SET
                          cardname = '$cardname',
                          cardnumber = '$cardnumber',
                          expmonth = '$expmonth',
                          expyear = '$expyear',
                          cvv = '$cvv',
                          customer_id = '$user_id'
                      ";

                      if ($conn->query($sql_paymethod) === TRUE) {
                          $paymethod_id = $conn->insert_id; // Get the last inserted ID
                      } else {
                          echo "Error: " . $sql_paymethod . "<br>" . $conn->error;
                          exit;
                      }
                  }
              }

              // Calculate the total
              $sql_cart = "SELECT SUM(price * quantity) as total_price FROM tbl_cart_items WHERE customer_id = $user_id";
              $result_cart = $conn->query($sql_cart);
              $row_cart = $result_cart->fetch_assoc();
              $total = $row_cart['total_price'];

              // Insert into tbl_order
              $sql_order = "INSERT INTO tbl_order SET 
                  customer_id = $user_id,
                  address_id = $address_id,
                  pay_id = $paymethod_id,
                  order_status = 'Pending'";
              
              if ($conn->query($sql_order) == TRUE) {
                  $order_id = $conn->insert_id;

                  // Insert into tbl_order_items
                  $sql_cart_items = "SELECT * FROM tbl_cart_items WHERE customer_id = $user_id";
                  $result_cart_items = $conn->query($sql_cart_items);
                  
                  while ($row_cart_item = $result_cart_items->fetch_assoc()) {
                      $cart_food_id = $row_cart_item['food_id'];
                      $cart_quantity = $row_cart_item['quantity'];
                      $cart_price = $row_cart_item['price'];
                      $cart_variation = $row_cart_item['variation'];
                      $cart_size = $row_cart_item['size'];
                      
                      $sql_order_items = "INSERT INTO tbl_order_items SET 
                          order_id = $order_id,
                          food_id = $cart_food_id,
                          quantity = $cart_quantity,
                          price = $cart_price,
                          variation_id = '$cart_variation',
                          size = '$cart_size'
                      ";
                      
                      if ($conn->query($sql_order_items) === FALSE) {
                          echo "Error: " . $sql_order_items . "<br>" . $conn->error;
                          exit;
                      }

                      // Update the food stock
                      $sql_food_stock = "SELECT * FROM tbl_food WHERE id = $cart_food_id";
                      $result_food_stock = $conn->query($sql_food_stock);
                      $food_stock = $result_food_stock->fetch_assoc();
                      $new_stock = $food_stock['quantity'] - $cart_quantity;

                      $sql_update_stock = "UPDATE tbl_food SET quantity = $new_stock WHERE id = $cart_food_id";
                      $conn->query($sql_update_stock);
                  }

                  // Clear the cart items for the user
                  $sql_clear_cart = "DELETE FROM tbl_cart_items WHERE customer_id = $user_id";
                  $conn->query($sql_clear_cart);

                  echo "<script>alert('Order placed successfully!'); window.location.href='customer_menu.php';</script>";
              } else {
                  echo "Error: " . $sql_order . "<br>" . $conn->error;
                  exit;
              }
          }
      }
  }
?>
<style>
.checkout-home {
  font-family: Arial;
  font-size: 17px;
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
  position: relative; 
  display: flex; 
  justify-content: center; 
  padding-left: 0; 
  padding-right: 0;
}

input[type=text], input[type=tel] {
  width: 100%;
  margin-bottom: 20px;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
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

.basket-product {
  border-top: 1px solid #cccccc;
  margin-top: -5px;
  background-color: #eee;
}

.basket-product2 {
  border-top: 1px solid #cccccc;
  border-bottom: 5px solid #ccc;
  margin-top: 0;
  background-color: #eee;
  border-bottom-left-radius: 12px;
  border-bottom-right-radius: 12px;
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

<section class="home">
    <!--====== Forms ======-->
    <div class="form-container">
        <i class="fa-solid fa-xmark form-close"></i>

        <!-- Login Form -->
        <div class="form login-form">
            <form action="<?php echo SITEURL; ?>login.php" method="POST">
                <h2>Login</h2>

                <div class="input-box">
                    <input type="email" name="email" placeholder="Enter your email" required>
                    <i class="fa-solid fa-envelope email"></i>
                </div>

                <div class="input-box">
                    <input type="password" name="password" placeholder="Enter your password" required>
                    <i class="fa-solid fa-lock password"></i>
                    <i class="fa-solid fa-eye-slash pw-hide"></i>
                </div>

                <input type="hidden" name="redirect_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">

                <div class="option-field">
                    <span class="checkbox">
                        <input type="checkbox" id="check">
                        <label for="check" style="margin-bottom: 0;">Remember me</label>
                    </span>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" name="submit" class="btn">Login Now</button>

                <div class="login-singup">
                    Don't have an account? <a href="<?php echo SITEURL; ?>signup.php">Sign up</a>
                </div>
            </form>
        </div>
    </div>
    <!--====== Forms ======-->

    <!--===== Content =====-->
    <form action="" method="post" style="display: flex; flex-direction: row; width: 89%; padding-top: 15px; margin: auto;">
        <section class="checkout-home" style="width: 65%;">
            <h2 style="display: block; font-size: 24px; color: #000; font-weight: 600; margin-top: 20px; margin-bottom: 16px;">Checkout</h2>
            <div class="row" style="width: 100%;">
                <div class="col-75" style="margin-left: 16px; padding: 0;">
                    <div class="container" style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <div class="row">
                            <div class="col-50" style="padding-top: 15px;">
                                <h3>Address</h3>
                                <div class="addresssave">
                                    <label for="saved_addresses">Select Saved Address</label>
                                    <select id="saved_addresses" onchange="fillAddress()" style="margin-bottom: 15px;">
                                        <option value="">Select an address</option>
                                        <?php foreach ($saved_addresses as $address) { ?>
                                            <option value="<?php echo htmlspecialchars(json_encode($address)); ?>">
                                                <?php echo $address['name'] . ' - ' . $address['address']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <!-- Existing form fields -->
                                <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                                <input type="text" id="fname" name="firstname" placeholder="Aaa Bbbbb">
                                <label for="phone"><i class="fa fa-phone"></i> Phone Number</label>
                                <input type="tel" id="phone" name="phone" placeholder="0123456789">
                                <br>
                                <label for="email"><i class="fa fa-envelope"></i> Email</label>
                                <input type="text" id="email" name="email" placeholder="abc123@example.com">
                                <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                                <input type="text" id="adr" name="address" placeholder="123, adc">
                                <label for="city"><i class="fa fa-institution"></i> Taman</label>
                                <input type="text" id="city" name="city" placeholder="Taman Kenanga Mewah">
                                <div style="margin-left: -15px; display: flex; flex-direction: row;">
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

                    <!-- Existing payment section -->
                    <div class="container" style="margin-top: 2%; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                        <div class="row">
                            <div class="col-50" style="padding-top: 15px;">
                                <h3>Payment</h3>
                                <?php if ($selected_payment_method == 'cod') { ?>
                                    <p>COD</p>
                                <?php } else { ?>
                                <label for="fname" style="margin-top: 6px; margin-bottom: -6px;">Accepted Cards</label>
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
                                        onkeyup="return numberValidation(event)">
                                </div>
                                
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
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="order" class="btn <?= ($total > 1)?'':'disabled'; ?>" value="Place order" style="border-radius: 18px; margin-top:5%; transition: .2s ease;">
                </div>
            </div>
        </section>

        <section style="margin-top: 5%; width: 100%;">
            <div class="basket" style="width: 100%; margin-top: -8px; border: none;">
                <div class="basket-labels">
                    <ul>
                        <li class="food-checkbox">No.</li>
                        <li class="item item-heading">Item</li>
                        <li class="price">Price</li>
                        <li class="quantity">Quantity</li>
                        <li class="subtotal">Subtotal</li>
                    </ul>
                </div>

                <?php
                    $total = 0;

                    $sql = "SELECT tbl_cart_items.id as cart_items_id, tbl_cart_items.quantity as cart_quantity, tbl_cart_items.size as cart_size, tbl_food.title, tbl_food.normal_price, tbl_food.large_price, tbl_food_variation.name as variation_name
                            FROM tbl_cart_items
                            INNER JOIN tbl_food ON tbl_cart_items.food_id = tbl_food.id
                            LEFT JOIN tbl_food_variation ON tbl_cart_items.variation = tbl_food_variation.id
                            WHERE tbl_cart_items.customer_id = $user_id";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            $price = $row['cart_size'] == 'Large' ? $row['large_price'] : $row['normal_price'];
                            $subtotal = $price * $row['cart_quantity'];
                            $total += $subtotal;
                            ?>
                            <div class="basket-product">
                                <ul>
                                    <li class="food-checkbox"><?php echo $count; ?></li>
                                    <li class="item">
                                        <div class="product-details">
                                            <h2 style="font-size: 20px;"><?php echo $row['title']; ?></h2>
                                            <div style="font-size: 1em;">Size: <?php echo $row['cart_size']; ?></div>
                                            <div style="font-size: 1em;">Variation: <?php echo $row['variation_name']; ?></div>
                                        </div>
                                    </li>
                                    <li class="price">RM <?php echo $price; ?></li>
                                    <li class="quantity"><?php echo $row['cart_quantity']; ?></li>
                                    <li class="subtotal">RM <?php echo $subtotal; ?></li>
                                </ul>
                            </div>
                        <?php
                            $count++;
                        }

                    $current_day = date('l');
                    $sql_limit = "SELECT * FROM tbl_limit WHERE day = '$current_day'";
                    $result_limit = $conn->query($sql_limit);
                    $limit = $result_limit->fetch_assoc();
                    $delivery_price = $limit['delivery_price'];
                    $total += $delivery_price;

                ?>

                <div class="basket-product basket-product2">
                    <ul>
                        <li class="item" style="width: 90%;">
                            <div class="product-details">
                                <div style="display: flex; justify-content: space-between; text-align: right;">
                                    <h2 style="font-size: 20px; font-weight: bold; width: 100%;">Delivery Fee</h2>
                                    <div class="total" style="font-weight: bold; width: 100%;">RM <?php echo $delivery_price; ?></div>
                                </div>
                                <div style="display: flex; justify-content: space-between; text-align: right;">
                                    <h2 style="font-size: 20px; font-weight: bold; width: 100%;">Total</h2>
                                    <div class="total" style="font-weight: bold; width:100%;">RM <?php echo $total; ?></div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php
                } else {
                ?>
                    <div class="item" style="width: 100%; margin-left: 10%;">
                        <div class="product-details">
                            <h2 style="font-size: 60px;">Your cart is empty</h2>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </section>
    </form>
    <div id="timer" style="position: fixed; top: 10%; left: 50%; transform: translateX(-50%); color: green; font-size: 32px;"></div>
</section>

<script>
    let subMenu = document.getElementById("subMenu");
    function toggleMenu(){
        subMenu.classList.toggle("open-menu");
    }

    var countDownDate = new Date().getTime() + 900000;
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("timer").innerHTML = minutes + "m " + seconds + "s ";
          if (distance < 0) {
              clearInterval(x);
              alert("Your session has expired. Please try again.");
              window.location.href = 'cart.php';
          }
      }, 1000);

    function formats(ele, e) {
      if(ele.value.length < 19) {
          ele.value = ele.value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
          return true;
      } else {
          return false;
      }
    }
      
    function numberValidation(e) {
      e.target.value = e.target.value.replace(/[^\d ]/g,'');
      return false;
    }

    function fillAddress() {
        var select = document.getElementById('saved_addresses');
        var address = JSON.parse(select.value);
        if (address) {
            document.getElementById('fname').value = address.name;
            document.getElementById('phone').value = address.phone;
            document.getElementById('email').value = address.email || ''; // Assuming email can be part of the address, otherwise remove this line
            document.getElementById('adr').value = address.address;
            document.getElementById('city').value = address.city;
            document.getElementById('zip').value = address.postal_code;
            document.getElementById('state').value = address.state;
        }
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        const phoneInput = document.getElementById('phone');

        phoneInput.addEventListener('input', function (e) {
            const value = phoneInput.value.replace(/\D/g, '');
            
            if (value.length > 3 && value.startsWith('010') || value.startsWith('011') || value.startsWith('012') || value.startsWith('013') || value.startsWith('014') || value.startsWith('016') || value.startsWith('017') || value.startsWith('018') || value.startsWith('019')) {
                let formattedValue = value.match(/(\d{1,3})(\d{1,8})?/);
                if (formattedValue) {
                    phoneInput.value = formattedValue[1] + (formattedValue[2] ? '-' + formattedValue[2] : '');
                }
            } else {
                phoneInput.value = value.substring(0, 3);
            }
        });

        phoneInput.addEventListener('blur', function (e) {
            const value = phoneInput.value.replace(/\D/g, '');
            if (value.length < 10 || value.length > 11) {
                alert('Invalid phone number. Please enter a valid phone number.');
                phoneInput.value = '';
            }
        });
    });
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../Style/form-login.js"></script>