<?php $this->load->view('common/aside'); ?>
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
                    <?php $this->load->view('common/header'); ?>
                    <!-- end:: Header -->
                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                        <!-- begin:: Subheader -->
                        <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                            <div class="kt-container  kt-container--fluid ">
                                <div class="kt-subheader__main">
                                    <h3 class="kt-subheader__title">
                                        <?= $heading ?> </h3>
                                    <span class="kt-subheader__separator kt-hidden"></span>
                                    <div class="kt-subheader__breadcrumbs">
                                        <!-- <span class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Active link</span> -->
                                    </div>
                                </div>
                                <div class="kt-subheader__toolbar">
                                    <div class="kt-subheader__wrapper">
                                        <div class="dropdown dropdown-inline">
                                            
                                            
                                        </div>
                                        &nbsp;
                                        <a href="<?= site_url('states') ?>" class="btn btn-brand btn-elevate btn-icon-sm">
                                            <i class="la la-arrow-left"></i>
                                           Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- end:: Subheader -->

                        <!-- begin:: Content -->
                        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
                            <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                            <div class="kt-portlet kt-portlet--mobile">
                                <div class="kt-portlet__body">
                               
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Country Name<?php echo form_error('mst_country_id') ?></label>
           <select  name="mst_country_id" id="mst_country_id"  class="form-control">
             <option value="">Select Country</option>
            <?php foreach ($Countries as $row_data) { ?>
                <option value="<?php echo $row_data->id; ?>" <?php if($mst_country_id==$row_data->id) { echo "selected"; } ?> ><?php echo $row_data->country_name; ?> 
                </option>
            <?php } ?>

          </select>
        </div>
	    <div class="form-group">
            <label for="varchar">State Name <?php echo form_error('state_name') ?></label>
            <input type="text" class="form-control" name="state_name" id="state_name" placeholder="State Name" value="<?php echo $state_name; ?>" />
        </div>
	   
	    <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
	    <button type="submit" class="btn btn-success"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('states') ?>" class="btn btn-default">Cancel</a>
	</form>
    </div>
                            </div>
                        </div>

                        <!-- end:: Content -->
                    </div>

                    <?php $this->load->view('common/footer'); ?>
                </div>
            </div>
        </div>

        <!-- end:: Page -->

        <!-- begin::Scrolltop -->
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>

        

        <?php $this->load->view('common/script'); ?>