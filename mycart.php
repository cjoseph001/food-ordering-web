<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>FOODDASH | My Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Gabarito:wght@600&family=Nunito:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="product_style.css">
	<style>
        span.no-border {
        border: none;
        outline: none;
        }
       
        .mycart {
            text-align: center;
            font-family: 'Gabarito', cursive;
            font-size: 2vw;
            margin-bottom: 3.5vw;
            margin-top: 3.5vw;
        }
        .cart-table, .total-row{    
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3); 
        }
        .cart-table th,
        .cart-table td,.total-row th, .total-row td{
            font-size: 1.85vw;
            padding: 1vw;
        }
        .cart-table th, .total-row th{
            background-color: #AB651D;
            color: #fff;
            font-size: 1.85vw;
        }
        .quantity-adjust-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .quantity-adjust {
            width: 3.15vw;
            height: 3.15vw;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #8B4513;
            color: #fff;
            font-size: 3vw;
            border: none;
            cursor: pointer;
            border-radius: 12.5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        }

        .quantity-adjust:hover {
            background-color: #f57c00;
        }
        
        .delete {
            background-color: #CC0000;
            color: #fff;
            font-size: 1.9vw;
            border: none;
            cursor: pointer;
            width: 2.75vw; 
            height: 2.75vw; 
            border-radius: 50%;
            text-align: center;
             box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
        }

        .delete:hover {
            background-color: #FF0000;
            transform: scale(1.1);
        } 
        .progress-box {
            width: 100%;
        }
        .progressbar {
            counter-reset: step;
            margin-right: 5vw;
            padding-bottom: 8.5vw;
        }
        .progressbar li {
            list-style-type: none;
            float: left;
            width: 25%;
            position: relative;
            text-align: center;
        }
        .progressbar li:before {
            content: counter(step);
            counter-increment: step;
            width: 3vw;
            height: 3vw;
            line-height: 3vw;
            border: 1px solid;
            display: block;
            margin: 0 auto 10px auto;
            border-radius: 50%;
            background-color: white;
        }
    
        .progressbar li:after{
            content: '';
            position: absolute;
            width: 100%;
            height: 0.5vw;
            background-color: #ddd;
            top: 1.5vw;
            left: -50%;
            z-index:-1;
        }
        .progressbar li:first-child:after{
            content: none;
        }
        .progressbar li.active{
            color: brown;
        }
        .progressbar li.active:before{
            border-color: brown;
            background-color: brown;
            color: #fff;
        }
        .progressbar li.active + li:after{
            background-color: brown;
        }
	</style>
    
<script>
            function adjustQuantity(button, action, index) {
            var row = button.closest('tr');
            var quantityElement = row.querySelector('.quantity');
            var currentQuantity = parseInt(quantityElement.textContent);
     
            if (action === 'increase') {
                currentQuantity++;
            } else if (action === 'decrease' && currentQuantity > 1) {
                currentQuantity--;
            }
    
            var form = document.createElement("form");
            form.method = "post";
            form.action = "update_cart.php";

            var productInput = document.createElement("input");
            productInput.type = "hidden";
            productInput.name = "product";
            productInput.value = row.querySelector("td:first-child").textContent;

            var quantityInput = document.createElement("input");
            quantityInput.type = "hidden";
            quantityInput.name = "quantity";
            quantityInput.value = currentQuantity;

            form.appendChild(productInput);
            form.appendChild(quantityInput);
            document.body.appendChild(form);
            form.submit();
            }
    
            function deleteItem(btn) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);

            var form = document.createElement("form");
            form.method = "post";
            form.action = "delete_item.php"; 

            var productInput = document.createElement("input");
            productInput.type = "hidden";
            productInput.name = "product";
            productInput.value = row.querySelector("td:first-child").textContent;

            form.appendChild(productInput);
            document.body.appendChild(form);
            form.submit();
            }
    
function checkLogin() {
            <?php
            if (isset($_SESSION['username'])) {
                echo "location.href='checkout.html';";
            } else {
                echo "location.href='login.php';alert('Please login first!');";
            }
            ?>
}

</script>
</head>


<body>
    <div class="content">
        <header>
            <div class="header-content">
                <h1 class="header-title">FoodDash</h1>
                <nav>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><a href="menu.html">Menu</a></li>
                        <li><a href="mycart.php">My Cart</a></li>
                        <li><a href="checklogin.php">My Account</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="page-title">MY CART</div>

        <div class="mycart">
            <div class="progress-box">
                <ul class="progressbar">
                    <li class="active">My Cart</li>
                    <li>Check Out</li>
                    <li>Confirmation</li>
                    <li>Order Status</li>
                </ul>
            </div>
            <?php
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                $totalQuantity = 0;
                $totalPrice = 0;
            ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                
                <tbody id="cartlist">
                    
                    <?php foreach ($_SESSION['cart'] as $index => $item) { ?>
                        <?php $subtotal = $item['quantity'] * $item['price'];
                        $totalQuantity += $item['quantity'];
                        $totalPrice += $subtotal;?><tr>
                            <td><?php echo $item['product']; ?></td>
                            <td style="text-align: center;">
                                <div class="quantity-adjust-container">
                                    <button class="quantity-adjust" onclick="adjustQuantity(this, 'decrease', <?= $index ?>)">-</button>
                                    <span class="quantity no-border" style="font-size: 1.8vw;"><?= $item['quantity'] ?></span>
                                    <button class="quantity-adjust" onclick="adjustQuantity(this, 'increase', <?= $index ?>)">+</button>
                                </div></td>
                            <td class="price" style="display:none;"><?php echo $item['price']; ?></td>
                            <td class="subtotal">S$<?php echo number_format($subtotal, 2); ?></td>
                            <td>
                                <button class="delete" onclick="deleteItem(this)">X</button>
                            </td></tr>
                    <?php } ?>
                    
                </tbody>
                
            </table>

            <table class="total-row">
                <thead>
                    <tr><th>Total Quantity</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody><tr>
                        <td id="totalQuantity"><?php echo $totalQuantity; ?></td>
                        <td id="totalPrice">S$<?php echo number_format($totalPrice, 2); ?></td>
                    </tr></tbody>
            </table>

            <div class="button-container2">
                <form action="reset_cart.php" method="post" id="resetbutton">
                    <button type="submit" class="reset-button">Reset Cart</button>
                </form>
                <button type="button" class="add-food-button" onclick="location.href='menu.html';">Add More Foods</button>
            </div>
            <button type="button" class="checkout-button" onclick="checkLogin()">Check-Out</button>
            <?php } else { ?>
                Your cart is currently empty.<br>
                Please select a product to begin an order.
                <div class="button-container2">
                    <button type="button" class="add-food-button" onclick="location.href='menu.html';">Start Order</button>
                </div>
            <?php } ?>
        </div>

        <footer>
            <p><a>Contact Us Here!</a></p>
            <ul class="social-icons">
                <li><a href="https://www.instagram.com" target="_blank"><img src="images/instas.png" alt="Instagram"></a></li>
                <li><a href="https://twitter.com/your-twitter-profile" target="_blank"><img src="images/twitts.png" alt="Twitter"></a></li>
                <li><a href="cjoseph001@e.ntu.edu.sg"><img src="images/mails.png" alt="Email"></a></li>
            </ul>
            <p>Copyright&copy; FOODDASH 2023</p>
        </footer>
    </div>
</body>
</html>
