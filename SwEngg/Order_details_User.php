<?php
    session_start();
    
    if (!isset($_SESSION['id'])) {
        header('location:loginnew.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Gentium+Book+Basic&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/763504b100.js" crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="app new2.css">
    <title>Med-Anytime</title>
</head>

<body class="index-page sidebar-collapse">
    <nav  class="navbar navbar-dark navbar-expand-md pt-0 pb-0 fixed-top">
   <a href="userpage2.php" class="navbar-brand"> Med-AnyTime   </a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navmenu" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
	  <div class="collapse navbar-collapse" id="navmenu">
    <ul class="navbar-nav mr-auto">
     
      <li class="nav-item">
      <form method="POST" action="UserProductSearch.php" class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-3" type="search" placeholder="Search" name="search" id="navBarSearchForm" aria-label="Search">
      <button class="btn btn-success my-2 my-sm-0" type="submit" name = "SearchButton" id="SearchButton">Search</button>
      </form>
      </li>
	 
	   <li class="nav-item">
        <a class="nav-link" href="UserProducts.php">Products</a>
      </li>
	    <li class="nav-item">
        <a class="nav-link" href="CartDetails.php">Cart <i class="fas fa-shopping-cart fa-md"></i></a>
      </li>
	  <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    
                            <?php
								 //Checking for user details to diplay on the nav bar
                                 include('C:/xampp/htdocs/SwEngg/Config/dbConnection.php');
                                 $query=mysqli_query($dbConnection,"SELECT * FROM `userdetails` WHERE UserId='".$_SESSION['id']."'");
                                 $row=mysqli_fetch_assoc($query);
                                 echo ''.$row['FirstName'].'';
                            ?>
							       <i class="fas fa-user"></i>
                        </a>
						<div class="dropdown-menu"  aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="Order_details_User.php">View Orders</a>
          <?php echo "<a class=\"dropdown-item\" href=\"ViewProfile.php?ID=".$row['ID']."\">View Profile</a>"; ?>
		  
         <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      
       </li>
     
	   
    </ul>
    
  </div>
  </nav>    
  <!-- End Navbar -->
    <div class="wrapper"><br><br><br>
        <div class="main">
            <div class="section section-basic">
                <div class="container">
                     
                
                <div class="col-md-12">
                <br>
            
                <div class="panel panel-success panel-size-custom">
                        <div class="panel-body">



      <?php 
        $user_id = $_SESSION['id'];
        $query=mysqli_query($dbConnection,"SELECT * FROM `order details` WHERE UserID='$user_id'");
        $count=mysqli_num_rows($query);
		$res = mysqli_fetch_array($query);
      ?>
	   
	   <?php
              if($count==0 ){
				   echo '<center><strong><span style ="color:#FF0000;">"No recent orders"</span></strong></center>';
              }else{
            ?>
  <form>
    <h5>[<small><?php echo $count;?></small>] Recent Orders</h5>  

      <table class="table table-condensed table-bordered">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Description</th>
                  <th width="100">Quantity</th>
				  <th width="100">Price</th>
                  <th width="100">Total Price</th>
				  <th width="100">Order Status</th>
				  <th width="100">Tracking Number</th>
				  <th width= "100">View your item </th>
				  <th width="100"> Cancel your item </th>
                </tr>
              </thead>

              <tbody>

          <?php 
            $query1=mysqli_query($dbConnection,"SELECT * FROM `order details` WHERE UserID='$user_id' AND (OrderStatus='Placed' OR OrderStatus='Deleted' OR OrderStatus='Cancelled')");
            while($row=mysqli_fetch_array($query1)){
            $count1=mysqli_num_rows($query1);
            $ProductID=$row['ProductID'];
            $query2=mysqli_query($dbConnection,"SELECT * FROM products WHERE ID='$ProductID'");
            $row2=mysqli_fetch_array($query2);
          ?>

              <tr>
                  <td> <img width="150" height="100" src="/SwEngg/upload/<?php echo $row2['productImage']; ?>" alt=""/></td>
                  <td><b><?php echo $row2['ProductName'];?></b><br><br>
                    <?php echo $row2['CompanyName'];
                    ?>
                  </td>
                  <td><br><?php  echo $row['ProductQuantity']; ?></td>
                  <td><br><?php  echo $row2['Price']; ?></td>
				  <td><br><?php echo $row['TotalPrice'];?></td>
				  <td><br><?php echo $row['OrderStatus'];?></td>
				  <td><br><?php echo $row['TrackingNumber'];?></td>
                  <td>
                  <a href="view_order_products_users.php?ID=<?php echo $row['ProductID'];?>&Status=<?php echo $row['OrderStatus'];?>"<button class="btn btn-success btn-round"> View item </button></a>	</td>		  
				  <?php if($row['OrderStatus'] == 'Cancelled' || $row['OrderStatus'] == 'Deleted'){?>
						<td></td>
					<?php } else{ ?>
				  <td>
				  <a href="cancel_order_details.php?orderID=<?php echo $row['OrderID'];?>" ><button class="btn btn-danger btn-round" onclick="return confirm('Are you sure you want to cancel?')" type="button">Cancel item</button></a>
				  </td>
				  <?php
                 } ?>
                  <?php
                 } ?>
              </tr>
        
            

              </tbody>
          </table>
    

    </form>
	<?php
                }
              ?>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
<br><br><br><br>
    </div>
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  
    
  </body>
</html>