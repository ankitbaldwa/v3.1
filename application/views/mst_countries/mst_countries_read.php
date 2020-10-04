<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Mst_countries Read</h2>
        <table class="table">
	    <tr><td>Country Name</td><td><?php echo $country_name; ?></td></tr>
	    <tr><td>Code</td><td><?php echo $code; ?></td></tr>
	    <tr><td>Status</td><td><?php echo $status; ?></td></tr>
	    <tr><td>Created</td><td><?php echo $created; ?></td></tr>
	    <tr><td>Modified</td><td><?php echo $modified; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('mst_countries') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>