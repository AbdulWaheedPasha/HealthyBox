<?php 
session_start();
$_SESSION['direction'] = "";
$_SESSION['dir']  = "";
if(isset($_GET['lang'])){
    if($_GET['lang'] == "en" || $_GET['lang'] == "ar"){
        $_SESSION['lang'] = $_GET['lang'];
    }
    if($_SESSION['lang'] == "en"){
        $_SESSION['direction']   = '<html lang="en">';
      
      
    }else if($_SESSION['lang'] == "ar"){
        $_SESSION['direction']   =  '<html dir="rtl"  lang="fa">';
        $_SESSION['dir']         = 'style="direction:rtl"';
      
    }
}else{
    $_SESSION['lang'] = "ar";
    $_SESSION['direction']   =  '<html dir="rtl"  lang="fa">';
    $_SESSION['dir']        = 'style="direction:rtl"';

    
}

if(empty($_SESSION['lang'])){
    $_SESSION['lang'] = "en";
    $_SESSION['direction']   = '<html lang="en">';
}
include_once('./lang/'.$_SESSION['lang'].'.php');

require_once('./header.php');
 ?>


  <div class="wrapper">
  
    <div class="main-panel">
      <!-- Navbar -->
     

      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          
          <div class="row">
          <div class="col-md-8">
          <?php
										  if(isset($_GET['err']))
										  {
										  if($_GET['err']==1)
										  {
										     echo '<div class="alert alert-danger alert-dismissable">
                                             <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>يرجى المحاولة مرة أخرى لاسم المستخدم أو كلمة المرور.
                                             </a>.
                                         </div>';
											 
										  }
                      }
                      ?>
                      </div>
            
            <div class="col-md-8">
              <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title"><?php echo $languages['login']['title']; ?></h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">
                <form role="form" action="./post/login.php" method="post" onsubmit="return validate(this);" >

                  
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label class="bmd-label-floating"><?php echo $languages['login']['title']; ?></label>
                          <input type="text" class="form-control"  name="username" >
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="bmd-label-floating"> <?php echo $languages['login']['password']; ?></label>
                          <input  class="form-control"  name="password" type="password">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                        <label><?php echo $languages['Lang']; ?></label>
                                <select name="language" id="language" class="form-control" onchange="this.options[this.selectedIndex].value && (window.location = 'index.php?lang='+this.options[this.selectedIndex].value);">
                                <option value=""><?php echo $languages['Lang']; ?></option>

    <option value="en">English</option>
    <option value="ar">عربي</option>

  </select>
                        </div>
                      </div>
                      
                    </div>
                   
                    <button type="submit" class="btn btn-primary pull-right"><?php echo $languages['login']['bttn_lbl']; ?></button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          
          </div>
        </div>
      </div>
<?php require_once('./footer.php'); ?>