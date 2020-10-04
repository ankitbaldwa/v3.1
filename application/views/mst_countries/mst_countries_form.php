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
                                        <a href="<?= site_url('countries') ?>" class="btn btn-brand btn-elevate btn-icon-sm">
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
                               

                                    <!--begin: form -->
            <form action="<?php echo $action; ?>" method="post">

     <div class="form-group">
            <label for="varchar">Country Name <?php echo form_error('country_name') ?></label>
            <input type="text" class="form-control form-control-lg" name="country_name" id="country_name" placeholder="Country Name" value="<?php echo $country_name; ?>" />
        </div>
        <div class="form-group">
            <label for="varchar">Code <?php echo form_error('code') ?></label>
            <input type="text" class="form-control form-control-lg" name="code" id="code" placeholder="Code" value="<?php echo $code; ?>" />
        </div>
       
        <input type="hidden" name="id" value="<?php echo $id; ?>" /> 
        <button type="submit" class="btn btn-success"><?php echo $button ?></button> 
        <a href="<?php echo site_url('countries') ?>" class="btn btn-danger">Cancel</a>
    </form>

                                    <!--end: form -->
                              
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