<div class="wrapper">



  <?php $this->load->view('Common/header'); ?>

  <?php $this->load->view('Common/sidemenu'); ?>

  

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        <?= $heading ?>

      </h1>

      <ol class="breadcrumb">

        <li><a href="<?= site_url(DASHBOARD) ?>"><i class="fa fa-dashboard"></i> Dashboard </a></li>

        <li><a href="<?= site_url(INVOICES) ?>">Manage Invoices</a></li>

        <li class="active"><?= $heading ?></li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <!-- Small boxes (Stat box) -->

      <div class="row">

      	<section class="content">

          <div class="row">

            <div class="col-xs-12">

              <div class="box box-primary">

                <div class="box-body">

                    <div class="col-md-12">

                      <form class="form-horizontal" method="post" action="<?= $action ?>" id="Bill_form" enctype="multipart/form-data">
							<input type="hidden" name="user_id" value="<?= $userdata->id ?>"/>
                          <div class="col-md-5">

                            <div class="form-group">

                              <label for="customerName">Customer Name <span class="text text-danger">*</span> GSTIN: <span class="text text-info" id="gstin"></span></label>

                                <select class="form-control select2" name="Customer_id" id="Customer" data-url="<?= site_url(CUSTOMER_GSTIN) ?>">

                                  <option value="">Select Customer</option>

                                  <?php foreach ($customersdata as $data ){?>

                                    <option value="<?= $data->id ?>"><?= $data->FirstName .' '. $data->LastName?></option>

                                  <?php } ?>

                                </select> 

                                <span class="text text-danger" id="errCustomer"></span>

                            </div>

                            <div class="form-group">

                              <label for="waybill">Waybill No <span class="text text-danger">*</span></label>

                              <input type="text" class="form-control" id="waybill_no" name="waybill"/>

                              <span class="text text-danger" id="errwaybill_no"></span>

                            </div>
							<div class="form-group">

                              <label for="waybill_file">Waybill File <span class="text text-danger">*</span></label>

                              <input type="file" class="form-control" id="waybill_file" name="waybill_file" accept="application/pdf"/>
                              <span class="text text-danger" id="errwaybill_file"></span>

                            </div>

                          </div>

                          <div class="col-md-1"></div>

                          <div class="col-md-6">

                            <div class="form-group">

                              <label for="Invoice">Invoice No</label>

                              <input type="text" class="form-control" id="inv_no" name="invoice_no" readonly value="<?= $invoice_no ?>" />

                            </div>

                            <div class="form-group">

                              <label for="invDate">Invoice Date <span class="text text-danger">*</span></label>

                              <input type="text" class="form-control" id="inv_date" name="invoice_date" readonly/>

                              <span class="text text-danger" id="errinv_date"></span>

                            </div>

                            <div class="form-group">

                              <label for="lorry">Vehicle No <span class="text text-danger">*</span></label>

                              <input type="text" class="form-control" id="Lorry_no" name="Lorry_no"/>

                              <span class="text text-danger" id="errLorry_no"></span>

                            </div>

                            <div class="form-group">

                              <label for="place">Place <span class="text text-danger">*</span></label>

                              <input type="text" class="form-control" id="place" name="Place"/>

                              <span class="text text-danger" id="errplace"></span>

                            </div>

                          </div>

                          <div class="form-group lbl_add_more">

                            <div class="col-md-3 text-center bg-gray">

                            <label for="customerMobile">Product</label>

                            </div>

                            <div class="col-md-2 text-center bg-gray">

                            <label for="customerMobile">HSN Code</label>

                            </div>

                            <div class="col-md-2 text-center bg-gray">

                            <label for="customerMobile">Quantity</label>

                            </div>

                            <div class="col-md-2 text-center bg-gray">

                            <label for="customerMobile">Rate</label>

                            </div>

                            <div class="col-md-2 text-center bg-gray">

                            <label for="customerMobile">Amount</label>

                            </div>

                            <div class="col-md-1 text-center bg-gray">

                            <label for="customerMobile">&nbsp;</label>

                            </div>

                            <div class="clearfix"></div>

                          </div>

                           <div class="field_wrapper mainlent">

                            <div class="form-group testlent">

                              <div class="col-md-3">

                                <select class="form-control product" name="Product_id[]" id="product1" data-no="1" required>

                                  <option value="0">Select Product</option>

                                  <?php foreach ($Product as $data ){?>

                                    <option value="<?= $data->id ?>"><?= $data->Name ?></option>

                                  <?php } ?>

                                </select> 

                              </div>

                              <div class="col-md-2">

                                <input type="text" class="form-control" id="Hsn_code1" name="Hsn_code[]" readonly placeholder="HSN Code"/>

                                <input type="hidden" class="form-control" id="id1" name="pid[]"/>

                              </div>

                              <div class="col-md-2">

                                <div class="input-group">

                                  <input type="text" class="form-control Qty" id="Qty1" name="Qty[]" onchange="changeQty(1)" aria-describedby="basic-addon1" placeholder="Quantity"/>

                                  <div class="input-group-addon" id="unit1"></div>

                                </div>

                                <!-- /.input group -->

                              </div>

                              <div class="col-md-2">

                                <input type="text" class="form-control" id="Price1" name="Price[]" onchange="changeQty(1)" placeholder="Price"/>

                              </div>

                              <div class="col-md-2">

                                <input type="text" class="form-control Amount" id="Amount1" name="Amount[]" readonly placeholder="Amount"/>

                              </div>

                              <a href="javascript:void(0);" class="add_button btn btn-info btn-sm" title="Add field"><i class="fa fa-plus"></i></a>

                            </div>

                            </div>

                            <div class="form-group">

                            <div class="col-md-9 text-right">

                              <label for="totalamount">Taxable Value (<i class="fa fa-inr"></i>)</label>

                            </div>

                            <div class="col-md-2 text-center">

                              <input type="text" class="form-control" id="Gross_amount" name="Gross_amount" readonly/>

                            </div>
                        </div>

                            <div class="clearfix"></div>
                            <div class="form-group">

                                <div class="col-md-9 text-right">

                                   <label for="totalamount">Freight / Addition (<i class="fa fa-inr"></i>)</label>

                                </div>

                                <div class="col-md-2 text-center">

                                  <input type="text" name="Additional_amount" id="additional_amt" class="form-control">

                                </div>

                                <div class="clearfix"></div>

                              </div>

                              <div class="form-group">

                                <div class="col-md-9 text-right">

                                  <label for="cgst">CGST (<span id="CGST_per"><?= $CGST_per ?></span>%)</label>

                                </div>

                                <div class="col-md-2 text-center">

                                  <input type="text" class="form-control" id="CGST" name="CGST" readonly/>

                                  <input type="hidden" class="form-control" id="CGST_percentage" name="CGST_percentage" value="<?= $CGST_per ?>"/>

                                </div>

                                <div class="clearfix"></div>

                              </div>

                              <div class="form-group">

                                <div class="col-md-9 text-right">

                                  <label for="sgst">SGST (<span id="SGST_per"><?= $SGST_per ?></span>%)</label>

                                </div>

                                <div class="col-md-2 text-center">

                                  <input type="text" class="form-control" id="SGST" name="SGST" readonly/>

                                  <input type="hidden" class="form-control" id="SGST_percentage" name="SGST_percentage" value="<?= $SGST_per ?>"/>

                                </div>

                                <div class="clearfix"></div>

                              </div>

                              <div class="form-group">

                                <div class="col-md-9 text-right">

                                  <input type="checkbox" id="isIGST" data-company-gstin="<?= $company_gstin ?>" disabled/>

                                  <label for="igst">IGST (<span id="IGST_per"><?= $IGST_per ?></span>%)</label>

                                </div>

                                <div class="col-md-2 text-center">

                                  <input type="text" class="form-control" id="IGST" name="IGST" readonly/>

                                  <input type="hidden" class="form-control" id="IGST_percentage" name="IGST_percentage" value="<?= $IGST_per ?>"/>

                                </div>

                                <div class="clearfix"></div>

                              </div>
                              <div class="form-group">

                                <div class="col-md-9 text-right">

                                  <label for="cess">CESS (<span id="CESS">Rs. <?= $CESS ?></span>)</label>

                                </div>

                                <div class="col-md-2 text-center">

                                  <input type="text" class="form-control" id="cess" name="CESS" readonly/>

                                  <input type="hidden" class="form-control" id="CESS_value" name="CESS_value" value="<?= $CESS ?>"/>

                                </div>

                                <div class="clearfix"></div>

                              </div>

                              <div class="form-group">

                                <div class="col-md-9 text-right">

                                  <input type="checkbox" id="isTCS"/>

                                  <label for="tcs">TCS (<span id="TCS_per"><?= $TCS_per ?></span>%)</label>

                                </div>

                                <div class="col-md-2 text-center">

                                  <input type="text" class="form-control" id="tcs" name="TCS" readonly/>

                                  <input type="hidden" class="form-control" id="TCS_percentage" name="TCS_percentage" value="<?= $TCS_per ?>"/>

                                </div>

                                <div class="clearfix"></div>

                              </div>
                            </div>

                              <div class="form-group">

                                <div class="col-md-9 text-right">

                                  <label for="amount_payable">Rount Off (<i class="fa fa-inr"></i>)</label>

                                </div>

                                <div class="col-md-2 text-center">

                                  <input type="text" class="form-control" id="Roundoff" name="Roundoff" readonly/>

                                </div>

                                <div class="clearfix"></div>

                              </div>

                              <div class="form-group">

                                <div class="col-md-9 text-right">

                                  <label for="amount_payable">Total Bill Value (<i class="fa fa-inr"></i>)</label>

                                </div>

                                <div class="col-md-2 text-center">

                                  <input type="text" class="form-control" id="Netammount" name="Netammount" readonly/>

                                </div>

                                <div class="clearfix"></div>

                              </div>

                          <div class="form-group">

                            <div class="col-sm-12">

                              <div class="box-footer">

                                <button class="btn btn-info" type="submit" id="btn_bill">Submit</button>

                                <a href="<?= site_url(INVOICES) ?>"><button class="btn btn-default" type="button">Cancel</button></a>

                              </div>

                              <!-- /.box-footer -->

                            </div>

                          </div>

                        <!-- /.box-body -->

                      </form>

                    </div>

                </div><!-- /.box-body -->

              </div><!-- /.box -->

            </div><!-- /.col -->

          </div><!-- /.row -->

        </section>

      </div>

      <!-- /.row -->



    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

  <?php $this->load->view('Common/footer'); ?>

