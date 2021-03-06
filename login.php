<?php
session_start();
$captcha_error = "";

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

include_once './commons/db.php';
include_once './user/userDao.php';
include_once './role/role.php';
include_once './user/user.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $captcha;
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }

    if (!$captcha) {
        $captcha_error = "Please check the the captcha form.";
    } else {
        $user = new User();
        $user->setUsername(trim($_POST["username"]));
        $user->setPassword(trim($_POST["password"]));
        $userDao = new UserDao();

        $user = $userDao->find($user);

        if (null !== $user->getId()) {
            $_SESSION["loggedin"] = true;
            $_SESSION["session_userid"] = $user->getId();
            $_SESSION["session_username"] = $user->getUsername();
            $_SESSION["session_name"] = $user->getName();
            $_SESSION["session_role"] = $user->getRole();

            if ($user->getRole() == 1) {
                header("location: user_list.php");
                exit;
            } else if ($user->getRole() == 2) {
                header("location: car_list.php");
                exit;
            } else {
                header("location: index.php");
                exit;
            }
        } else {
            echo 'not found';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <?php include './includes/head.php'; ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://jqueryui.com/resources/demos/style.css">
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="carAdmin/css/style.css" rel="stylesheet">


    
    
</head>
<body>
    <?php include './includes/header.php'; ?>
    <br><br>
    <div class="container">
        <div class="row" style="margin-top: 2em; padding-bottom: 15%;">
            <div class="col-md-6">
                <br><br>
                <h3>CAR RENTAL SYSTEM</h3>

            </div>
            <div class="col-md-6">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <small id="emailHelp" class="form-text text-muted text-right"><a href="forgotpassword.php">Forgot Password?</a></small>
                    </div>
                    <div class="form-group">
                        <p><?php echo $captcha_error; ?></p>
                        <div class="g-recaptcha" data-sitekey="6LcMLt4UAAAAAM8mkcVtez61P8hCQ4dxYqwBiOxl"></div>
                        <br />
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                        <!-- <div class="col-4"></div>
                        <div class="col-4">
                            <a href="forgot_pw.php">Forgot Password?</a>
                        </div> -->
                    </div>
                    
                </form>
            </div>
        </div>
    </div>


    <?php include './includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script> -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/datepicker.js"></script>
    <script src="js/nav.js"> </script>
    <script src="js/popper.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>