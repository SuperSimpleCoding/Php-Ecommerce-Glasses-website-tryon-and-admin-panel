<?php

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login.php','_self')</script>";

} else {

?>
<!DOCTYPE html>

<html>

<head>

<title> Insert Products </title>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

</head>

<body>

<div class="row"><!-- row Starts -->

    <div class="col-lg-12"><!-- col-lg-12 Starts -->

        <ol class="breadcrumb"><!-- breadcrumb Starts -->

            <li class="active">
                <i class="fa fa-dashboard"> </i> Dashboard / Insert Products
            </li>

        </ol><!-- breadcrumb Ends -->

    </div><!-- col-lg-12 Ends -->

</div><!-- row Ends -->

<div class="row"><!-- 2 row Starts --> 

    <div class="col-lg-12"><!-- col-lg-12 Starts -->

        <div class="panel panel-default"><!-- panel panel-default Starts -->

            <div class="panel-heading"><!-- panel-heading Starts -->

                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Insert Products
                </h3>

            </div><!-- panel-heading Ends -->

            <div class="panel-body"><!-- panel-body Starts -->

                <form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product Title </label>
                        <div class="col-md-6" >
                            <input type="text" name="product_title" class="form-control" required >
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product Category </label>
                        <div class="col-md-6" >
                            <select name="product_cat" class="form-control">
                                <option> Select  a Product Category </option>
                                <?php
                                $get_p_cats = "select * from product_categories";
                                $run_p_cats = mysqli_query($con,$get_p_cats);
                                while ($row_p_cats=mysqli_fetch_array($run_p_cats)) {
                                    $p_cat_id = $row_p_cats['p_cat_id'];
                                    $p_cat_title = $row_p_cats['p_cat_title'];
                                    echo "<option value='$p_cat_id'>$p_cat_title</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Category </label>
                        <div class="col-md-6" >
                            <select name="cat" class="form-control" >
                                <option> Select a Category </option>
                                <?php
                                $get_cat = "select * from categories ";
                                $run_cat = mysqli_query($con,$get_cat);
                                while ($row_cat=mysqli_fetch_array($run_cat)) {
                                    $cat_id = $row_cat['cat_id'];
                                    $cat_title = $row_cat['cat_title'];
                                    echo "<option value='$cat_id'>$cat_title</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product Image 1 * </label>
                        <div class="col-md-6" >
                            <input type="file" name="product_img1" class="form-control" required >
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product Image 2 * </label>
                        <div class="col-md-6" >
                            <input type="file" name="product_img2" class="form-control" required >
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product Image 3 * </label>
                        <div class="col-md-6" >
                            <input type="file" name="product_img3" class="form-control" required >
                        </div>
                    </div><!-- form-group Ends -->

                    <!-- Add new image inputs for Product Image 4, 5, and 6 -->
                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product Image 4 </label>
                        <div class="col-md-6" >
                            <input type="file" name="product_img4" class="form-control">
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product Image 5 </label>
                        <div class="col-md-6" >
                            <input type="file" name="product_img5" class="form-control" >
                        </div>
                    </div><!-- form-group Ends -->
                      
                    <!-- Critical start  -->

                    <div class="form-group">
    <h5>        Below input { Product Image 6 } must conatin Transparent Background Image for AI simulation Try-On. Can be nullable </h5>
    <label class="col-md-3 control-label"> Transparent Background Product Image 6 </label>
    <div class="col-md-6">
        <input type="file" name="product_img6" class="form-control" id="product_img6">
    </div>
</div>

<!-- Modal for alert -->
<div id="alertModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); padding:20px; background-color: green; color: white; border-radius: 5px;">
    <p>This input must contain an image with a transparent background. This image will be used by the AI.</p>
    <button onclick="closeModal()">OK</button>
</div>


                    <!-- Critical ends  -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product Quantity </label>
                        <div class="col-md-6" >
                            <input type="text" name="product_quantity" class="form-control" required >
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product price </label>
                        <div class="col-md-6" >
                            <input type="text" name="product_price" class="form-control" required >
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product Keywords </label>
                        <div class="col-md-6" >
                            <input type="text" name="product_keywords" class="form-control" required >
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" > Product Description </label>
                        <div class="col-md-6" >
                            <textarea name="product_desc" class="form-control" rows="6" cols="19" ></textarea>
                        </div>
                    </div><!-- form-group Ends -->

                    <div class="form-group" ><!-- form-group Starts -->
                        <label class="col-md-3 control-label" ></label>
                        <div class="col-md-6" >
                            <input type="submit" name="submit" value="Insert Product" class="btn btn-primary form-control" >
                        </div>
                    </div><!-- form-group Ends -->

                </form><!-- form-horizontal Ends -->

            </div><!-- panel-body Ends -->

        </div><!-- panel panel-default Ends -->

    </div><!-- col-lg-12 Ends -->

</div><!-- 2 row Ends --> 

</body>

</html>

<?php

if(isset($_POST['submit'])){

    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $cat = $_POST['cat'];
    $product_price = $_POST['product_price'];
    $product_desc = $_POST['product_desc'];
    $product_keywords = $_POST['product_keywords'];

    // Capture all 6 product images
    $product_img1 = $_FILES['product_img1']['name'];
    $product_img2 = $_FILES['product_img2']['name'];
    $product_img3 = $_FILES['product_img3']['name'];
    $product_img4 = $_FILES['product_img4']['name'];
    $product_img5 = $_FILES['product_img5']['name'];
    $product_img6 = $_FILES['product_img6']['name'];

    // Temporary image names
    $temp_name1 = $_FILES['product_img1']['tmp_name'];
    $temp_name2 = $_FILES['product_img2']['tmp_name'];
    $temp_name3 = $_FILES['product_img3']['tmp_name'];
    $temp_name4 = $_FILES['product_img4']['tmp_name'];
    $temp_name5 = $_FILES['product_img5']['tmp_name'];
    $temp_name6 = $_FILES['product_img6']['tmp_name'];

    // Move uploaded files to product_images directory
    move_uploaded_file($temp_name1,"product_images/$product_img1");
    move_uploaded_file($temp_name2,"product_images/$product_img2");
    move_uploaded_file($temp_name3,"product_images/$product_img3");
    move_uploaded_file($temp_name4,"product_images/$product_img4");
    move_uploaded_file($temp_name5,"product_images/$product_img5");
    move_uploaded_file($temp_name6,"product_images/$product_img6");

    // Product quantity
    $product_quantity = $_POST['product_quantity'];

    // Insert query including the new images
    $insert_product = "insert into products (p_cat_id,cat_id,date,product_title,product_img1,product_img2,product_img3,product_img4,product_img5,product_img6,product_quantity,product_price,product_desc,product_keywords) values ('$product_cat','$cat',NOW(),'$product_title','$product_img1','$product_img2','$product_img3','$product_img4','$product_img5','$product_img6','$product_quantity','$product_price','$product_desc','$product_keywords')";

    $run_product = mysqli_query($con,$insert_product);

    if($run_product){
        echo "<script>alert('Product has been inserted successfully')</script>";
        echo "<script>window.open('index.php?view_products','_self')</script>";
    }

}

?>

<?php } ?>


<script>
    document.getElementById('product_img6').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const img = new Image();
            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;

                img.onload = function() {
                    // Check if the image has transparency
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0, img.width, img.height);

                    const imageData = ctx.getImageData(0, 0, img.width, img.height);
                    let hasTransparency = false;

                    for (let i = 3; i < imageData.data.length; i += 4) {
                        if (imageData.data[i] < 255) { // Alpha channel check
                            hasTransparency = true;
                            break;
                        }
                    }

                    if (!hasTransparency) {
                        showModal(); // Show modal if no transparency
                    }
                };
            };
            reader.readAsDataURL(file);
        }
    });

    function showModal() {
        document.getElementById('alertModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('alertModal').style.display = 'none';
    }
</script>