</div>

<!-- ./wrapper -->

<input type="hidden" id="product_url" value="<?= site_url(INVOICES_PRODUCT_AJAX) ?>">

<div class="modal fade" id="popup-customer-info" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Customer Information</h4>
        </div>
        <div class="modal-body">
          <div class="col-md-6">
            <div class="form-group">
               <label class="col-sm-3 control-label pull-left" for="Name">Name</label>
               <div class="col-sm-9 pull-right" id="name">
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
               <label class="col-sm-3 control-label pull-left" for="GST_No">GST_No</label>
               <div class="col-sm-9 pull-right" id="gst_no">
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
               <label class="col-sm-3 control-label pull-left" for="Email">Email</label>
               <div class="col-sm-9 pull-right" id="email">
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
               <label class="col-sm-3 control-label pull-left" for="Mobile">Mobile</label>
               <div class="col-sm-9 pull-right" id="mobile">
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
         <div class="col-md-6">
            <div class="form-group">
               <label class="col-sm-3 control-label pull-left" for="Address">Address</label>
               <div class="col-sm-9 pull-right" id="address">
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
               <label class="col-sm-3 control-label pull-left" for="City">City</label>
               <div class="col-sm-9 pull-right" id="city">
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
               <label class="col-sm-3 control-label pull-left" for="State">State</label>
               <div class="col-sm-9 pull-right" id="state">
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
               <label class="col-sm-3 control-label pull-left" for="Country">Country</label>
               <div class="col-sm-9 pull-right" id="country">
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
               <label class="col-sm-3 control-label pull-left" for="Zip">Zip</label>
               <div class="col-sm-9 pull-right" id="zip">
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group">
               <label class="col-sm-3 control-label pull-left" for="place">Place</label>
               <div class="col-sm-9 pull-right" id="place">
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
         <div class="clearfix"></div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

