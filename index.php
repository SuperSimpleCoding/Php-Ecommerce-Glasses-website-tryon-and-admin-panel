<?php

session_start();

include("includes/db.php");

include("functions/functions.php");

?>
<!DOCTYPE html>
<html>

<head>
<title>E commerce Store </title>

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet" >

<link href="styles/bootstrap.min.css" rel="stylesheet">

<link href="styles/style.css" rel="stylesheet">

<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

<style>
.custom-card {
    margin-bottom: 30px;
    transition: transform 0.3s;
    border: 1px solid #ddd;
    border-radius: 4px;
    overflow: hidden;
}

.custom-card.clickable:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.custom-card img {
    width: 100%;
    height: 300px;
    object-fit: cover;
}

.custom-card .card-content {
    padding: 20px;
    text-align: center;
    background: #fff;
}

.custom-card .card-content h3 {
    margin: 0;
    color: #333;
    font-size: 24px;
    font-weight: 500;
}

.card-section {
    padding: 60px 0;
    background: #f8f9fa;
}

.card-row {
    margin-bottom: 30px;
}

.large-card {
    width: 100%;
    margin-bottom: 30px;
}

.full-width-banner {
    width: 100%;
    height: 50px;
    object-fit: cover;
    margin-top: 10px;
    display: block;
}

.banner-container {
    overflow: hidden;
    margin-top: 30px;
    margin-bottom: 30px;
}
</style>
</head>

<body>

<div id="top"><!-- top Starts -->

<div class="container"><!-- container Starts -->

<div class="col-md-6 offer"><!-- col-md-6 offer Starts -->

<a href="#" class="btn btn-success btn-sm" >
<?php

if(!isset($_SESSION['customer_email'])){

echo "Welcome :Guest";


}else{

echo "Welcome : " . $_SESSION['customer_email'] . "";

}


?>
</a>

<a href="#">
Shopping Cart Total Price: <?php total_price(); ?>, Total Items <?php items(); ?>
</a>

</div><!-- col-md-6 offer Ends -->

<div class="col-md-6"><!-- col-md-6 Starts -->
<ul class="menu"><!-- menu Starts -->

<li>
<a href="customer_register.php">
Register
</a>
</li>

<li>
<?php

if(!isset($_SESSION['customer_email'])){

echo "<a href='checkout.php' >My Account</a>";

}
else{

echo "<a href='customer/my_account.php?my_orders'>My Account</a>";

}


?>
</li>

<li>
<a href="cart.php">
Go to Cart
</a>
</li>

<li>
<?php

if(!isset($_SESSION['customer_email'])){

echo "<a href='checkout.php'> Login </a>";

}else {

echo "<a href='logout.php'> Logout </a>";

}

?>
</li>

</ul><!-- menu Ends -->

</div><!-- col-md-6 Ends -->

</div><!-- container Ends -->
</div><!-- top Ends -->

<div class="navbar navbar-default" id="navbar"><!-- navbar navbar-default Starts -->
<div class="container" ><!-- container Starts -->

<div class="navbar-header"><!-- navbar-header Starts -->

<a class="navbar-brand home" href="index.php" ><!--- navbar navbar-brand home Starts -->

<img src="images/ecom-store-logo.png" alt="ecom logo" class="hidden-xs" >
<img src="images/ecom-store-logo-mobile.png" alt="ecom logo" class="visible-xs" >

</a><!--- navbar navbar-brand home Ends -->

<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation"  >

<span class="sr-only" >Toggle Navigation </span>

<i class="fa fa-align-justify"></i>

</button>

<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#search" >

<span class="sr-only" >Toggle Search</span>

<i class="fa fa-search" ></i>
</button>




</div><!-- navbar-header Ends -->

<div class="navbar-collapse collapse" id="navigation" ><!-- navbar-collapse collapse Starts -->

<div class="padding-nav" ><!-- padding-nav Starts -->

<ul class="nav navbar-nav navbar-left"><!-- nav navbar-nav navbar-left Starts -->

<li class="active">
<a href="index.php"> Home </a>
</li>

<li>
<a href="shop.php"> Shop </a>
</li>

<li>
<?php

if(!isset($_SESSION['customer_email'])){
    
    echo "<a href='checkout.php' >My Account</a>";
    
}
else{
    
    echo "<a href='customer/my_account.php?my_orders'>My Account</a>";
    
}


?>
</li>

<li>
<a href="cart.php"> Shopping Cart </a>
</li>

<li>
<a href="contact.php"> Contact Us </a>
</li>

</ul><!-- nav navbar-nav navbar-left Ends -->

</div><!-- padding-nav Ends -->

<a class="btn btn-primary navbar-btn right" href="cart.php"><!-- btn btn-primary navbar-btn right Starts -->

<i class="fa fa-shopping-cart"></i>

<span> <?php items(); ?> items in cart </span>

</a><!-- btn btn-primary navbar-btn right Ends -->

