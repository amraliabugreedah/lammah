<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/18/2017
 * Time: 11:25 AM
 */
$pageTitle = 'Login Page';
include 'header.php';

?>
    <div class="content">
        <div class="loginwrapper">
            <div class = 'row'>
                <form class = 'form-signin'>
                    <h2 class="form-signin-heading">Please sign in</h2>
                    <div class="form-group">
                        <label for="user_name">Username: </label>
                        <input type="text" required class="form-control" id="username" placeholder="Enter your username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password: </label>
                        <input type="password" required class="form-control" id="password" placeholder="Enter your password" name="password">
                    </div>
                    <input type="button"  class="btn btn-primary submitLoginInfo" name="submitLoginInfo" id="submitLoginInfo" value="Login">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 ">
            </div>
            <div class="col-sm-8 ">
                <div class="errorMessage" style="display: none;"></div>
            </div>
        </div>
    </div>

    <script>
        $('.submitLoginInfo').on('click', function(){
            $username = $('#username').val();
            $password = $('#password').val();
            // console.log($username);
            // console.log($password);
            $.post("../_auth/login.php",
                {
                    username: $username,
                    password: $password,
                    submitLoginInfo: 'submitIt'
                },
                function(data, status){
                if(data !== ''){
                    $errorMessage = $('.errorMessage');
                    $errorMessage.css('display', 'block');
                    $errorMessage.empty();
                    $errorMessage.append(data);
                }else{
                    window.location =  "../project/main.php";
                }
                });
        });
        $('#username, #password').keydown(function (e) {
            var key = e.which;
            if(key === 13)  // the enter key code
            {
                $('.submitLoginInfo').click();
                return false;
            }
        });
    </script>

<?php
include 'footer.php';
?>