<script>

    var url = "";

    var actioncolumn="";

    var x = 1; //Initial field counter is 1

     //New input field html 

     var next =x+parseFloat(1);

    var fieldHTML = '<div class="form-group"><div class="col-md-3"><select class="form-control product" name="Product_id[]" id="product'+next+'" data-no="'+next+'"><option value="0">Select Product</option><?php foreach ($Product as $data ){?><option value="<?= $data->id ?>"><?= $data->Name ?></option><?php } ?></select> </div><div class="col-md-2"><input type="text" class="form-control" id="Hsn_code'+next+'" name="Hsn_code[]" readonly placeholder="HSN Code"/><input type="hidden" class="form-control" id="id'+next+'" name="pid[]"/></div><div class="col-md-2"><div class="input-group"><input type="text" class="form-control Qty" id="Qty'+next+'"name="Qty[]" onchange="changeQty('+next+')" aria-describedby="basic-addon1" placeholder="Quantity"/><div class="input-group-addon" id="unit'+next+'"></div></div></div><div class="col-md-2"><input type="text" class="form-control" id="Price'+next+'" name="Price[]" onchange="changeQty('+next+')" placeholder="Price"/></div><div class="col-md-2"><input type="text" class="form-control Amount" id="Amount'+next+'" name="Amount[]" readonly placeholder="Amount"/></div><a href="javascript:void(0);" class="remove_button btn btn-danger btn-sm" title="Remove field"><i class="fa fa-minus"></i></a></div>';

</script>