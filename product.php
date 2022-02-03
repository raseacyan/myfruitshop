<?php

include('inc/connect.php');
session_start();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id={$id}";
    $result = $conn->query($sql);

    $product = array();

    if ($result->num_rows > 0) {
      $product = $result->fetch_assoc();     
    }else{
         header('Location:index.php');
    }


    



}else{
    header('Location:index.php');
}

$conn->close();
?>

<?php include('inc/header.php'); ?>
        <!-- Product section-->
        <section class="py-5">
           
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?php echo "uploads/{$product['image']}";?>" alt="<?php echo $product['name']; ?>" /></div>
                    <div class="col-md-6">
                        <div class="small mb-1"><?php echo 'Product Code: '.$product['code']; ?></div>
                        <h1 class="display-5 fw-bolder"><?php echo $product['name']; ?></h1>
                        <div class="fs-5 mb-5">                            
                            <span><?php echo 'MMK: '.$product['price']; ?></span>
                        </div>
                        <p class="lead">
                            <?php echo nl2br($product['description']); ?>

                        </p>
                        <div class="d-flex">

                            <form action=cart_create.php method="post">
                                <input class="form-control me-3" type="number" name="quantity" min="1" value="1" style="max-width: 5rem"/>
                                <input type="hidden" name="id" value="<?php echo $product['id'] ?>"/>
                                <input class="btn btn-outline-dark mt-4" type="submit" name="submit" value="&#128722; Add to cart"/>
                            </form>                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
<?php include('inc/footer.php'); ?>