<div class="navbar-collapse collapse right"><!-- navbar-collapse collapse right Starts -->

<button class="btn navbar-btn btn-primary" type="button" data-toggle="collapse" data-target="#search">

<span class="sr-only">Toggle Search</span>

<i class="fa fa-search"></i>

</button>

</div><!-- navbar-collapse collapse right Ends -->

<div class="collapse clearfix" id="search"><!-- collapse clearfix Starts -->

<form class="navbar-form" method="get" action="results.php"><!-- navbar-form Starts -->

<div class="input-group"><!-- input-group Starts -->

<input class="form-control" type="text" placeholder="Search" name="user_query" required>

<span class="input-group-btn"><!-- input-group-btn Starts -->

<button type="submit" value="Search" name="search" class="btn btn-primary">

<i class="fa fa-search"></i>

</button>

</span><!-- input-group-btn Ends -->

</div><!-- input-group Ends -->

</form><!-- navbar-form Ends -->

</div><!-- collapse clearfix Ends -->

</div><!-- navbar-collapse collapse Ends -->

</div><!-- container Ends -->
</div><!-- navbar navbar-default Ends -->

<div class="container" id="slider"><!-- container Starts -->

<div class="col-md-12"><!-- col-md-12 Starts -->

<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000"><!-- carousel slide Starts --->

<ol class="carousel-indicators"><!-- carousel-indicators Starts -->

<li data-target="#myCarousel" data-slide-to="0" class="active"></li>

<li data-target="#myCarousel" data-slide-to="1"></li>

<li data-target="#myCarousel" data-slide-to="2"></li>

<li data-target="#myCarousel" data-slide-to="3"></li>


</ol><!-- carousel-indicators Ends -->

<div class="carousel-inner"><!-- carousel-inner Starts -->

<?php

$get_slides = "select * from slider LIMIT 0,1";

$run_slides = mysqli_query($con,$get_slides);

while($row_slides=mysqli_fetch_array($run_slides)){

$slide_name = $row_slides['slide_name'];
$slide_image = $row_slides['slide_image'];

echo "

<div class='item active'>

<img src='admin_area/slides_images/$slide_image'>

</div>

";
}

?>

<?php

$get_slides = "select * from slider LIMIT 1,3 ";

$run_slides = mysqli_query($con,$get_slides);

while($row_slides = mysqli_fetch_array($run_slides)) {


$slide_name = $row_slides['slide_name'];

$slide_image = $row_slides['slide_image'];

echo "

<div class='item'>

<img src='admin_area/slides_images/$slide_image'>

</div>

";


}



?>

</div><!-- carousel-inner Ends -->

<a class="left carousel-control" href="#myCarousel" data-slide="prev"><!-- left carousel-control Starts -->

<span class="glyphicon glyphicon-chevron-left"> </span>

<span class="sr-only"> Previous </span>

</a><!-- left carousel-control Ends -->

<a class="right carousel-control" href="#myCarousel" data-slide="next"><!-- right carousel-control Starts -->

<span class="glyphicon glyphicon-chevron-right"> </span>

<span class="sr-only"> Next </span>

</a><!-- right carousel-control Ends -->

</div><!-- carousel slide Ends --->

</div><!-- col-md-12 Ends -->

</div><!-- container Ends -->

<div id="hot"><!-- hot Starts -->

<div class="box"><!-- box Starts -->

<div class="container"><!-- container Starts -->

<div class="col-md-12"><!-- col-md-12 Starts -->

<h2>OUR PRODUCTS</h2>

</div><!-- col-md-12 Ends -->

</div><!-- container Ends -->

</div><!-- box Ends -->

</div><!-- hot Ends -->


<div id="content" class="container"><!-- container Starts -->

<div class="row"><!-- row Starts -->

<?php

getPro();

?>

</div><!-- row Ends -->

</div><!-- container Ends -->

<!-- New Cards Section -->
<div class="card-section">
    <div class="container">
        <!-- Clickable Cards Row -->
        <div class="row card-row">
            <!-- First Clickable Card -->
            <div class="col-md-6">
                <a href="specs/tryon.php" style="text-decoration: none;">
                    <div class="custom-card clickable large-card">
                        <img src="specs/tryon2.gif" alt="Try Glasses Virtually">
                        <div class="card-content">
                            <h3>Try Glasses Virtually</h3>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Second Clickable Card -->
            <div class="col-md-6">
                <a href="specs/askai.php" style="text-decoration: none;">
                    <div class="custom-card clickable large-card">
                        <img src="specs/faceshape.jpg" alt="Ask Ai for glasses">
                        <div class="card-content">
                            <h3>Face Shape Detector</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Large Banner Image -->
        <div class="banner-container">
            <img src="whatsapp-1.jpeg" alt="Wide Banner" class="full-width-banner">
        </div>
    </div>
</div>

<?php

include("includes/footer.php");

?>

<script src="js/jquery.min.js"> </script>

<script src="js/bootstrap.min.js"></script>

</body>
</html>