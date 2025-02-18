<?php
include "../db.php";


function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST['register'])){

        $cid = rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);

        $date = date('Y-m-d');

        if(empty($_POST['firstname'])){
            $errors = "Firstname is empty";
        }else{
            $firstname = test_input($_POST['firstname']);
        }
        if(empty($_POST['lastname'])){
            $errors = "Lastname is empty";
        }else{
            $lastname = test_input($_POST['lastname']);
        }
        if(empty($_POST['email'])){
            $errors = "Email is empty";
        }else{
            $email = test_input($_POST['email']);
        }
        if(empty($_POST['password'])){
            $errors = "Password is empty";
        }else{
            $password = $_POST['password'];
        }

        if($_POST['email'] != $_POST['cemail']){
            $errors = "Email Mismatch";
        }else{
            $email = test_input($_POST['email']);
        }

        if($_POST['password'] != $_POST['cpassword']){
            $errors = "password Mismatch";
        }else{
            $password = test_input($_POST['password']);
        }

        if(isset($errors)){
            $msg = $errors;
        }else{

        $email = mysqli_real_escape_string($conn,$email);
        $sql = "SELECT * FROM admin WHERE email='".$email."'";   
        $query = mysqli_query($conn,$sql);
        $numrows = mysqli_num_rows($query);

        if($numrows > 0){
            $msg = "You have registered before!";
        }else{
            $sql2 = "INSERT INTO admin(admin_id,coll_id,firstname,lastname,admin_passport,email,password,phone,address,state,country,bvn,guarantor_name,guarantor_address,guarantor_phone,guarantor_passport,reg_date)VALUES(NULL,'$cid','$firstname','$lastname',NULL,'$email','$password',NULL,NULL,NULL,'Nigeria',NULL,NULL,NULL,NULL,NULL,'$date')";

            $query2 = mysqli_query($conn,$sql2) or die($sql2);
            if($query2){
                
                $subject = 'WELCOME TO THRIFT PAY!';
                $from = 'THRIFT PAY';
                 // To send HTML mail, the Content-type header must be set
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                 // Create email headers
                $headers .= 'From: '.$from."\r\n".'Reply-To: '.$from."\r\n" .'X-Mailer: PHP/' . phpversion();
                 
                 
                // Compose a simple HTML email message
                $message = '<html><body>';
                $message .= '<div style="width:600px;height:auto;margin:auto;border:#f1f1f1 1px solid;border-radius:5px;">';
                $message .= '<div style="padding:10px 20px">'; 
                $message .='<p>Dear '.$_POST[lastname].'. " ".'.$_POST[firstname].',</p>';
                    
                $message .='<p>Welcome to Thrift Pay</p>';

                $message .='<p>Your Username is '.$_POST[email].',</p>'; 
                $message .='<p>Your Password is '.$_POST[password].',</p>'; 

                $message .='<p>Please do not share your login details with anyone.</p>';

                $message .='<p>Kind regards,</p>';
                $message .= '</div></div> ';
                $message .= '</body></html>';
                 
                // Sending email
                mail($_POST[email], $subject, $message, $headers);

                $msg = "Registration Successful. Check Your Email for account details";
            }else{
                $msg = "Registration Not Successful";
            }
        }
        }
        mysqli_close($conn);
    }
}



?>

<!doctype html>
<html lang="en">

    

