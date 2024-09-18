<?php

include "../db.php";
include "../auth.php";


$pb=$tenor="";
if(isset($_GET['pb'])){
    $pb = $_GET['pb'];
}

if(isset($_GET['tenor'])){
    $tenor = $_GET['tenor'];
}


if(isset($_GET['confirmrepayment'])){
    $id = $_GET['confirmrepayment'];
    date_default_timezone_set('Africa/Lagos');
    $updatedt=date('Y-m-d h:i:sa');

    $query = "UPDATE rep_tbl SET status='confirmed', confirmed_by='$dbname',update_dt='$updatedt' WHERE trans_id = '".$id."'";
    $result = mysqli_query($conn,$query);

    //PHP to send SMS
    $sql ="SELECT * FROM rep_tbl WHERE tenor='WEEKLY' AND status!='pending' AND loan_code NOT LIKE '%100129%' AND trans_id='".$id."'";
    $query = mysqli_query($conn,$sql);
    $rows = mysqli_fetch_assoc($query);
    $loanno = $rows['loan_code'];
    $loangroup=$rows['group_name'];
    $transid=$rows['trans_id'];
    $accname = $rows['member_name'];
    $memberphone = $rows['member_phone'];
    $postedby=$rows['created_by'];
    $accoff=$rows['account_officer'];
    $value=$rows['credit'];
    $total=$total+$value;

    //SMS MESSAGE
    $curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.smslive247.com/api/v4/sms",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"senderID\":\"BIGFUND\",\"messageText\":\"Your loan balance is N4,000. Kindly balance up. Signed Bigfund.\",\"deliveryTime\":\"2024-08-24T20:35:00.056Z\",\"mobileNumber\":\"07048032566\",\"route\":\"string\"}",
  CURLOPT_HTTPHEADER => [
    "Authorization: Bearer MA-936297c9-291e-4b24-8701-0c6aafdb4a8f",
    "accept: application/json",
    "content-type: application/*+json"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

    if($result){

        echo "<script>window.alert('Transaction Confirmed Successfully');
        window.location.href='repayment_details.php'</script>";
    }
}else{
    echo "Check your Query";
}

?>

<!doctype html>
<html lang="en">

    
<head>
        
        <meta charset="utf-8" />
        <title>Bigfund | Confirm Repayment</title>
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
                                    <h4 class="mb-sm-0 font-size-18"><a href="confirmrepayment2.php">CONFIRM ENTRIES</a>/ LOAN REPAYMENT CONFIRMATION</h4>
                                    <!--
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                            <li class="breadcrumb-item active">Data Tables</li>
                                        </ol>
                                    </div>-->

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <?php if(isset($msg)){?> <div style="width:100%;height:50px;background:LightGreen;line-height:50px;color:white;text-align:center"><?php echo $msg;?></div> <?php } ?>
        
                                        <h4 class="card-title">Loan Repayment Confirmation</h4>
        
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                    <th>SN</th>
                                                    <th>Trans Date</th>
                                                    <th>Loan Code</th>
                                                    <th>Member Name</th>
                                                    <th>Account Officer</th>
                                                    <th>Group</th>
                                                    <th>Amount</th>
                                                    <th>Narration</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                    </tr>   
                                            </thead>
        
                                            <tbody>
                                                <?php
                                                    $bal=0;
                                                    $i=1;
                                                    $sql ="SELECT * FROM rep_tbl WHERE loan_code NOT LIKE '%100219%' AND member_name NOT LIKE '%Loan Account%' AND status='pending' AND status2!='deleted' AND created_by='$pb' AND tenor='$tenor'";
                                                    $query = mysqli_query($conn,$sql);
                                                    while($rows = mysqli_fetch_assoc($query)){
                                                        $temp_rp_id = $rows['rp_id'];
                                                        $transid = $rows['trans_id'];
                                                        $transdate = $rows['date_time'];
                                                        $loan_code = $rows['loan_code'];
                                                        $name = $rows['member_name'];
                                                        $accoff = $rows['account_officer'];
                                                        $groupname = $rows['group_name'];
                                                        $reverseamount = $rows['reverseamount'];
                                                        $repaymentamount = $rows['repayment_amount'];
                                                        if($repaymentamount==0){
                                                            $amount = $reverseamount;
                                                        }else{
                                                            $amount = $repaymentamount;
                                                        }
                                                        // $amount = $rows['repayment_amount'];
                                                        $bal = $bal + $amount;
                                                        $narration=  $rows['narration'];
                                                        $status = $rows['status'];
                                                ?>
                                            <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $transdate; ?></td>
                                                    <td><?php echo $loan_code; ?></td>
                                                    <td><?php echo strtoupper($name); ?></td>
                                                    <td><?php echo strtoupper($accoff); ?></td>
                                                    <td><?php echo strtoupper($groupname); ?></td>
                                                    <td><?php echo number_format($amount,2); ?></td>
                                                    <td><?php echo $narration; ?></td>
                                                    <td><span class="badge bg-warning"><?php echo $status; ?></span></td>
                                                    <td>
                                                        <a href="javascript:confirmrepayment(<?php echo $rows['trans_id']; ?>)"><button class="btn btn-primary btn-sm">Confirm</button></a>
                                                              <a href="javascript:deleterepayment(<?php echo $rows['trans_id']; ?>)"><button class="btn btn-primary btn-sm">Delete</button></a>
                                                        
                                            </tr>
                                            <?php $i++; }?>
                                            </tbody>
                                            <tfoot>
                                                <th>Total</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th><?php echo number_format($bal,2);?></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tfoot>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <?php include "footer.php";?>
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
        <script>
            function confirmrepayment(id){
            if(confirm('Are You Sure You Want To Confirm This Transaction')){
            window.location.href='confirmloanrepayment2.php?confirmrepayment='+id;
            }
            }
        </script>

        <script>
            function deleterepayment(id){
            if(confirm('Are You Sure You Want To Delete This Repayment')){
            window.location.href='deleterepayment.php?deleterepayment='+id;
            }
            }
        </script>

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

        <!-- Sweet Alerts js -->
        <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

        <!-- Sweet alert init js-->
        <script src="assets/js/pages/sweet-alerts.init.js"></script>

        
    </body>


</html>