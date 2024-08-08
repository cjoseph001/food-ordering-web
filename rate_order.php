<!DOCTYPE html>
<html>
<head>
      <meta charset="UTF-8">
    
    <title>FOODDASH | Rate Your Order</title>
    
    <!--Font-->
    <link href="https://fonts.googleapis.com/css2?family=Dela+Gothic+One&family=Gabarito:wght@600&family=Nunito:wght@600&display=swap" rel="stylesheet">
    
    <!--CSS Files-->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="product_style.css">
    <link rel="stylesheet" type="text/css" href="checkout.css">
    <style>

.rating {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.stars {
    display: flex;
    justify-content: center;
    align-items: center;
}

.star {
    font-size: 4.2vw;
    cursor: pointer;
    margin: 5px;
    margin-top: 0.5vw;
    margin-bottom: 1.5vw;
}

.star.filled::before {
    content: "\2605";
    color: brown;
}

.star::before {
    content: "\2606";
    color:brown;
}

.comment_area{
    margin: 0 auto;
    width: 85%; 
        }
        
#comment {
    height: 15vw; 
           
}       
    </style>
</head>
<script>
       let selectedStars = 0;
        function fillStars(starCount) {
            selectedStars = starCount;
            const stars = document.querySelectorAll('.star');
            for (let i = 0; i < starCount; i++) {
                stars[i].classList.add("filled");
            }
            for (let i = starCount; i < stars.length; i++) {
                stars[i].classList.remove("filled");
            }
            document.getElementById("rating").value = starCount;
        }
		
		function validateForm() {
		  const rating = document.getElementById("rating").value;
		  if (rating == 0) {
			alert("Please star rating for the feedback.");
			return false;
		  }
		  return true;
}
</script>
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
                        <li><a href="about.html">About Us</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="page-title">Rate Your Order</div>
		
	<?php
		$cart_id = $_POST['cart_id'];
	?>
         
    <form action="submit_rating.php" method="post" onsubmit="return validateForm()">
	  
	  <input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>">
      <div class="rating">
<label style="font-size: 2.2vw;">How was our service?</label>
    <div class="stars">
        <span class="star" onclick="fillStars(1)"></span>
        <span class="star" onclick="fillStars(2)"></span>
        <span class="star" onclick="fillStars(3)"></span>
        <span class="star" onclick="fillStars(4)"></span>
        <span class="star" onclick="fillStars(5)"></span>
    </div>
    <input type="hidden" id="rating" name="rating" value="0">
</div>
    <div class="comment_area">
        <label for="comment" style="margin-bottom: 0.75vw;font-size: 1.85vw;">Please input your feedback here:</label>
        <textarea id="comment" name="comment" rows="5" cols="50"></textarea>
    </div>

     <div class="button-container2">
                    <button type="submit" class="add-food-button">Submit</button>
    </div>
    </form>
        <footer>
            <p><a>Contact Us Here!</a></p>
            <ul class="social-icons">
                <li><a href="https://www.instagram.com/chris281502" target="_blank"><img src="images/instas.png" alt="Instagram"></a></li>
                <li><a href="https://twitter.com/your-twitter-profile" target="_blank"><img src="images/twitts.png" alt="Twitter"></a></li>
                <li><a href="cjoseph001@e.ntu.edu.sg"><img src="images/mails.png" alt="Email"></a></li>
            </ul>
            <p>Copyright&copy; FOODDASH 2023</p>
        </footer>
    </div>
</body>
</html>
