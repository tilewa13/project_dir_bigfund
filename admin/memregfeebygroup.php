<?php
include "../db.php";
include "../auth.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
        <title>Bigfund | Member Reg. Fee by Group</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />

        <link href="assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
        <link href="assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
        <link href="assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css">
        <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="assets/libs/%40chenfengyuan/datepicker/datepicker.min.css">

        <!-- App favicon -->
        <!-- <link rel="shortcut icon" href="assets/images/favicon.ico"> -->
        <link rel="icon" type="image/x-icon" href="assets/images/bigfund.png">

        <!-- DataTables -->
        <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />   
        <!--For column datatables -->  
        <link href="assets/cs/jquery.dataTables.min.css"/>
        <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css"/>

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />


</head>
<body>

<div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <?php include "reportheader.php"?>

                                        <h4 class="card-title" style="margin-top:30px;margin-bottom: -20px;">Member Reg. Fee By Group</h4><br/>
                                        
                                        
                                            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                            <div style="margin-top: 20px;" class="row">
                                                <div class="col-xl-3">
                                                    <select name="groupname" id="formrow-inputState" class="form-select" required>
                                                                <option value="">Select Group</option>
                                                                <?php 
                                                                $sql ="SELECT * FROM group_tbl WHERE status='Active'";
                                                                $result= mysqli_query($conn,$sql);
                                                                while($rows = mysqli_fetch_assoc($result)){
                                                                ?>
                                                                <option value="<?php echo $rows['group_name'];?>"><?php echo $rows['group_name'];?></option>
                                                                <?php }
                                                                ?>     
                                                    </select>
                                                </div>

                                                
                                                <div class="col-xl-3">
                                                    
                                                        <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light">
                                                        <i class="bx bxs-report font-size-16 align-middle me-2"></i> View Report</button>
                                                   
                                                </div>
                                            </div>
                                        <div class="row" style="margin-top:50px;">
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Date</th>
                                                <th>Member Number</th>
                                                <th>Member Name</th>
                                                <th>Phone Number</th>
                                                <th>Group</th>
                                                <th>Account officer</th>
                                                <th>Reg. Fee</th>                             
                                            </tr>
                                            </thead>
        
                                            <tbody>
                                            <?php
                                            $i = 1;
                                            $total = 0;
                                            $balance = 0;
                                            if($_SERVER["REQUEST_METHOD"]=="POST"){
                                                  if(isset($_POST['submit'])){
                                                    $groupname = $_POST['groupname'];
                                                    $sql2 ="SELECT * FROM `loan_request` WHERE group_name='$groupname'";
                                            $result2 = mysqli_query($conn,$sql2);
                                            while($rows = mysqli_fetch_assoc($result2)){
                                                $loanid = $rows['loan_id'];
                                                $loancode = $rows['loan_code'];
                                                $memberid = $rows['member_id'];
                                                $membername = $rows['member_name'];
                                                $groupname = $rows['group_name'];
                                                $phonenumber = $rows['member_phone'];
                                                $accountofficer = $rows['account_officer'];
                                                $guarantorname = $rows['guarantor_name'];
                                                $guarantorpno = $rows['guarantor_pno'];
                                                $guarantorpassport = $rows['guarantor_passport'];
                                                $utilitybill = $rows['utility_bill'];
                                                $relationship = $rows['relationship'];
                                                $guarantoraddress = $rows['guarantor_address'];
                                                $occupation = $rows['occupation'];
                                                $mid = $rows['mid'];
                                                $midno = $rows['midno'];
                                                $loanpurpose = $rows['loan_purpose'];
                                                $income = $rows['income'];
                                                $regfee2 = $rows['reg_fee'];
                                                $appliedamount = $rows['applied_amount'];
                                                // $compulsorysav = $rows['compulsory_sav'];
                                                // $totalpayable = $rows['total_payable'];
                                                $appdate = $rows['app_date'];
                                                // $expirydate = $rows['expiry_date'];
                                                $createdby = $rows['created_by'];
                                                $creationdate = $rows['creation_date'];
                                                $tenor = $rows['tenor'];
                                                $total = $total + $regfee2;
                                            ?>
                                            <tr>
                                                <td><?php echo $i;?></td>
                                                <td><?php echo $creationdate;?></td>
                                                <td><?php echo $memberid;?></td>
                                                <td><?php echo $membername;?></td>
                                                <td><?php echo $phonenumber;?></td> 
                                                <td><?php echo $groupname;?></td>
                                                <td><?php echo $accountofficer;?></td>
                                                <td><?php echo number_format($regfee2,2);?></td>
                                            </tr>
                                        <?php $i++; }
                                                }}?>
                                            </tbody>
                                            <tfoot>
                                                <th>Total</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th><?php echo number_format($total,2);?></th>
                                            </tfoot>
                                        </table>
                                    </div>

                                            </div>
                                        </form>

                                    </div>
                                      
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->

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


          <!-- form advanced init -->
        <script src="assets/js/pages/form-advanced.init.js"></script>
        <script src="assets/js/app.js"></script>


        <!-- Datepicker-->
        <script src="assets/libs/select2/js/select2.min.js"></script>
        <script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/libs/spectrum-colorpicker2/spectrum.min.js"></script>
        <script src="assets/libs/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
        <script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
        <script src="assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="assets/libs/%40chenfengyuan/datepicker/datepicker.min.js"></script>

        <!-- form advanced init -->
        <script src="assets/js/pages/form-advanced.init.js"></script>
        <script src="assets/js/app.js"></script>
</body>
</html>