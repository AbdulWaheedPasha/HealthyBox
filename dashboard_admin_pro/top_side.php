<div class="wrapper ">
<div class="sidebar" data-color="green" data-background-color="black" data-image="../assets/img/sidebar-2.jpg">

<div class="logo">
 
 </div>
<div class="sidebar-wrapper">
  <ul class="nav">
  
  <?php 
       foreach($_SESSION['menu_item'] as  $value ) {
         $title = ($_SESSION['lang'] == "en") ? $value['page_role_title_en'] : $value['page_role_title_ar'];
         if( $value['page_role_main_menu']  == 1) {
              echo '<li class="nav-item">
              <a class="nav-link" href="./dashboard.php?type='.$value['page_role_title'].'">
                <i class="material-icons">'.$value['page_role_logo'].'</i>
                <p>'.$title.'</p>
              </a>
            </li>';
         }
       }
    ?>
    
  
  </ul>
</div>
</div>
   
<div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top " id="navigation-example">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:void(0)">Healthy Box Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation" data-target="#navigation-example">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
     
            <ul class="navbar-nav">


            <script>
              setInterval(function()
              {
                  $.ajax({
                      type: "get",
                      url: "./ajax/get_counter_new_user.php",
                      success:function(data)
                      {
                       // alert(data);
                        var obj = JSON.parse(data);
                      
                        if(obj.counter_view > 0){
                         //alert(obj.counter_view);
                          $('.new_user_div').html(obj.counter_view);

                        }else{
                          $('.new_user_div').html('0');
                        }
  
                    
                      }
                  });
              }, 4000); 
                </script>


            <script>
              setInterval(function()
              {
                  $.ajax({
                      type: "get",
                      url: "./ajax/load_comments.php",
                      success:function(data)
                      {
                       // alert(data);
                        var obj = JSON.parse(data);
                      
                        if(obj.counter_view > 0){
                         //alert(obj.counter_view);
                          $('.notification').html(obj.counter_view);

                        }else{
                          $('.notification').html('0');
                        }
  
                    
                      }
                  });
              }, 4000); 
                </script>
              
            <?php
            // echo $_SESSION['role_id'] ;
       if($_SESSION['role_id'] == "1" || $_SESSION['role_id'] == "2"){
            ?>
              <li class="nav-item dropdown" style="padding-right: 20px;">
                <a  href="./dashboard.php?type=new_user" > 
                  <i class="material-icons">person_pin</i>
                  <span class="new_user_div">0</span>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
               
              </li>
              

               <li class="nav-item dropdown" >
                <a  href="./dashboard.php?type=all_comments">
                  <i class="material-icons">notifications</i>
                  <span class="notification">0</span>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
               
              </li>

        

                <?php

            }
            ?>

 
          <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                <div class="ripple-container"></div></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                  <a class="dropdown-item" href="./dashboard.php?type=change_username_password"><?php echo $languages['menu_item']['change_pass']; ?></a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="./post/logout.php"><?php echo $languages['menu_item']['logout']; ?></a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->