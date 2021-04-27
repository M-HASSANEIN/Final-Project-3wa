<?php
//reset pwd par email
class ResetPwdController extends SiteBaseController
{
    //show rest pwd page
    public function displayResetpwd()
    {
        $title = "RESET-PWD";
        $template = 'ResetPassword.phtml';
        include 'views/LayoutFrontend.phtml';
    }
    //reset pwd of the user
    public function SendResetEmail()
    {
        $error = "";
        if (isset($_POST["submit-reset"])) {
            $email = $_POST["email"];

            //Verifcation empty inputs
            if ((empty($email)) == true) {
                $error = " Please complete all fields";
                $title = "RESET-PWD";
                $template = 'ResetPassword.phtml';
                include 'views/LayoutFrontend.phtml';
                exit();
            }
            //test if user is exist or not
            $model = new Customers();
            $verfiy_Email = $model->checkLogIn($email, $email);

            if ($verfiy_Email == false) {
                $error = " Email is not exists";
                $title = "RESET-PWD";
                $template = 'ResetPassword.phtml';
                include 'views/LayoutFrontend.phtml';
                exit();
            } else {

                //generate reset code
                $code = uniqid(true);
                $expires = date("U") + 1800;
                //insert code and email to data base
                $model = new ResetPWD();
                $model->InsertRestdata($code, $email, $expires);
                //prepare the email
                //email subject
                $subject = "Resest your password ";
                //email link
                $url = "http://" . $_SERVER["HTTP_HOST"] . str_replace('\\', '/', dirname($_SERVER["PHP_SELF"]))
                    . "/ResetPwd-code-" . $code;
                //body of the eamil
                $body = "<h2>You requested a password reset for your account</h2> if you have sent the request
                  please click this link to reset your password <a href=" . $url . ">this link</a> if not ignore this email ";
                //send email to the user
                $model = new EmailManager($email, $subject, $body);
                $error = 'Reset password link has been sent to your email';
                $title = "RESET-PWD";
                $template = 'ResetPassword.phtml';
                include 'views/LayoutFrontend.phtml';
                exit();
            }
        }
    }
    //get code and page from url sent by the user
    public function ResetPwdLink()
    { //if the code is not found
        if (!isset($_GET["code"])) {
            exit("can't find this page");
        }
        //if the code is exists in url
        //verify if the code exist in data base
        $code = $_GET["code"];
        $model = new ResetPWD();
        $verfycode = $model->CodeexistinDatabase($code);
        //if the code is not exist
        if ($verfycode == false) {
            exit("can't find this page");
        } else {
            //show reset new password page
            //verfiy the exptime of the code
            $expiresTime = $verfycode["code_reset_expire"];
            $currentDate = date("U");

            if ($expiresTime >= $currentDate) { ///create email session
                $_SESSION["email"] = $verfycode["email"];
                $error = "";
                $title = "RESET-PWD";
                $template = 'ResetNewPwd.phtml';
                include 'views/LayoutFrontend.phtml';
                exit();
            } else {
                exit("This code is not valide");
            }
        }
    }
    //if user submit in page resetpwd
    public function ResetpwdDatabase()
    {
        $error = "";
        if (isset($_POST["submit-reset-pwd"])) {
            $newpwd = $_POST["newpassword"];
            $rptnewpwt = $_POST['rptpassword'];

            //Verifcation empty inputs
            if ((empty($newpwd)) || empty($rptnewpwt) == true) {
                $error = " Please complete all fields";
                $title = "RESET-PWD";
                $template = 'ResetNewPwd.phtml';
                include 'views/LayoutFrontend.phtml';
                exit();
            }
            // Password match
            if ($newpwd != $rptnewpwt) {
                $error = "Password don't match";
                $title = "RESET-PWD";
                $template = 'ResetNewPwd.phtml';
                include 'views/LayoutFrontend.phtml';
                exit();
            }
            if (strlen($newpwd) <= 4) {
                $error = "Choose a password longer then 4 character";
                $title = "RESET-PWD";
                $template = 'ResetNewPwd.phtml';
                include 'views/LayoutFrontend.phtml';
                exit();
            } else {
                //update pwd in data base
                $email = $_SESSION["email"];
                $pwd_hashed = password_hash($newpwd, PASSWORD_ARGON2ID);
                $model = new Customers();
                $model->UpDatePWD($pwd_hashed, $email, $email);
                //delete all data from reset PWD table
                $model = new ResetPWD();
                $model->DeleteCodeDbase($email);
                session_destroy();
                unset($_SESSION['email']);
                $error = "Password Reset successfully";
                $title = "LogIn";
                $template = 'CustomerLogIn.phtml';
                include 'views/LayoutFrontend.phtml';
                exit();
            }
        }
    }
}
