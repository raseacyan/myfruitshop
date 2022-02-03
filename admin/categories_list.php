<?php

include('inc/connect.php');

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

$categories = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {  	
    array_push($categories, $row);
  }
} 

$conn->close();

?>

<?php include("inc/header.php"); ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Categories</h1>
        <a class="btn btn-primary " href="categories_create.php">Add Category</a>
        
        <?php if(count($categories)): ?>                    
            <div class="card mt-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Categories List
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Name</th>                               
                                <th>Action</th>                                 
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>      
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                foreach($categories as $category){                                   
                                    
                                    $html = "<tr>";
                                    $html .= "<td>{$category['name']}</td>";
                                  
                                    $html .= "<td>";
                                    $html .= "<a href='categories_update.php?id={$category['id']}'/>Edit</a> | ";
                                    $html .= "<a href='categories_delete.php?id={$category['id']}'/>Delete</a>";
                                    $html .= "</td>";
                                    $html .= "</tr>";

                                    echo $html;
                                }

                                
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else:?>
            <p>No records found</p>
        <?php endif; ?>
        
        
    </div>
</main>
<?php include("inc/footer.php"); ?>
