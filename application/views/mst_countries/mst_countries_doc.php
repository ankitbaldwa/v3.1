<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Mst_countries List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Country Name</th>
		<th>Code</th>
		<th>Status</th>
		<th>Created</th>
		<th>Modified</th>
		
            </tr><?php
            foreach ($mst_countries_data as $mst_countries)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $mst_countries->country_name ?></td>
		      <td><?php echo $mst_countries->code ?></td>
		      <td><?php echo $mst_countries->status ?></td>
		      <td><?php echo $mst_countries->created ?></td>
		      <td><?php echo $mst_countries->modified ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>