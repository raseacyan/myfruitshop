<?php
session_start();
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin'){
	header('Location:login.php');
}
	



?>
<?php include("inc/header.php"); ?>
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Welcome Admin</h1>
                    
                    
                    
                    
                </div>
            </main>
<?php include("inc/footer.php"); ?>