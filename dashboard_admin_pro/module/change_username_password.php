<?php
if (isset($_SESSION['user_name']) || isset($_SESSION['password'])) {
?>
<script src="https://code.jquery.com/jquery-3.5.1.js"  crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $("#form").on("submit", function(e) {
            var postData = $(this).serializeArray();
            var formURL = $(this).attr("action");
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                success: function(data, textStatus, jqXHR) {
                 //alert(data);
                    var jsonData = JSON.parse(data);
                    if (jsonData.result == "1") {
                        Notify.suc({
                            title: 'OK',
                            text: jsonData.message,
                        });
                        $("form").trigger("reset");
                        setTimeout(function(){
                            window.location.href = 'dashboard.php?type=change_username_password';
                        }, 3000);
                    } else {
                        Notify.suc(jsonData.message);
                    }
                },
                error: function(jqXHR, status, error) {
                    console.log(status + ": " + error);
                }
            });
            e.preventDefault();
        });

        $("#submitForm").on('click', function() {
            $("#form").submit();
        });
    });
</script>

<!-- change username and password  -->
<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-primary">
            <h4 class="card-title "><?php echo $languages['menu_item']['update_user_info']; ?></h4>

        </div>
        <div class="card-body">
            <div>
            <form action="./post/update_username_password.php" method="post" enctype="multipart/form-data"  name="form" id="form">

                    <div class="form-group" id="Result"></div>
                



                    <div class="form-group">
                        <label><?php echo $languages['login']['username']; ?>
                        </label>
                        <input class="form-control" name="username" type="text" value="<?php echo base64_decode(base64_decode(base64_decode(base64_decode($_SESSION['user_name'])))); ?>">
                                            </div>
                                              
                    <div class=" form-group">
                        <label><?php echo $languages['login']['password']; ?>
                        </label>
                        <input class="form-control" name="password"  type="text"  value="" id="password" >
                    </div>

                    <script>
                $('#username').bind('keyup blur',function(){ 
                    var node = $(this);
                    node.val(node.val().replace(/[^A-Za-z0-9]/g,'')); 
                   }
                );
                $('#password').bind('keyup blur',function(){ 
                    var node = $(this);
                    node.val(node.val().replace(/[^A-Za-z0-9]/g,'')); 
                   }
                );
                </script>

                                                         
                    <div class=" form-group">
                        <label><?php echo $languages['login']['new_password']; ?>
                        </label>
                        <input class="form-control" name="new_pass"  type="text"  value="" >
                    </div>

                                                
                    <div class=" form-group">
                        <label><?php echo $languages['login']['conf_password']; ?>
                        </label>
                        <input class="form-control" name="conf_password"  type="text"  value="" >
                    </div>


                   

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="submitForm" class="btn btn-primary btn-round"><?php echo $languages['bttn_lbl']['save']; ?></button>
            </div>
        </div>


    </div>
</div>
</div>
<?php
}
?>

