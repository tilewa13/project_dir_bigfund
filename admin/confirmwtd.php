<?php

include "../db.php";
include "../auth.php";

if(isset($_POST['confirm'])){

$sql = "UPDATE withdraw SET status='Confirmed' WHERE status='processing'"; 
$result= mysqli_query($conn,$sql);

$sql2 = "SELECT balance FROM master_table";
$result2 = mysqli_query($conn,$sql2);
$row = mysqli_fetch_assoc($result2);

$prev_balance = $row['balance'];

$balance = $balance - $prev_balance;

$sql3 = "UPDATE tbl_balance SET balance='$balance' WHERE status='processing'"; 
$result3= mysqli_query($conn,$sql3);

if($result){
    $msg = "All Withdrawal(s) Confirmed";
}
}


?>

<!doctype html>
<html lang="en">

    

<head>
        
        <meta charset="utf-8" />
        <title>Bigfund | View Member</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/bigfund.png">

        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />     

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <?php include "navigation.php";?>

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">WITHDRAWAL CONFIRMATION</h4>
                                    <!--
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                            <li class="breadcrumb-item active">Data Tables</li>
                                        </ol>
                                    </div>
                                    -->
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <?php if(isset($msg)){?> <div style="width:100%;height:50px;background:LightGreen;line-height:50px;color:white;text-align:center"><?php echo $msg;?></div> <?php } ?>
        
                                        <h4 class="card-title">Withdrawal Confirmation</h4>
                                        <!--<p class="card-title-desc">The Buttons extension for DataTables
                                            provides a common set of options, API methods and styling to display
                                            buttons on a page that will interact with a DataTable. The core library
                                            provides the based framework upon which plug-ins can built.
                                        </p>-->
        
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                    <th>TRANS ID</th>
                                                    <!--<th>Member ID</th>--
                                                    <th>Name</th>-->
                                                    <th>Passbook ID</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                    
                                                    </tr>   
                                            </thead>
        
        
                                            <tbody>
                                                <?php
                                                    $sql ="SELECT * FROM withdraw WHERE status ='processing'";
                                                    $query = mysqli_query($conn,$sql);
                                                    while($rows = mysqli_fetch_assoc($query)){
                                                        //$id = $rows['id'];
                                                        //for($i=1; $i<=$id ; $i++) { 
                                                         //   $sn = $i;
                                                        //}
                                                        $transid = $rows['w_id'];
                                                        //$passbookname = $rows['passbook_name'];
                                                        //$memberid = $rows['member_id'];
                                                        $name = $rows['withdraw_by'];
                                                        $passbookid = $rows['passbook_id'];
                                                        $amount = $rows['withdraw_amt'];
                                                        $status = $rows['status'];
                                                       
                                                ?>
                                            <tr>
                                                <td><?php echo $transid; ?></td>
                                                    <!--<td><?php echo $memberid; ?></td>--
                                                    <td><?php echo $passbookname; ?></td>-->
                                                    <td><?php echo $passbookid; ?></td>
                                                    <td><?php echo number_format($amount,2);?></td>
                                                    <td><?php echo $status;?></td>
                                                    <td><a href="processwtd.php?pid=<?php echo $passbookid;?>">Confirm</a>
                                                   
                                            </tr>
                                            
                                            <?php }?>
                                            </tbody>
                                        </table>
                                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                                           <!-- <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="mb-3">
                                                            <button type="submit" name="confirm" class="btn btn-primary waves-effect waves-light">Confirm Entries</button>
                                                        </div>
                                                    </div>
                                            </div>-->
                                        </form>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Skote.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Themesbrand
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>

            
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- Required datatable js -->
        <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="assets/libs/jszip/jszip.min.js"></script>
        <script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="assets/js/pages/datatables.init.js"></script>    

        <script src="assets/js/app.js"></script>

    </body>


</html>
