<?php
$pages = ['login' , 'regitser' ,'forget-password'];
if($_GET){
    if(isset($_GET['page'])){
        if(!in_array($_GET['page'],$pages)){
            include "layouts/errors/404.php";die;
        }
    }else{
        include "layouts/errors/404.php";die;
    }
}else{
    include "layouts/errors/404.php";die;
}
$title = "Check Code";
include_once "layouts/header.php";
include_once "App/Middlewares/guest.php";
use App\Database\Models\User;
use App\Http\Requests\Validation;

/* 
Login
correct code => make user verified => index 
Register
correct code => make user verified => Login
Forget Password
correct code => make user verified => reset password 
*/
$vaidation = new Validation;
if($_SERVER['REQUEST_METHOD'] == "POST"){
    // validation
    $vaidation->setKey('code')->setValue($_POST['code'])->required()->digits(6)->exists('users','code');
    if(empty($vaidation->getErrors())){
        $user = new User;
        $user->setCode($_POST['code']);
        $user->setEmail($_SESSION['email']);
        if($user->checkUserCode()->get_result()->num_rows == 1){
            // correct code
            $user->setEmail_verified_at(date('Y-m-d H:i:s'));
            if($user->makeUserVerified()){
                if($_GET['page'] == 'forget-password'){
                    header('location:reset-password.php');die;
                }elseif($_GET['page'] == 'register'){
                    unset($_SESSION['email']);
                    header('location:login.php');die;
                }elseif($_GET['page'] == 'login'){
                    $authenticatedUser = $user->getUserByEmail()->get_result()->fetch_object();
                    $_SESSION['user'] = $authenticatedUser;
                    header('location:index.php');die;
                }
               
            }else{
                $error = "<p class='text-danger font-weight-bold'> something went wrong </p>";
            }
        }else{
            // wrong code
            $error = "<p class='text-danger font-weight-bold'> wrong code </p>";
        }
    }
}

?>
<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> Check Code </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="" method="post">
                                        <?= $error ?? "" ?>
                                        <input type="number" name="code" placeholder="Verification Code">
                                        <?= "<p class='text-danger font-weight-bold'>". $vaidation->getError('code') . '</p>' ?>
                                        <div class="button-box">
                                            <button type="submit"><span>Check</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

include_once "layouts/footer-scripts.php";
?>