//Script for input only numbers
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
    && (charCode < 48 || charCode > 57))
     return false;

  return true;
}
//Script for input filter for input type text box
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }
    });
  };
}(jQuery));
$(".search-menu-box").on('input', function() {
  var filter = $(this).val();
  $(".sidebar-menu > li").each(function(){
      if ($(this).text().search(new RegExp(filter, "i")) < 0) {
          $(this).hide();
      } else {
          $(this).show();
      }
  });
});
$(function () {
    if(typeof release_note_url !== 'undefined' && release_note_url){
      $.ajax({
        url: release_note_url,
        type: "post",
        dataType: "html",
        success: function (response) {
          if(response != 1){
            $("#release_notes").fadeIn("slow");
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        }
      });
    }
    $('.release_cancel').off( "click");
    $('.release_cancel').on( "click", function() {
      $("#release_notes").fadeOut("slow");
    });
    $('.release_stop').off( "click");
    $('.release_stop').on( "click", function() {
      var data_url = $(this).attr('data-url');
      $.ajax({
        url: data_url,
        type: "post",
        dataType: "html",
        success: function (response) {
          if(response == 1){
            $("#release_notes").fadeOut("slow");
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        }
      });
    });
    $('.release_note').off( "click");
    $('.release_note').on( "click", function() {
      var data_url = $(this).attr('data-url');
      if(data_url != ''){
        window.open(data_url, "_blank"); 
      }
    });
    $('#year').on('change', function(){
        var data_url = $(this).attr('data-url');
      $.ajax({
        url: data_url,
        type: "post",
        data: "id="+$(this).val(),
        dataType: "json",
        success: function (response) {
          $("#month").empty().append("<option value=''> - Select Month - </option>");
          $.each( response, function( key, value ) {
            $.each( value, function( key1, value1 ) {
                $("#month").append("<option value='"+value1+"'>"+value1+"</option>");
            });
          });
          $('.reports_datatable').dataTable().api().ajax.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        }
      });
    });
    //Script for Saving tax and bank details
    $('#saveCGST').hide();
    $('#saveSGST').hide();
    $('#saveIGST').hide();
    $('#saveCESS').hide();
    $('#saveTCS').hide();
    $('#CGSTinput').hide();
    $('#SGSTinput').hide();
    $('#IGSTinput').hide();
    $('#CESSinput').hide();
    $('#TCSinput').hide();
    $('#save_1').hide();
    $('#save_2').hide();
    $('#input_bank_name_1').hide();
    $('#input_AC_No_1').hide();
    $('#input_branch_1').hide();
    $('#input_IFC_Code_1').hide();
    $('#input_bank_name_2').hide();
    $('#input_AC_No_2').hide();
    $('#input_branch_2').hide();
    $('#input_IFC_Code_2').hide();
    //For Voucher bank detail hide
    $("#bank_cheque").hide();
    $("#bank_date").hide();
    $("#bank_name").hide();
    //For Voucher Entry
  $("input[name='voucher_type']").click(function(){
    var site_url = $('#site_url').val();  
      if($(this).val() == 'Debit'){
        $('#amount').attr('placeholder', 'Debit Amount');
        $('#amount').attr('name', 'debit_amount');
        $('#lblamount').html('Debit Amount <span class="text text-danger">*</span>');
      } else {
        $('#amount').attr('placeholder', 'Credit Amount');
        $('#amount').attr('name', 'credit_amount');
        $('#lblamount').html('Credit Amount <span class="text text-danger">*</span>');
      }
      get_data(site_url+'/'+$(this).val());
  });
  $("input[name='payment_type']").click(function(){
      if($(this).val() == 'Bank'){
        $("#bank_cheque").fadeIn('slow');
        $("#bank_date").fadeIn('slow');
        $("#bank_name").fadeIn('slow');
      } else {
        $("#bank_cheque").fadeOut('slow');
        $("#bank_date").fadeOut('slow');
        $("#bank_name").fadeOut('slow');
      }
  });
    $("#edit_1").click(function(event){
      $('#input_bank_name_1').show();
      $('#input_AC_No_1').show();
      $('#input_branch_1').show();
      $('#input_IFC_Code_1').show();
      $('#dis_bank_name_1').hide();
      $('#dis_bank_AC_NO_1').hide();
      $('#dis_Branch_1').hide();
      $('#dis_IFC_Code_1').hide();
      $('#edit_1').hide();
      $('#save_1').show();
    });
    $("#edit_2").click(function(event){
      $('#input_bank_name_2').show();
      $('#input_AC_No_2').show();
      $('#input_branch_2').show();
      $('#input_IFC_Code_2').show();
      $('#dis_bank_name_2').hide();
      $('#dis_bank_AC_NO_2').hide();
      $('#dis_Branch_2').hide();
      $('#dis_IFC_Code_2').hide();
      $('#edit_2').hide();
      $('#save_2').show();
    });
    $("#save_1").click(function(event){
      var id = $("#id_1").val();
      var bank_name = $("#input_bank_name_1").val();
      var Ac_no = $("#input_AC_No_1").val();
      var branch = $("#input_branch_1").val();
      var ifc_code = $('#input_IFC_Code_1').val();
      save_data(id,"bank_name="+bank_name+"&account_no="+Ac_no+"&branch="+branch+"&IFC_code="+ifc_code);
      $('#input_bank_name_1').hide();
      $('#input_AC_No_1').hide();
      $('#input_branch_1').hide();
      $('#input_IFC_Code_1').hide();
      $('#dis_bank_name_1').show();
      $('#dis_bank_AC_NO_1').show();
      $('#dis_Branch_1').show();
      $('#dis_IFC_Code_1').show();
      $('#edit_1').show();
      $('#dis_bank_name_1').text('');
      $('#dis_bank_AC_NO_1').text('');
      $('#dis_Branch_1').text('');
      $('#dis_IFC_Code_1').text('');
      $('#dis_bank_name_1').text(bank_name);
      $('#dis_bank_AC_NO_1').text(Ac_no);
      $('#dis_Branch_1').text(branch);
      $('#dis_IFC_Code_1').text(ifc_code);
      $('#save_1').hide();
    });
    $("#save_2").click(function(event){
      var id = $("#id_2").val();
      var bank_name = $("#input_bank_name_2").val();
      var Ac_no = $("#input_AC_No_2").val();
      var branch = $("#input_branch_2").val();
      var ifc_code = $('#input_IFC_Code_2').val();
      save_data(id,"bank_name="+bank_name+"&account_no="+Ac_no+"&branch="+branch+"&IFC_code="+ifc_code);
      $('#input_bank_name_2').hide();
      $('#input_AC_No_2').hide();
      $('#input_branch_2').hide();
      $('#input_IFC_Code_2').hide();
      $('#dis_bank_name_2').show();
      $('#dis_bank_AC_NO_2').show();
      $('#dis_Branch_2').show();
      $('#dis_IFC_Code_2').show();
      $('#edit_2').show();
      $('#dis_bank_name_2').text('');
      $('#dis_bank_AC_NO_2').text('');
      $('#dis_Branch_2').text('');
      $('#dis_IFC_Code_2').text('');
      $('#dis_bank_name_2').text(bank_name);
      $('#dis_bank_AC_NO_2').text(Ac_no);
      $('#dis_Branch_2').text(branch);
      $('#dis_IFC_Code_2').text(ifc_code);
      $('#save_2').hide();
    });
    $("#editCGST").click(function(event){
      $('#saveCGST').show();
      $('#editCGST').hide();
      $('#CGSTinput').show();
      $('#disCGST').hide();
    });
    $("#editSGST").click(function(event){
      $('#saveSGST').show();
      $('#editSGST').hide();
      $('#SGSTinput').show();
      $('#disSGST').hide();
    });
    $("#editIGST").click(function(event){
      $('#saveIGST').show();
      $('#editIGST').hide();
      $('#IGSTinput').show();
      $('#disIGST').hide();
    });
    $("#editCESS").click(function(event){
      $('#saveCESS').show();
      $('#editCESS').hide();
      $('#CESSinput').show();
      $('#disCESS').hide();
    });
    $("#saveCESS").click(function(event){
      var id = $("#idCESS").val();
      var CESS = $("#CESSinput").val();
      save(id, CESS);
      $('#editCESS').show();
      $('#saveCESS').hide();
      $('#CESSinput').hide();
      $('#disCESS').show();
      $('#disCESS').text('');
      $('#disCESS').text('Rs. '+CESS);
    });
    $("#editTCS").click(function(event){
      $('#saveTCS').show();
      $('#editTCS').hide();
      $('#TCSinput').show();
      $('#disTCS').hide();
    });
    $("#saveTCS").click(function(event){
      var id = $("#idTCS").val();
      var TCS = $("#TCSinput").val();
      save(id, TCS);
      $('#editTCS').show();
      $('#saveTCS').hide();
      $('#TCSinput').hide();
      $('#disTCS').show();
      $('#disTCS').text('');
      $('#disTCS').text(TCS+'%');
    });
    $("#saveCGST").click(function(event){
      var id = $("#idCGST").val();
      var CGST = $("#CGSTinput").val();
      save(id, CGST);
      $('#editCGST').show();
      $('#saveCGST').hide();
      $('#CGSTinput').hide();
      $('#disCGST').show();
      $('#disCGST').text('');
      $('#disCGST').text(CGST+' %');
    });
    $("#saveSGST").click(function(event){
      var id = $("#idSGST").val();
      var SGST = $("#SGSTinput").val();
      save(id, SGST);
      $('#editSGST').show();
      $('#saveSGST').hide();
      $('#SGSTinput').hide();
      $('#disSGST').show();
      $('#disSGST').text('');
      $('#disSGST').text(SGST+' %');
    });
    $("#saveIGST").click(function(event){
      var id = $("#idIGST").val();
      var IGST = $("#IGSTinput").val();
      save(id, IGST);
      $('#editIGST').show();
      $('#saveIGST').hide();
      $('#IGSTinput').hide();
      $('#disIGST').show();
      $('#disIGST').text('');
      $('#disIGST').text(IGST+' %');
    });
    //Scripts Ends for updating tax and bank details
    //Add more functionlity for Invoice page creation
    var maxField = 6; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    $(addButton).click(function(){ //Once add button is clicked
    var product = $("#product1").val();
    var flag=0;
      $(".product").each(function(){
          var product=$(this).val();
         if(product==0)
         {
             flag=1;
         }
      });
      
      if(flag==1)
      {
        alert("Please Select Product Name");
        return false;
      }
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
            if(x > 2){
              $('#product2').attr('data-no',x);
              $('#product2').attr('id','#product'+x);
              $('#Hsn_code2').attr('id','#Hsn_code'+x);
              $('#id2').attr('id','#id'+x);
              $('#Qty2').attr('onchange','changeQty('+x+')');
              $('#Price2').attr('onchange','changeQty('+x+')');
              $('#Qty2').attr('id','#Qty'+x);
              $('#unit2').attr('id','#unit'+x);
              $('#Price2').attr('id','#Price'+x);
              $('#Amount2').attr('id','#Amount'+x);
            }
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
    //Initialize Select2 Elements
    $('.select2').select2({
      width: "100%"
    });
    //Geting product details for invoice creation
    $(document).on({
      change: function() {
        var item=$(this);
        var next =item.attr('data-no');
        var product_id = item.val();
        var product_url = $('#product_url').val();
        $.ajax({
            url: product_url,
            type: "post",
            dataType: "html",
            data:  "id="+product_id,
            success: function (response) {
                console.log(response);
                console.log(next);
                $('#Hsn_code'+next).val(jQuery.parseJSON(response).Hsn_code);
                $('#id'+next).val(jQuery.parseJSON(response).id);
                $('#Qty'+next).val('1');
                $('#unit'+next).html(jQuery.parseJSON(response).Unit);
                $('#Price'+next).val(jQuery.parseJSON(response).Cost);
                $('#Amount'+next).val((jQuery.parseJSON(response).Cost) * 1);
                var CESS = $("#CESS_value").val();
                var cess_amt = CESS * 1;
                console.log(cess_amt);
                $('#cess').val(cess_amt);
                sum(next);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
      }
    }, '.product');
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    //Invoice Date Picker
    $('#inv_date').datepicker({
      autoclose: true,
      todayHighlight: true,
    });
    //Receipt Date Picker
    $('#rec_date').datepicker({
      autoclose: true,
      todayHighlight: true,
    });
    //Voucher Date Picker
    $('#voucher_date').datepicker({
      autoclose: true,
      todayHighlight: true,
    });
    //For Bank Cheque Date
    $("#cheque_date").datepicker({
      autoclose: true,
      endDate: "+2M",
      startDate: "-2M",
      todayHighlight: true,
    });
    $('#inv_date,#rec_date,#voucher_date,#cheque_date').datepicker('setDate', today);
    //Common Server Side Data Table for all list Pages
    $('.example_datatable').DataTable({
        // Processing indicator
        "processing": true,
        responsive: true,
        // DataTables server-side processing mode
        "serverSide": true,
        // Initial no order.
        "order": [],
        // Load data from an Ajax source
        "ajax": {
            "url": url,
            "type": "POST"
        },
        //Set column definition initialisation properties
        "columnDefs": [{ 
            "targets": [0],
            "orderable": false
        }]
    });
    var current_fy = $(".current-fy").text();
    var ledger_table = $('.ledger_datatable').DataTable({
        //"dom": 'fBrtip<"clear">R',
        "lengthMenu": [[25, 100, -1], [25, 100, "All"]],
        "pageLength": 25,
        "bLengthChange": true,
        // Processing indicator
        "processing": true,
        "searching": false,
        "responsive": true,
        "serverSide": true,
        "bSort" : false,
        "ajax": {
            "url": url,
            "type": "POST",
            "data": function(d) {               
                //d.SearchData = "customer='"+$("#month").val()+"'&start='"+$("#start").val()+"'&end='"+$("#end").val()+"'";//alert(d.SearchData);
                d.SearchData = $("#customer_ledger").val();
            }
        },
        "buttons": [
            {
                "extend": 'print',
                "text": '<span class="fa fa-print"></span> Print',
                "exportOptions": {
                    "modifier": {
                        "search": 'applied',
                        "order": 'applied'
                    }
                },
                "messageTop": function () {
                    return '<center>'+current_fy+'</center>';
                },
                "messageBottom": null,
                "title": function (){
                    var customer_name = $('#customer_ledger option:selected').text();
                    return '<center>'+customer_name+'</center>';
                }
            },
            {
                "extend": 'excel',
                "text": '<span class="fa fa-file-excel-o"></span> Excel',
                "exportOptions": {
                    "modifier": {
                        "search": 'applied',
                        "order": 'applied'
                    }
                },
                "messageTop": function () {
                    return current_fy;
                },
                "title": function (){
                    var customer_name = $('#customer_ledger option:selected').text();
                    return customer_name;
                },
                "filename": function (){
                    var customer_name = $('#customer_ledger option:selected').text();
                    return customer_name+'_ledger';
                }, 
                "customize": function(xlsx){
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row a[r^="A"]', sheet).attr('s','2');
                    $('row:first c', sheet).attr('s','51');
                }
            },
            {
                "extend": 'pdf',
                "text": '<span class="fa fa-file-pdf-o"></span> PDF',
                "exportOptions": {
                    "modifier": {
                        "search": 'applied',
                        "order": 'applied'
                    }
                },
                "messageTop": function () {
                    return current_fy;
                },
                "title": function (){
                    var customer_name = $('#customer_ledger option:selected').text();
                    return customer_name;
                },
                "filename": function (){
                    var customer_name = $('#customer_ledger option:selected').text();
                    return customer_name+'_ledger';
                },
                "customize": function(doc) {
                    doc.styles.tableHeader.alignment= 'center';
                    doc.styles.message = {
                        fontSize: '16',
                        alignment: 'center'
                    };
                    doc.styles.title = {
                        fontSize: '16',
                        alignment: 'center'
                    };
                }  
            }
        ],
        // other options
    });
    function createCellPos( n ){
        var ordA = 'A'.charCodeAt(0);
        var ordZ = 'Z'.charCodeAt(0);
        var len = ordZ - ordA + 1;
        var s = "";

        while( n >= 0 ) {
            s = String.fromCharCode(n % len + ordA) + s;
            n = Math.floor(n / len) - 1;
        }

        return s;
    }
    $('#export_print').on('click', function(e) {
            e.preventDefault();
            ledger_table.button(0).trigger();
    });
    $('#export_excel').on('click', function(e) {
            e.preventDefault();
            ledger_table.button(1).trigger();
    });
    $('#export_pdf').on('click', function(e) {
            e.preventDefault();
            ledger_table.button(2).trigger();
    });
    $('#customer_ledger').on('change', function(){
        $('.ledger_datatable').dataTable().api().ajax.reload();
    });
    //Ckeditor 
    try{CKEDITOR.replace('editor1');}catch{}
    
    /*$("#Cost").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });*/
	//Get GST Number 
	$("#Supplier").on('change', function() {
		var data_url = $(this).attr('data-url');
		$.ajax({
            url: data_url,
            type: "post",
            dataType: "html",
            data:  "id="+$(this).val(),
            success: function (response) {
              var data = JSON.parse(response);
			  $('#gstin').empty();
			  $('#gstin').text(data.GST_No);
              //alert(data.GST_No);
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            }
        });
	});
	$("#Customer").on('change', function() {
            var data_url = $(this).attr('data-url');
            $.ajax({
                url: data_url,
                type: "post",
                dataType: "html",
                data:  "id="+$(this).val(),
                success: function (response) {
                    var data = JSON.parse(response);
                    $('#gstin').empty();
                    $('#gstin').text(data.GST_No).attr('json-data', response);
                    $('#place').val(data.place);
                    var company_gstin = $("#isIGST").attr('data-company-gstin');
                    if(data.GST_No.slice(0, 2) == company_gstin.slice(0, 2)){
                        $('#isIGST').prop('checked', false);
                    } else {
                        $('#isIGST').prop('checked', true);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  console.log(textStatus, errorThrown);
                }
            });
	});
        $("#gstin").on("click", function(){
            var json = $(this).attr('json-data');
            $('#popup-customer-info').modal({
                show: true
            });
            var data = JSON.parse(json);
            $('#name').text(data.FirstName+' '+data.LastName);
            $('#gst_no').text(data.GST_No);
            $('#email').text(data.Email);
            $('#mobile').text(data.Mobile);
            $('#address').text(data.Address);
            $('#city').text(data.City);
            $('#state').text(data.State);
            $('#country').text(data.Country);
            $('#zip').text(data.Zip);
            $('#place').text(data.place);
            //alert(json);
        });
    //Validation for voucher creation
    $("#voucher_btn").click( function (event){
      var voucher_type = $(".voucher_type").is(':checked');
      var voucher_date = $("#voucher_date").val();
      var voucher_no = $("#voucher_no").val().trim();
      var account_name = $("#account_name").val().trim();
      var payment_type = $(".payment_type").is(':checked');
      var cheque_no = $("#cheque_no").val().trim();
      var cheque_date = $("#cheque_date").val();
      var bank_name = $("#bankname").val().trim();
      var paid_to = $("#paid_to").val().trim();
      var amount = $("#amount").val().trim();
      if(!voucher_type){
        var errVtype = "Please Select Voucher Type";
        $("#errVtype").text(errVtype).fadeIn("slow");
        $("#voucher_type").focus();
        setTimeout(function(){
          $("#errVtype").fadeOut("slow");
        },2000);
        return false;
      }
      if(voucher_date=='')
      {
        var errvoucher_date = "Please Select Voucher Date";
        $("#errvoucher_date").text(errvoucher_date).fadeIn("slow");
        $("#voucher_date").focus();
        setTimeout(function(){
          $("#errvoucher_date").fadeOut("slow");
        },2000);
        return false;
      }
      if(voucher_no=='')
      {
        var errvoucher_no = "Please Enter Voucher No";
        $("#errvoucher_no").text(errvoucher_no).fadeIn("slow");
        $("#voucher_no").focus();
        setTimeout(function(){
          $("#errvoucher_no").fadeOut("slow");
        },2000);
        return false;
      }
      if(account_name=='')
      {
        var erraccount_name = "Please Enter Account Name";
        $("#erraccount_name").text(erraccount_name).fadeIn("slow");
        $("#account_name").focus();
        setTimeout(function(){
          $("#erraccount_name").fadeOut("slow");
        },2000);
        return false;
      }
      if(!payment_type){
        var errpayment_type = "Please Select Payment Type";
        $("#errpayment_type").text(errpayment_type).fadeIn("slow");
        $("#payment_type").focus();
        setTimeout(function(){
          $("#errpayment_type").fadeOut("slow");
        },2000);
        return false;
      } 
      if($(".payment_type:checked").val() == 'Bank'){
        if(cheque_no == ''){
          var errcheque_no = "Please Enter Cheque No";
          $("#errcheque_no").text(errcheque_no).fadeIn("slow");
          $("#cheque_no").focus();
          setTimeout(function(){
            $("#errcheque_no").fadeOut("slow");
          },2000);
          return false;
        }
        if(cheque_date == ''){
          var errcheque_date = "Please Select Cheque Date";
          $("#errcheque_date").text(errcheque_date).fadeIn("slow");
          $("#cheque_date").focus();
          setTimeout(function(){
            $("#errcheque_date").fadeOut("slow");
          },2000);
          return false;
        }
        if(bank_name == ''){
          var errbank_name = "Please Enter Bank Name";
          $("#errbank_name").text(errbank_name).fadeIn("slow");
          $("#bankname").focus();
          setTimeout(function(){
            $("#errbank_name").fadeOut("slow");
          },2000);
          return false;
        }
      }
      if(paid_to == ''){
        var errpaid_to = "Please Enter Name Of Person Amount is Paid";
        $("#errpaid_to").text(errpaid_to).fadeIn("slow");
        $("#paid_to").focus();
        setTimeout(function(){
          $("#errpaid_to").fadeOut("slow");
        },2000);
        return false;
      }
      if(amount == ''){
        var erramount = "Please Enter Amount to be Pay";
        $("#erramount").text(erramount).fadeIn("slow");
        $("#amount").focus();
        setTimeout(function(){
          $("#erramount").fadeOut("slow");
        },2000);
        return false;
      }
      else
      {
        $('#voucher_btn').attr('type','submit');
      }
    });
    
    //Validation for product creation and updation
    $("#button").click(function(event){
      name = $("#Name").val().trim();
      Description = CKEDITOR.instances['editor1'].getData();
      Hsn_code = $("#Hsn_code").val().trim();
      Unit = $("#Unit").val().trim();
      Cost = $("#Cost").val().trim();
      if(name=='')
      {
        var ename = "Please Enter Product Name";
        $("#errname").text(ename).fadeIn("slow");
        $("#name").focus();
        setTimeout(function(){
          $("#errname").fadeOut("slow");
        },2000);
        return false;
      }
      if(Description=='')
      {
        var eDescription = "Please Enter Product Description";
        $("#errdescription").text(eDescription).fadeIn("slow");
        $("#editor1").focus();
        setTimeout(function(){
          $("#errdescription").fadeOut("slow");
        },2000);
        return false;
      }
      if(Hsn_code=='')
      {
        var Hsn_code = "Please Enter Product Hsn Code";
        $("#errhsncode").text(Hsn_code).fadeIn("slow");
        $("#Hsn_code").focus();
        setTimeout(function(){
          $("#errhsncode").fadeOut("slow");
        },2000);
        return false;
      }
      if(Unit=='')
      {
        var eUnit = "Please Enter Product Unit";
        $("#errunit").text(eUnit).fadeIn("slow");
        $("#Unit").focus();
        setTimeout(function(){
          $("#errunit").fadeOut("slow");
        },2000);
        return false;
      }
      if(Cost=='')
      {
        var eCost = "Please Enter Product Cost";
        $("#errcost").text(eCost).fadeIn("slow");
        $("#Cost").focus();
        setTimeout(function(){
          $("#errcost").fadeOut("slow");
        },2000);
        return false;
      }
      else
      {
        $('#button').attr('type','submit');
      }
    }); 
    var base_url = $('#base_url').val();
    //Date picker for date of birth in customer creation form
    $('.DOB').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      locale: {
            format: 'YYYY-MM-DD'
        },
      minYear: 1901,
      maxDate: new Date(),
      maxYear: parseInt(moment().format('YYYY'),10)
    }, function(start, end, label) {
      var years = moment().diff(start, 'years');
      //alert("You are " + years + " years old!");
    });
    //Date picker for date of opening balance in customer creation form
    $('.Balance_dt').daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      locale: {
            format: 'YYYY-MM-DD'
        },
      minYear: 1901,
      maxDate: new Date(),
      maxYear: parseInt(moment().format('YYYY'),10)
    }, function(start, end, label) {
      var years = moment().diff(start, 'years');
      //alert("You are " + years + " years old!");
    });
    //do something, like clearing an input
    $('.DOB').val('');
    var customer_id = $('#id').val();
    //Customer Form Validation
    $("#customer_btn").click(function(event){
      var FirstName = $("#FirstName").val().trim();
      //var LastName = $("#LastName").val().trim();
      var DOB = $("#DOB").val().trim();
      var GST_No = $("#GST_No").val().trim();
      var Email = $("#Email").val().trim();
      var Mobile = $("#Mobile").val().trim();
      var Address = $("#Address").val().trim();
      var Country = $("#Country").val();
      var State = $("#State").val();
      var Cities = $("#Cities").val();
      var Zip_code = $("#Zip").val();
      var Place = $("#Place").val();
      var pattern_email=/^[a-z0-9._-]+@[a-z]+.[a-z.]{2,5}$/i;
      var reggst = /^([0-9]){2}([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([0-9]){1}([a-zA-Z]){1}([0-9]){1}?$/;
      var Opening_balance = $("#Opening_balance").val();
      var Balance_as_on = $("#Balance_as_on").val();
      if(GST_No=='')
      {
        var eGST_No = "Please Enter GST No.";
        $("#errGST_No").text(eGST_No).fadeIn("slow");
        $("#GST_No").focus();
        setTimeout(function(){
          $("#errGST_No").fadeOut("slow");
        },2000);
        return false;
      }
      /*else if(!reggst.test(GST_No) && GST_No.length!=15){
        var eGST_No = "GST Identification Number is not valid. It should be in this '11AAAAA1111Z1A1' format";
        $("#errGST_No").text(eGST_No).fadeIn("slow");
        $("#GST_No").focus();
        setTimeout(function(){
          $("#errGST_No").fadeOut("slow");
        },5000);
        return false;
      }*/
      if(FirstName=='')
      {
        var efname = "Please Enter First Name";
        $("#errfname").text(efname).fadeIn("slow");
        $("#FirstName").focus();
        setTimeout(function(){
          $("#errfname").fadeOut("slow");
        },2000);
        return false;
      }
      /*if(LastName=='')
      {
        var eLastName = "Please Enter Last Name";
        $("#errLastName").text(eLastName).fadeIn("slow");
        $("#LastName").focus();
        setTimeout(function(){
          $("#errLastName").fadeOut("slow");
        },2000);
        return false;
      }*/
      /*if(DOB=='')
      {
        var eDOB = "Please Enter Date Of Birth";
        $("#errDOB").text(eDOB).fadeIn("slow");
        $("#DOB").focus();
        setTimeout(function(){
          $("#errDOB").fadeOut("slow");
        },2000);
        return false;
      }*/
     /* if(Email=='')
      {
        var eEmail = "Please Enter Email";
        $("#errEmail").text(eEmail).fadeIn("slow");
        $("#Email").focus();
        setTimeout(function(){
          $("#errEmail").fadeOut("slow");
        },2000);
        return false;
      }
      else if(!pattern_email.test(Email))
      {
        var eEmail = "Please Enter Valid Email";
        $("#errEmail").text(eEmail).fadeIn("slow");
        $("#Email").focus();
        setTimeout(function(){
          $("#eEmail").fadeOut("slow");
        },2000);
        return false;
      }*/
      /*if(Mobile=='')
      {
        var eMobile = "Please Enter Mobile";
        $("#errMobile").text(eMobile).fadeIn("slow");
        $("#Mobile").focus();
        setTimeout(function(){
          $("#errMobile").fadeOut("slow");
        },2000);
        return false;
      }
      else if(Mobile.length <= 9 || Mobile.length >= 11)
      {
        var emobile = "Please Enter Valid 10 digit Mobile";
        $("#errMobile").text(emobile).fadeIn("slow");
        $("#Mobile").focus();
        setTimeout(function(){
          $("#errMobile").fadeOut("slow");
        },2000);
        return false;
      }*/
      if(Address=='')
      {
        var eAddress = "Please Enter Address";
        $("#errAddress").text(eAddress).fadeIn("slow");
        $("#Address").focus();
        setTimeout(function(){
          $("#errAddress").fadeOut("slow");
        },2000);
        return false;
      }
      if(Country=='')
      {
        var eCountry = "Please Enter Country";
        $("#errCountry").text(eCountry).fadeIn("slow");
        $("#Country").focus();
        setTimeout(function(){
          $("#errCountry").fadeOut("slow");
        },2000);
        return false;
      }
      if(State=='')
      {
        var eState = "Please Enter State";
        $("#errState").text(eState).fadeIn("slow");
        $("#State").focus();
        setTimeout(function(){
          $("#errState").fadeOut("slow");
        },2000);
        return false;
      }
      if(Cities=='')
      {
        var eCities = "Please Enter Cities";
        $("#errCities").text(eCities).fadeIn("slow");
        $("#Cities").focus();
        setTimeout(function(){
          $("#errCities").fadeOut("slow");
        },2000);
        return false;
      }
      if(Zip_code=='')
      {
        var eZip = "Please Enter Zip";
        $("#errZip").text(eZip).fadeIn("slow");
        $("#Zip").focus();
        setTimeout(function(){
          $("#errZip").fadeOut("slow");
        },2000);
        return false;
      }
      if(Place == '') {
          var ePlace = "Please Enter Place";
        $("#errPlace").text(ePlace).fadeIn("slow");
        $("#Place").focus();
        setTimeout(function(){
          $("#errPlace").fadeOut("slow");
        },2000);
        return false;
      }
      if(Opening_balance == ''){
        var errOpening_balance = "Please Enter Opening Balance";
        $("#errOpening_balance").text(errOpening_balance).fadeIn("slow");
        $("#Opening_balance").focus();
        setTimeout(function(){
          $("#errOpening_balance").fadeOut("slow");
        },2000);
        return false;
      }
      if(Balance_as_on == ''){
        var errBalance_as_on = "Please Select Date";
        $("#errBalance_as_on").text(errBalance_as_on).fadeIn("slow");
        $("#Balance_as_on").focus();
        setTimeout(function(){
          $("#errBalance_as_on").fadeOut("slow");
        },2000);
        return false;
      }
      else
      {
        $('#customer_btn').attr('type','submit');
      }
    });
    $("#GST_No").on('change paste', function() {
        var GSTIN_AJAX_URL = $('#GSTIN_AJAX').val();
        $.ajax({
            url: GSTIN_AJAX_URL,
            type: "post",
            dataType: "html",
            data:  "GSTIN="+$(this).val(),
            success: function (response) {
              var data = JSON.parse(response);
              $("#FirstName").val(data.tradeName.split(' ').slice(0, -1).join(' '));
              $("#LastName").val(data.tradeName.split(' ').slice(-1).join(' '));
              $("#Address").val(data.addrBnm + ' ' + data.addrBno + ' ' + data.addrFlno + ' ' + data.addrSt + ' ' + data.addrLoc);
              $("#Zip").val(data.addrPncd);
              $("#Email").val(data.email);
              $("#Mobile").val(data.mobileNo);
              if(data.BlockedMsg != '')
                alert(data.BlockedMsg);
            },
            error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
            }
        });
    });
    //For Update Customer Form
    if(customer_id){
      var dob = $('#dateofbirth').val();
      var Balance_dt = $('#Balance_as_on').val();
      var country = $('#Country_update').val();
      var state = $('#State_update').val();
      var city = $('#City_update').val();
      $('.DOB').val(dob);
      $('.Balance_dt').val(Balance_dt);
      var $countryOption = $("<option></option>").val(country).text(country);
      $(".country").append($countryOption).trigger('change');
      var $stateOption = $("<option></option>").val(state).text(state);
      $(".State").append($stateOption).trigger('change');
      var $cityOption = $("<option></option>").val(city).text(city);
      $(".Cities").append($cityOption).trigger('change');
      //alert(city);
    }
    //For server side select2 for countries
    $('.country').select2({
        placeholder: 'Select Country',
        selectOnClose: true,
        width: "100%",
        ajax: {
          url: url+'customers-countries',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data,
            };
          },
          cache: true
        }
      });
    //Select2 for states used in customer
    $('.State').select2({
        placeholder: "Please select a country first",
        width: "100%"
    });
    //Select2 for Cities used in customer
    $('.Cities').select2({
        placeholder: "Please select a country first",
        width: "100%"
    });
    //Date range as a button for Customer Reports Section
    $('#daterange-btn').daterangepicker(
        {
          ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          $("#start").val(start.format('MMMM D, YYYY'));
          $("#end").val(end.format('MMMM D, YYYY'));
          $('.customer_reports_datatable').dataTable().api().ajax.reload();
        }
      );
  //Date range as a button for GST Report Section
  $('#daterange-btn-gst').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn-gst span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $("#start").val(start.format('MMMM D, YYYY'));
        $("#end").val(end.format('MMMM D, YYYY'));
        $('.gst_reports_datatable').dataTable().api().ajax.reload();
      }
    );
});
//Focusing the select2 
$('.State').next('.select2').find('.State').one('focus', select2Focus).on('blur', function () {
    $(this).one('focus', select2Focus)
});
//Focusing the select2
function select2Focus() {
    $(this).closest('.select2').prev('select').select2('open');
}
//Focusing the select2
$('.Cities').next('.select2').find('.Cities').one('focus', select2Focus).on('blur', function () {
    $(this).one('focus', select2Focus)
});
//Selecting states from the server
function showStates(country){
  $('.State').select2({
        placeholder: 'Select State',
        selectOnClose: true,
        width: "100%",
        ajax: {
          url: url+'customers-states',
          dataType: 'json',
          data: function (params) {
            return {
              searchTerm: params.term, // search term
              country: country
            };
           },
          delay: 250,
          processResults: function (data) {
            return {
              results: data,
            };
          },
          cache: true
        }
      });
  $('.Cities').select2({
      placeholder: "Please select a state first",
      width: "100%"
  });
}
//Selecting cities from the server
function showCities(state){
  $('.Cities').select2({
        placeholder: 'Select City',
        selectOnClose: true,
        width: "100%",
        ajax: {
          url: url+'customers-cities',
          dataType: 'json',
          data: function (params) {
            return {
              searchTerm: params.term, // search term
              state: state
            };
           },
          delay: 250,
          processResults: function (data) {
            return {
              results: data,
            };
          },
          cache: true
        }
      });
}
// Restricts input for each element in the set of matched elements to the given inputFilter.
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      }
    });
  };
}(jQuery));
// Restrict input to digits by using a regular expression filter.
    $("#Mobile").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });
    $("#Zip").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });
    $("#cheque_no").inputFilter(function(value) {
      return /^\d*$/.test(value);
    });