<head>
        
        <meta charset="utf-8" />
        <title>Thrift Pay | Admin Registration.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- owl.carousel css -->
        <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.carousel.min.css">

        <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.theme.default.min.css">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body class="auth-body-bg">
        
        <div>
            <div class="container-fluid p-0">
                <div class="row g-0">
                    
                    <div class="col-xl-9">
                        <div class="auth-full-bg pt-lg-5 p-4">
                            <div class="w-100">
                                <div class="bg-overlay"></div>
                                <div class="d-flex h-100 flex-column">
    
                                    <div class="p-4 mt-auto">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-7">
                                                <div class="text-center">
                                                    
                                                    <h4 class="mb-3">Thrift Pay</h4>
                                                    
                                                    <div dir="ltr">
                                                        <div class="owl-carousel owl-theme auth-review-carousel" id="auth-review-carousel">
                                                            <div class="item">
                                                                <div class="py-3">
                                                                    <p class="font-size-16 mb-4">" You are welcome to Thrift Pay Registration Portal. Kindly use the form at the right hand side for registration."</p>
    
                                                                    <div>
                                                                        <h4 class="font-size-16 text-primary">&#169; 2021</h4>
                                                                        <p class="font-size-14 mb-0">- Thrift Pay User</p>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
    
                                                            <div class="item">
                                                                <div class="py-3">
                                                                    <p class="font-size-16 mb-4">You are welcome to Thrift Pay Registration Portal. Kindly use the form at the right hand side for registration."</p>
    
                                                                    <div>
                                                                        <h4 class="font-size-16 text-primary">&#169; 2021</h4>
                                                                        <p class="font-size-14 mb-0">- Thrift Pay User</p>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-3">
                        <div class="auth-full-page-content p-md-5 p-4">
                            <div class="w-100">

                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5">
                                        <a href="index.html" class="d-block auth-logo">
                                            <img src="assets/images/logo-dark.png" alt="" height="18" class="auth-logo-dark">
                                            <img src="assets/images/logo-light.png" alt="" height="18" class="auth-logo-light">
                                        </a>
                                    </div>
                                    <div class="my-auto">
                                        
                                        <div>
                                            <h5 class="text-primary">Register account</h5>
                                            <p class="text-muted">Get your account register now.</p>
                                        </div>
                                        <div class="alert alert-warning alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong><?php if(isset($msg)) echo $msg;?></strong>.
                                        </div>
            
                                        <div class="mt-4">
                                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="needs-validation" novalidate action="https://themesbrand.com/skote/layouts/index.html">
                                                
                                                <div class="mb-3">
                                                    <label for="firstname" class="form-label">First name</label>
                                                    <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Enter firstname" required>
                                                    <div class="invalid-feedback">
                                                        Please Enter firstname
                                                    </div>  
                                                </div>
                                                <div class="mb-3">
                                                    <label for="lastname" class="form-label">Lastname</label>
                                                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Enter lastname" required>
                                                    <div class="invalid-feedback">
                                                        Please Enter lastname
                                                    </div>  
                                                </div>

                                                <div class="mb-3">
                                                    <label for="useremail" class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control" id="useremail" placeholder="Enter email" required>  
                                                    <div class="invalid-feedback">
                                                        Please Enter Email
                                                    </div>        
                                                </div>
                                                <div class="mb-3">
                                                    <label for="confirmemail" class="form-label">Confirm Email</label>
                                                    <input type="email" name="cemail" class="form-control" id="cemail" placeholder="Enter email" required>  
                                                    <div class="invalid-feedback">
                                                        Please Enter Email
                                                    </div>        
                                                </div>
                        
                                                <div class="mb-3">
                                                    <label for="userpassword" class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control" id="userpassword" placeholder="Enter password" required>
                                                    <div class="invalid-feedback">
                                                        Please Enter Password
                                                    </div>       
                                                </div>
                                                <div class="mb-3">
                                                    <label for="userpassword" class="form-label">Password</label>
                                                    <input type="password" name="cpassword" class="form-control" id="userpassword" placeholder="Enter password" required>
                                                    <div class="invalid-feedback">
                                                        Please Enter Password
                                                    </div>       
                                                </div>

                                                <div>
                                                    <p class="mb-0">By registering you agree to the thriftpay <a href="#" class="text-primary">Terms of Use</a></p>
                                                </div>
                                                
                                                <div class="mt-4 d-grid">
                                                    <button type="submit" name="register" class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                                </div>
                                                <!--
                                                <div class="mt-4 text-center">
                                                    <h5 class="font-size-14 mb-3">Sign up using</h5>
                    
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <a href="javascript::void()" class="social-list-item bg-primary text-white border-primary">
                                                                <i class="mdi mdi-facebook"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="javascript::void()" class="social-list-item bg-info text-white border-info">
                                                                <i class="mdi mdi-twitter"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a href="javascript::void()" class="social-list-item bg-danger text-white border-danger">
                                                                <i class="mdi mdi-google"></i>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </div>-->

                                            </form>

                                            <div class="mt-5 text-center">
                                                <p>Already have an account ? <a href="login.php" class="fw-medium text-primary"> Login</a> </p>
                                            </div>
        
                                        </div>
                                    </div>

                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- owl.carousel js -->
        <script src="assets/libs/owl.carousel/owl.carousel.min.js"></script>

        <!-- validation init -->
        <script src="assets/js/pages/validation.init.js"></script>

        <!-- auth-2-carousel init -->
        <script src="assets/js/pages/auth-2-carousel.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>

</html>
