<?php

use App\Helpers\Media;
use App\Database\Models\User;
use App\Http\Requests\Validation;

$title = "My Account";
include_once "layouts/header.php";
include_once "App/Middlewares/auth.php";
$validation = new Validation;
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update-profile'])){
    $validation->setKey('first_name')->setValue($_POST['first_name'])->required();
    $validation->setKey('last_name')->setValue($_POST['last_name'])->required();
    $validation->setKey('phone')->setValue($_POST['phone'])->required()->regex('//');
    if(empty($validation->getErrors())){
        $user = new User;
        $user->setFirst_name($_POST['first_name'])->setLast_name($_POST['last_name'])
        ->setPhone($_POST['phone'])->setGender($_POST['gender'])->setEmail($_SESSION['user']->email);
        if($_FILES['image']['error'] == 0){
            $media = new Media($_FILES['image']);
            $media->validateOnSize(10**6)->validateOnExtension(['jpg','jpeg','png']);
            if(empty($media->getErrors())){
                $media->upload("assets/img/users/");
                $image = $media->getFileName();
                $user->setImage($image);
            }else{
                $imageErrors = $media->getErrors();
            }
        }
        try {
            if(empty($media->getErrors())){
                $user->update();
                $_SESSION['user']->first_name = $_POST['first_name'];
                $_SESSION['user']->last_name = $_POST['last_name'];
                $_SESSION['user']->phone = $_POST['phone'];
                $_SESSION['user']->gender = $_POST['gender'];
                $_SESSION['user']->image = $media->getFileName();
                $success = "Profile Updated Successfully";
            }
        }catch(\Exception $e){
            $error = 'wrong email or password';
        }
    }
}
include_once "layouts/navbar.php";
include_once "layouts/breadcrumb.php";
?>
<!-- my account start -->
<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="checkout-wrapper">
                    <div id="faq" class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                            </div>
                            <div id="my-account-1" class="panel-collapse collapse show">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>My Account Information</h4>
                                            <h5>Your Personal Details</h5>
                                            <?= isset($error) ?  "<p class='text-danger text-center font-weight-bold  '>" . $error . "</p>" : "" ?>
                                            <?= isset($success) ?  "<p class='text-success text-center font-weight-bold  '>" . $success . "</p>" : "" ?>
                                        </div>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-4 offset-4 ">
                                                    <label for="file">
                                                        <img src="assets/img/users/<?= $_SESSION['user']->image ?>" alt="<?= $_SESSION['user']->first_name ?>" id="image" class="w-100 cricle-rounded mb-4" style="cursor:pointer" ;>
                                                    </label>
                                                    <?php 
                                                        if(isset($imageErrors)){
                                                            foreach($imageErrors AS $error){
                                                                echo "<p class='text-danger font-weight-bold  '>" . $error . '</p>';
                                                            }
                                                        }
                                                    ?>
                                                    <input type="file" name="image" class="d-none" id="file" onchange="loadImage(event)">
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>First Name</label>
                                                        <input type="text" name="first_name" value="<?= $_SESSION['user']->first_name ?>">
                                                        <?= "<p class='text-danger font-weight-bold  '>" . $validation->getError('first_name') . "</p>" ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Last Name</label>
                                                        <input type="text" name="last_name" value="<?= $_SESSION['user']->last_name ?>">
                                                        <?= "<p class='text-danger font-weight-bold  '>" . $validation->getError('last_name') . "</p>" ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Phone</label>
                                                        <input type="number" name="phone" value="<?= $_SESSION['user']->phone ?>">
                                                        <?= "<p class='text-danger font-weight-bold  '>" . $validation->getError('phone') . "</p>" ?>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="billing-info">
                                                        <label>Gender</label>
                                                        <select name="gender" class="form-control" id="">
                                                            <option <?= $_SESSION['user']->gender == 'm' ? 'selceted' : '' ?> value="m">Male</option>
                                                            <option <?= $_SESSION['user']->gender == 'f' ? 'selceted' : '' ?> value="f">Female</option>
                                                        </select>
                                                        <?= "<p class='text-danger font-weight-bold  '>" . $validation->getError('gender') . "</p>" ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="billing-back-btn">
                                                <div class="billing-btn">
                                                    <button type="submit" name="update-profile">Update Profile</button>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
                            </div>
                            <div id="my-account-2" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Change Password</h4>
                                            <h5>Your Password</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Password</label>
                                                    <input type="password">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="billing-info">
                                                    <label>Password Confirm</label>
                                                    <input type="password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>3</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-3">Modify your address book entries </a></h5>
                            </div>
                            <div id="my-account-3" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="billing-information-wrapper">
                                        <div class="account-info-wrapper">
                                            <h4>Address Book Entries</h4>
                                        </div>
                                        <div class="entries-wrapper">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-info text-center">
                                                        <p>Farhana hayder (shuvo) </p>
                                                        <p>hastech </p>
                                                        <p> Road#1 , Block#c </p>
                                                        <p> Rampura. </p>
                                                        <p>Dhaka </p>
                                                        <p>Bangladesh </p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 d-flex align-items-center justify-content-center">
                                                    <div class="entries-edit-delete text-center">
                                                        <a class="edit" href="#">Edit</a>
                                                        <a href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="billing-back-btn">
                                            <div class="billing-back">
                                                <a href="#"><i class="ion-arrow-up-c"></i> back</a>
                                            </div>
                                            <div class="billing-btn">
                                                <button type="submit">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><span>4</span> <a href="wishlist.php">Modify your wish list </a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var loadImage = function(event) {
        var output = document.getElementById('image');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>
<!-- my account end -->
<?php
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php";
?>