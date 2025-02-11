<?php 

 require('../config/autoload.php'); 
include("header.php");

$file=new FileUpload();
$elements=array(
        "sname"=>"", "venue"=>"", "tprice"=>"", "sdate"=>"", "blimit"=>"");


$form=new FormAssist($elements,$_POST);



$dao=new DataAccess();

$labels=array('sname'=>"Show Name : ", 'venue'=>"Venue : ", 'tprice'=>"Ticket Price : ", 'sdate'=>"Show Date : ", 'blimit'=>"Bookings Limit : ");

$rules=array(
    "sname"=>array("required"=>true,"minlength"=>1,"maxlength"=>70),
    "venue"=>array("required"=>true,"minlength"=>1,"maxlength"=>70),
    "tprice"=>array("integeronly"=>true,"required"=>true,"minlength"=>1,"maxlength"=>50),
    "sdate"=>array("required"=>true),
    "blimit"=>array("integeronly"=>true,"required"=>true,"minlength"=>1),
    
);
    
    
$validator = new FormValidator($rules,$labels);

if(isset($_POST["btn_insert"]))
{

if($validator->validate($_POST))
{


$data=array(

    'sname'=>$_POST['sname'],
    'venue'=>$_POST['venue'],
    'price'=>$_POST['tprice'],
    'sdate'=>$_POST['sdate'],
    'blimit'=>$_POST['blimit']
    );
	



  
    if($dao->insert($data,"shows"))
    {
        echo "<script> alert('New record created successfully');</script> ";
header('location:manage_shows.php');


    }
}
else
{$msg="Insertion failed";} ?>

<span style="color:red;"><?php echo $msg; ?></span>

<?php

}

?>
<html>
<head>
</head>
<body>
<h1>Live Show</h1><br>
 <form action="" method="POST" enctype="multipart/form-data">
 
 
<div class="row">
<div class="col-md-6">
Show Name :

<?= $form->textBox('sname',array('class'=>'form-control')); ?>
<?= $validator->error('sname'); ?>

</div>
<div class="col-md-6">
Venue :

<?= $form->textBox('venue',array('class'=>'form-control')); ?>
<?= $validator->error('venue'); ?>

</div>

<div class="col-md-6">
Ticket Price :

<?= $form->textBox('tprice',array('class'=>'form-control')); ?>
<?= $validator->error('tprice'); ?>

</div>
<div class="col-md-6">
Show Date :
<?php
$currentDate = date('Y-m-d');
$maxDate = date('Y-m-d', strtotime('+1 year'));
?>
<?= $form->inputBox('sdate', array('class' => 'form-control','min' => $currentDate, 'max' => $maxDate), "date"); ?>
<?= $validator->error('sdate'); ?>

</div>

</div><br>
<div class="col-md-6">
Booking limit (Based on venue capacity) :

<?= $form->textBox('blimit',array('class'=>'form-control'),"date"); ?>
<?= $validator->error('blimit'); ?> <br>
<button type="submit" name="btn_insert"  >Submit</button><br>
</div>


<div>
    <br>
                <table border="1" class="table" style="margin-top:100px;">
                    <tr >
                        <th>ID</th>
                        <th>Show Name</th>
                        <th>Venue</th>
                        <th>Ticket Price</th>
                        <th>Event Date</th>
                        <th>Booking Limit</th>
                        <th>Actions</th>
                        <th>    </th>
                    </tr>
                    <?php
                    $actions = array(
                        'EDIT' => array('label' => 'EDIT', 'link' => 'update_shows.php', 'params' => array('id' => 'sid'), 'attributes' => array('class' => 'btn btn-success')),
                        'DEL' => array('label' => 'DEL', 'link' => 'del_shows.php', 'params' => array('id' => 'sid'), 'attributes' => array('class' => 'btn btn-danger'))
                    );

                    $config = array(
                        'srno' => true,
                        'hiddenfields' => array('sid'),
                        'actions_td' => true,
                        'images' => array(
                            'field' => 'art',
                            'path' => '../uploads/',
                            'attributes' => array('style' => 'width:100px;')
                        )
                    );

                    $fields = array('sid', 'sname', 'venue', 'price', 'sdate', 'blimit');
                    $records = $dao->selectAsTable($fields, 'shows', 1, array(), $actions, $config);

                    echo $records;
                    ?>
                </table>
            </div>

</div>

</form>


</body>

</html>

<?php 
$dao = new DataAccess();
?>




            
        
    
