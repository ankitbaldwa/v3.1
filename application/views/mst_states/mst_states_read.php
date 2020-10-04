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
        <h2 style="margin-top:0px">Mst_states Read</h2>
        <table class="table">
	    <tr><td>Mst Country Id</td><td><?php echo $mst_country_id; ?></td></tr>
	    <tr><td>State Name</td><td><?php echo $state_name; ?></td></tr>
	    <tr><td>Status</td><td><?php echo $status; ?></td></tr>
	    <tr><td>Created</td><td><?php echo $created; ?></td></tr>
	    <tr><td>Modified</td><td><?php echo $modified; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('mst_states') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>