//Saveing bank details to the server using AJAX
    function save_data(id, data){
      $.ajax({
          url: url,
          type: "post",
          dataType: "html",
          data:  "id="+id+"&"+data,
          success: function (response) {
              
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
          }
      });
    }
    function get_data(url){
      $.ajax({
        url: url,
        type: "get",
        dataType: "html",
        success: function (response) {
            $('#voucher_no').val(response);
            $('#voucher_no').prop('readonly', true);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        }
    });
    }
    //Saveing Tax to the server using AJAX
function save(id, GST){
  $.ajax({
      url: url,
      type: "post",
      dataType: "html",
      data:  "id="+id+"&value="+GST,
      success: function (response) {
          //alert(response);
      },
      error: function(jqXHR, textStatus, errorThrown) {
         console.log(textStatus, errorThrown);
      }
  });
}
//Function for calculate by changing quantity
function changeQty(next){
    var qty = $('#Qty'+next).val();
    var Price = $('#Price'+next).val();
    var Amount = qty * Price;
    console.log("Amount "+Amount);
    console.log("qty "+qty);
    var CESS = $("#CESS_value").val();
    var cess_amt = CESS * qty;
    console.log(cess_amt);
    $("#cess").val(cess_amt.toFixed(2));
    $('#Amount'+next).val(Amount);
    sum();
}
//Function to get balance amount
function balance_amt(){
    var bill_amt = $("#bill_amt").val();
    var payed_amount = $("#payed_amount").val();
    var balance_amt = parseInt(bill_amt) - parseInt(payed_amount);
    $("#balance_amount").val(balance_amt);
}
//Function for sum of value for invoice form
function sum(){
    var total = 0;
    $('.Amount').each(function (index, element) {
        total = total + parseFloat($(element).val());
    });
    $('#Gross_amount').val(total.toFixed(2));
    var freight = parseFloat($('#additional_amt').val());
    var tcs_value = 0;
    var cess = $('#cess').val();
    if(isNaN(parseInt(freight))) {
        freight = 0;
    } else {
        freight = parseInt(freight);
    }
      //Calculation of IGST when user clicked on checked box
      $("#isIGST").click(function(){
        if($(this).is(':checked')){
          var igst_per = $('#IGST_percentage').val();
          var igst_amt = (total + freight) * (igst_per/100);
          $('#IGST').val(igst_amt.toFixed(2));
          var cgst_amt = 0;
          $('#CGST').val(cgst_amt.toFixed(2));
          var sgst_amt = 0;
          $('#SGST').val(sgst_amt.toFixed(2));
          var TCS_percentage = $('#TCS_percentage').val();
          tcs_value = (total + freight + cgst_amt + sgst_amt + igst_amt);
          console.log(tcs_value);
        } else {
          var igst_amt = 0;
          $('#IGST').val(igst_amt.toFixed(2));
          var cgst_per = $('#CGST_percentage').val();
          var cgst_amt = (total + freight) * (cgst_per/100);
          $('#CGST').val(cgst_amt.toFixed(2));
          var sgst_per = $('#SGST_percentage').val();
          var sgst_amt = (total + freight) * (sgst_per/100);
          $('#SGST').val(sgst_amt.toFixed(2));
          var TCS_percentage = $('#TCS_percentage').val();
          tcs_value = (total + freight + cgst_amt + sgst_amt + igst_amt);
          console.log(tcs_value);
        }
      });
      //Calculation of TCS when user clicked on checked box
      $("#isTCS").click(function(){
        if($(this).is(':checked')){
          console.log("Check box checked "+tcs_value +" "+cess+" = "+(parseFloat(tcs_value) + parseFloat(cess)));
          var tcs_amt = (parseFloat(tcs_value) + parseFloat(cess)) * (TCS_percentage/100);
          console.log("Add AMT "+ tcs_amt);
          $('#tcs').val(tcs_amt.toFixed(2));
          var round_amt = parseFloat($('#Roundoff').val()) + parseFloat(tcs_amt.toFixed(2));
           $('#Roundoff').val(round_amt.toFixed(2));
            $('#Netammount').val(Math.round(round_amt.toFixed(2)));
        } else {
          $('#tcs').val(0);
          var round_amt = $('#Roundoff').val() + parseFloat(0);
           $('#Roundoff').val(round_amt.toFixed(2));
            $('#Netammount').val(Math.round(round_amt.toFixed(2)));
        }
      });
    //If checked box default state 
    if(!$("#isIGST").is(':checked')){
      var igst_amt = 0;
      $('#IGST').val(igst_amt.toFixed(2));
      //Calculate If igst is 0
      var cgst_per = $('#CGST_percentage').val();
      var cgst_amt = (total + freight) * (cgst_per/100);
      $('#CGST').val(cgst_amt.toFixed(2));
      var sgst_per = $('#SGST_percentage').val();
      var sgst_amt = (total + freight) * (sgst_per/100);
      $('#SGST').val(sgst_amt.toFixed(2));
      var TCS_percentage = $('#TCS_percentage').val();
      tcs_value = (total + freight + cgst_amt + sgst_amt + igst_amt);
       console.log(tcs_value);
    } else {
      var igst_per = $('#IGST_percentage').val();
      var igst_amt = (total + freight) * (igst_per/100);
      $('#IGST').val(igst_amt.toFixed(2));
      var cgst_amt = 0;
      $('#CGST').val(cgst_amt.toFixed(2));
      var sgst_amt = 0;
      $('#SGST').val(sgst_amt.toFixed(2));
      var TCS_percentage = $('#TCS_percentage').val();
      tcs_value = (total + freight + cgst_amt + sgst_amt + igst_amt);
      console.log(tcs_value);
    }
    if(!$("#isTCS").is(':checked')){
      console.log("Def "+0);
      $('#tcs').val(0);
    } else {
      console.log("Check box checked "+tcs_value+" "+cess);
      var tcs_amt = (parseFloat(tcs_value) + parseFloat(cess)) * (TCS_percentage/100);
      console.log("Add AMT "+ tcs_amt);
      $('#tcs').val(tcs_amt.toFixed(2));
    }
    var tcs = $('#tcs').val();
    //alert(tcs);
   var round_amt = parseFloat(total.toFixed(2)) + parseFloat(cgst_amt.toFixed(2)) + parseFloat(sgst_amt.toFixed(2)) + parseFloat(igst_amt.toFixed(2)) + parseFloat(cess) + parseFloat(tcs);
   $('#Roundoff').val(round_amt.toFixed(2));
   $('#Netammount').val(Math.round(round_amt.toFixed(2)));
}
$(document).ready(function(){
  //Decimal point at input
  $(".allow_decimal").on("input", function(evt) {
    var self = $(this);
    self.val(self.val().replace(/[^0-9\.]/g, ''));
    if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
    {
      evt.preventDefault();
    }
  });
  //If user adds additional amount adds in final amount
  $("#additional_amt").change(function(){
    var Additional_amount = $('#additional_amt').val();
    var tcs_value = 0;
    //alert(Additional_amount);return false;
    if(isNaN(parseInt(Additional_amount))) {
        Additional_amount = 0;
    } else {
        Additional_amount = parseInt(Additional_amount);
    }
    var gross = $('#Gross_amount').val();
    var total = parseInt(gross);
    var cess = $('#cess').val();
    $('#Gross_amount').val(total.toFixed(2));
    //If checked box default state 
    if(!$("#isIGST").is(':checked')){
      var igst_amt = 0;
      $('#IGST').val(igst_amt.toFixed(2));
      //Calculate If igst is 0
      var cgst_per = $('#CGST_percentage').val();
      var cgst_amt = (total + Additional_amount) * (cgst_per/100);
      $('#CGST').val(cgst_amt.toFixed(2));
      var sgst_per = $('#SGST_percentage').val();
      var sgst_amt = (total + Additional_amount) * (sgst_per/100);
      $('#SGST').val(sgst_amt.toFixed(2));
      var TCS_percentage = $('#TCS_percentage').val();
      tcs_value = (total + Additional_amount + cgst_amt + sgst_amt + igst_amt);
    } else {
      var igst_per = $('#IGST_percentage').val();
      var igst_amt = (total + Additional_amount) * (igst_per/100);
      $('#IGST').val(igst_amt.toFixed(2));
      var cgst_amt = 0;
      $('#CGST').val(cgst_amt.toFixed(2));
      var sgst_amt = 0;
      $('#SGST').val(sgst_amt.toFixed(2));
      var TCS_percentage = $('#TCS_percentage').val();
      tcs_value = (total + Additional_amount + cgst_amt + sgst_amt + igst_amt);
    }
    if($("#isTCS").is(':checked')){
      console.log("Add Amt "+(parseFloat(tcs_value) + parseFloat(cess)) * (TCS_percentage/100));
      var tcs_amt = (parseFloat(tcs_value) + parseFloat(cess)) * (TCS_percentage/100);
      console.log("Add AMT "+ tcs_amt);
      $('#tcs').val(tcs_amt.toFixed(2));
    } else {
      console.log("Deft Add Amt "+tcs_value);
      $('#tcs').val(0);
    }
    var tcs = $('#tcs').val();
   var round_amt = parseFloat(total.toFixed(2)) + parseFloat(cgst_amt.toFixed(2)) + parseFloat(sgst_amt.toFixed(2)) + parseFloat(igst_amt.toFixed(2)) + parseInt(Additional_amount) + parseFloat(cess) + parseFloat(tcs);
   $('#Roundoff').val(round_amt.toFixed(2));
   $('#Netammount').val(Math.round(round_amt.toFixed(2)));
  });
  
//Invoice Form Validation
  $('#Bill_form').on('submit', function(event) {
      var Customer = $("#Customer").val();
      var waybill_no = $("#waybill_no").val();
	  var waybill_file = $("#waybill_file").val();
      var inv_date = $("#inv_date").val();
      var Lorry_no = $("#Lorry_no").val();
      var place = $("#place").val();
      var Lorry_pattern = "([A-Z]{2,3})-(\d{2,4})|([A-Z]{2,3})-\d{2}-[A-Z]{1,2}-\d{1,4}";
      // prevent default submit action         
      //event.preventDefault();
      if(Customer=='')
      {
        var eCustomer = "Please Select Customer";
        $("#errCustomer").text(eCustomer).fadeIn("slow");
        $("#Customer").focus();
        setTimeout(function(){
          $("#errCustomer").fadeOut("slow");
        },2000);
        return false;
      }
      if(waybill_no=='')
      {
        var ewaybill_no = "Please Enter Way Bill No";
        $("#errwaybill_no").text(ewaybill_no).fadeIn("slow");
        $("#waybill_no").focus();
        setTimeout(function(){
          $("#errwaybill_no").fadeOut("slow");
        },2000);
        return false;
      }
	  /*if(waybill_file=='')
      {
        var errwaybill_file = "Please Upload Way Bill PDF";
        $("#errwaybill_file").text(errwaybill_file).fadeIn("slow");
        $("#waybill_file").focus();
        setTimeout(function(){
          $("#errwaybill_file").fadeOut("slow");
        },2000);
        return false;
      }*/
      if(inv_date=='')
      {
        var einv_date = "Please Select Invoice Date";
        $("#errinv_date").text(einv_date).fadeIn("slow");
        $("#inv_date").focus();
        setTimeout(function(){
          $("#errinv_date").fadeOut("slow");
        },2000);
        return false;
      }
      if(Lorry_no=='')
      {
        var eLorry_no = "Please Enter Lorry No";
        $("#errLorry_no").text(eLorry_no).fadeIn("slow");
        $("#Lorry_no").focus();
        setTimeout(function(){
          $("#errLorry_no").fadeOut("slow");
        },2000);
        return false;
      }
      /*else if(!Lorry_pattern.test(Lorry_no))
      {
        var eLorry_no = "Please Enter Valid Email";
        $("#errLorry_no").text(eLorry_no).fadeIn("slow");
        $("#Lorry_no").focus();
        setTimeout(function(){
          $("#eLorry_no").fadeOut("slow");
        },2000);
        return false;
      }*/
      if(place=='')
      {
        var eplace = "Please Enter Place";
        $("#errplace").text(eplace).fadeIn("slow");
        $("#place").focus();
        setTimeout(function(){
          $("#errplace").fadeOut("slow");
        },2000);
        return false;
      }
      var item=$(".product");
      var next =item.attr('data-no');
      //alert("#product"+next);return false;
      var product = $("#product"+next).val();
      if(product==0)
      {
        alert("Please Select Product Name");
        return false;
      }
      $(':submit').attr('disabled', 'disabled');
      //alert("Valid Form");return false;
      //alert(JSON.stringify($(this).serialize()));return false;
      // adding rules for inputs with class 'comment'
      /*$('input#Product').each(function() {
          alert("Please Select Product Name");
          return false;
      });  */   
      // test if form is valid 
      /*if($('#Bill_form').validate().form()) {
          console.log("validates");
      } else {
          console.log("does not validate");
      }*/
  });
  //Waybill file upload
  $("#way_bill_pdf").change(function() {
    var id = $(this).attr('data-id');
    var img_url = $(this).attr('data-url');
    var ext = $(this).val().split('.').toString();
    console.log(ext);
    if($.contains(ext.toLowerCase(),"pdf")){
      $("#err_waybill_pdf").text("Invalid File Type");
      $("#err_waybill_pdf").show();
      setTimeout(function(){
        $("#err_waybill_pdf").hide();
      }, 3000);
    } else {
      var fd = new FormData();
      var files = $(this)[0].files[0];
      fd.append('file',files);
      fd.append('id',id);
      $.ajax({
        type:"POST",
        //dataType: 'json',
        data: fd,
        contentType: false,
        processData: false,
        url: img_url,
        success:function(response) {
          var res = JSON.parse(response);
          if(res.status == 1){
            location.reload();
          }
        }
      });
    }
  });
  //Purchase Bill Form Validation
  $('#Purchase_form').on('submit', function(event) {
      var Supplier = $("#Supplier").val();
      var Inv_no = $("#inv_no").val().trim();
      var waybill_no = $("#waybill_no").val();
	  var waybill_file = $("#waybill_file").val();
      var inv_date = $("#inv_date").val();
      var Lorry_no = $("#Lorry_no").val();
      var place = $("#place").val();
      var Lorry_pattern = "([A-Z]{2,3})-(\d{2,4})|([A-Z]{2,3})-\d{2}-[A-Z]{1,2}-\d{1,4}";
      // prevent default submit action  
		//alert(waybill_file);return false;
      //event.preventDefault();
      if(Supplier=='')
      {
        var eCustomer = "Please Select Supplier";
        $("#errSupplier").text(eCustomer).fadeIn("slow");
        $("#Supplier").focus();
        setTimeout(function(){
          $("#errSupplier").fadeOut("slow");
        },2000);
        return false;
      }
      if(waybill_no=='')
      {
        var ewaybill_no = "Please Enter Way Bill No";
        $("#errwaybill_no").text(ewaybill_no).fadeIn("slow");
        $("#waybill_no").focus();
        setTimeout(function(){
          $("#errwaybill_no").fadeOut("slow");
        },2000);
        return false;
      }
	 /* if(waybill_file=='')
      {
        var errwaybill_file = "Please Upload Way Bill PDF";
        $("#errwaybill_file").text(errwaybill_file).fadeIn("slow");
        $("#waybill_file").focus();
        setTimeout(function(){
          $("#errwaybill_file").fadeOut("slow");
        },2000);
        return false;
      }*/
      if(Inv_no=='')
      {
        var einv_date = "Please Enter Invoice No";
        $("#errinv_no").text(einv_date).fadeIn("slow");
        $("#inv_no").focus();
        setTimeout(function(){
          $("#errinv_no").fadeOut("slow");
        },2000);
        return false;
      }
      if(inv_date=='')
      {
        var einv_date = "Please Select Invoice Date";
        $("#errinv_date").text(einv_date).fadeIn("slow");
        $("#inv_date").focus();
        setTimeout(function(){
          $("#errinv_date").fadeOut("slow");
        },2000);
        return false;
      }
      if(Lorry_no=='')
      {
        var eLorry_no = "Please Enter Lorry No";
        $("#errLorry_no").text(eLorry_no).fadeIn("slow");
        $("#Lorry_no").focus();
        setTimeout(function(){
          $("#errLorry_no").fadeOut("slow");
        },2000);
        return false;
      }
      /*else if(!Lorry_pattern.test(Lorry_no))
      {
        var eLorry_no = "Please Enter Valid Email";
        $("#errLorry_no").text(eLorry_no).fadeIn("slow");
        $("#Lorry_no").focus();
        setTimeout(function(){
          $("#eLorry_no").fadeOut("slow");
        },2000);
        return false;
      }*/
      if(place=='')
      {
        var eplace = "Please Enter Place";
        $("#errplace").text(eplace).fadeIn("slow");
        $("#place").focus();
        setTimeout(function(){
          $("#errplace").fadeOut("slow");
        },2000);
        return false;
      }
      var item=$(".product");
      var next =item.attr('data-no');
      //alert("#product"+next);return false;
      var product = $("#product"+next).val();
      if(product==0)
      {
        alert("Please Select Product Name");
        return false;
      }
      //alert(JSON.stringify($(this).serialize()));return false;
      // adding rules for inputs with class 'comment'
      /*$('input#Product').each(function() {
          alert("Please Select Product Name");
          return false;
      });  */   
      // test if form is valid 
      /*if($('#Bill_form').validate().form()) {
          console.log("validates");
      } else {
          console.log("does not validate");
      }*/
  });
  //For Monthly Report server side datatable
  var table = $('.reports_datatable').DataTable({
      // Processing indicator
      "processing": true,
      // DataTables server-side processing mode
      "serverSide": true,
      // Load data from an Ajax source
      "ajax": {
          "url": url,
          "type": "POST",
          "data": function(d) {               
              d.SearchData = $("#month").val();//alert(d.SearchData);
              d.fy = $("#year").val();
          }
      }
  });
  //For customer report server side datatable
  var table_customer = $('.customer_reports_datatable').DataTable({
      // Processing indicator
      "processing": true,
      // DataTables server-side processing mode
      "serverSide": true,
      // Load data from an Ajax source
      "bLengthChange": true,
      "pageLength" : 10,
      "ajax": {
          "url": url,
          "type": "POST",
          "data": function(d) {               
              //d.SearchData = "customer='"+$("#month").val()+"'&start='"+$("#start").val()+"'&end='"+$("#end").val()+"'";//alert(d.SearchData);
              d.SearchData = $("#customer").val();
              d.start = $("#start").val();
              d.end = $("#end").val();
          }
      }
  });
  //For GST Report Server side data table
  var table_gst = $('.gst_reports_datatable').DataTable({
      // Processing indicator
      "processing": true,
      // DataTables server-side processing mode
      "serverSide": true,
      // Load data from an Ajax source
      "ajax": {
          "url": url,
          "type": "POST",
          "data": function(d) {               
              //d.SearchData = "customer='"+$("#month").val()+"'&start='"+$("#start").val()+"'&end='"+$("#end").val()+"'";//alert(d.SearchData);
              d.start = $("#start").val();
              d.end = $("#end").val();

          }
      }
  });
  //For Customer name changes serverside datatable gets changes
  $('#customer').on('change', function() {
    var month = $(this).val();
    //alert(month);
    $('.customer_reports_datatable').dataTable().api().ajax.reload();
  });
  //For months changes serverside datatable gets changes
  $('#month').on('change', function() {
    var month = $(this).val();
    //alert(month);
    $('.reports_datatable').dataTable().api().ajax.reload();
  });
  if(typeof show_popup !== 'undefined' && show_popup == 1){
      $('#email_setup_popup').modal({
        backdrop: 'static',
        show: true
      });
  } else {
      $('#email_setup_popup').modal('hide');
  }
  $("#update_email_setup").off('click');
  $("#update_email_setup").on('click', function(){
      var from_email = $('#from_Email').val();
      if($.trim(from_email) == ''){
          $("#from_Email").parent().addClass('has-error');
          $("#from_Email").after('<span class="help-block">Email is required.</span>');
      }
      else if(!isValidEmailAddress($.trim(from_email))){
          $("#from_Email").parent().addClass('has-error');
          $("#from_Email").next("span").remove();
          $("#from_Email").after('<span class="help-block">Email is invalid.</span>');
      } else {
          $("#from_Email").parent().addClass('has-success').removeClass('has-error');
          $("#from_Email").next("span").remove();
          $.ajax({
            type:"post",
            url: $(this).attr('data-url'),
            data:{email:$.trim(from_email)},
            cache:false,
            success:function(response)
            { 
              if(response == 1){
                  $('#email_setup_popup').modal('hide');
              } else {
                  $("#from_Email").after('<span class="text-danger" id="errMsg">Unable to update, Please try after some time.</span>');
                  setTimeout(function(){$("#from_Email").next("span").remove();}, 4000);
              }
            }
        });
      }
  });
});
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}
function ChangePassword()
{
    var cpassword = $('#cpassword').val();
    var npassword = $('#npassword').val();
    var cnpassword = $('#cnpassword').val();

    if(cpassword=="")
    {
      $("#current_password_err").fadeIn().html("Please enter current password");
      setTimeout(function(){$("#current_password_err").html("&nbsp;");},5000)
      $("#cpassword").focus();
      return false;       
    }

    if(npassword=="")
    {
      $("#new_password_err").fadeIn().html("Please enter new password");
      setTimeout(function(){$("#new_password_err").html("&nbsp;");},5000)
      $("#cpassword").focus();
      return false;
    }
    
    if(cnpassword.trim()=="")
    {
       $("#confirm_new_password_err").fadeIn().html("Please enter confirm new password");
      setTimeout(function(){$("#confirm_new_password_err").html("&nbsp;");},5000)
      $("#cnpassword").focus();
      return false;
    }

    if((npassword!='') && (npassword!=cnpassword))
    {
       $("#confirm_new_password_err").fadeIn().html("New password and confirm password should be same");
      setTimeout(function(){$("#confirm_new_password_err").html("&nbsp;");},5000)
      $("#cpassword").focus();
      return false;
   
    }

     $.ajax({
          type:"post",
          url: url,
          data:{cpassword:cpassword,npassword:npassword,cnpassword:cnpassword},
          cache:false,
          success:function(response)
          { //alert(response); return false;
            if(response==1)
            {
              //alert("if"); return false;
              $("#current_password_err").html("Please enter correct password");
                  setTimeout(function(){$("#current_password_err").html("&nbsp;");},5000);
                  $("#cpassword").focus();
                  return false;
            }
            else
            { //alert("else"); return false;
              $("#changePassbtn").click();
            }
          }
      });

  }
  //delete','onclick'=>"myConfirm('Are you sure do you want to cancel this invoice - ".$usersData->invoice_no."?','');"
  function delete_opt(inv_no, id){
    var status = false;
    $.confirm({
      title: 'Are you sure do you want to cancel this invoice - '+inv_no+'?',
      content: '',
      buttons: {
          confirm: {
              text: 'Confirm',
              btnClass: 'btn-primary',
              keys: ['enter'],
              action: function(){
                window.location.replace($("#delete"+id).attr('href'));
              }
          },
          cancel: {
            text: 'Cancel',
            btnClass: 'btn-danger',
            keys: ['esc'],
            action: function(){
                status = false;
            }
          }
      }
    });
    return status;
  }
  /*VALIDATION TO INVOICE PRODUCT STARTS*/
  $("#btn_bill").click(function(){
      var flag=0;
      $(".product").each(function(){
          var product=$(this).val();
         if(product==0)
         {
             flag=1;
         }
          
      });
      
      if(flag==1)
      {
        alert("Please Select Product Name");
        return false;
      }
      
  });