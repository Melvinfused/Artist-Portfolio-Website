<?php 

 require('../config/autoload.php'); 
include("header.php");
$dao=new DataAccess();
$info=$dao->getData('*','shows','sid='.$_GET['id']);

$file=new FileUpload();
$elements=array(
        "tprice"=>"", "sdate"=>"", "blimit"=>"");


$form=new FormAssist($elements,$_POST);


$labels=array('tprice'=>"Ticket Price : ", 'sdate'=>"Show Date : ", 'blimit'=>"Bookings Limit : ");

$rules=array(
"tprice"=>array("integeronly"=>true,"required"=>true,"minlength"=>1,"maxlength"=>50),
    "sdate"=>array("required"=>true),
    "blimit"=>array("integeronly"=>true,"required"=>true,"minlength"=>1),

);
    
    
   
$validator = new FormValidator($rules,$labels);

if(isset($_POST["btn_update"]))
{

if($validator->validate($_POST))
{
    

    $data=array(

        'price'=>$_POST['tprice'],
        'sdate'=>$_POST['sdate'],
        'blimit'=>$_POST['blimit']
       
    );
    $condition='sid='.$_GET['id'];

        
    
    if($dao->update($data,'shows',$condition))
        {
            $msg="Record updated successfully.";
    
        }
        else
            {$msg="Update failed.";} ?>
    
    <span style="color:red;"><?php echo $msg; ?></span>

<?php
    


}
}
?>

<html>
<head>
    <title>Update Live Show Information</title>
   
</head>
<body>

<form action="" method="POST" enctype="multipart/form-data">
    <h1>Update Live Show Information</h1>
    <br>
    
    <div class="col-md-6">
        <label for="tprice">Ticket Price : </label>
        <?= $form->textBox('tprice', array('class' => 'form-control')); ?>
        <?= $validator->error('tprice'); ?>
    </div>

    <div class="col-md-6">
    <label for="sdate">Show Date :</label>
    <?php
    $currentDate = date('Y-m-d');
    $maxDate = date('Y-m-d', strtotime('+1 year'));
    ?>
    <?= $form->inputBox('sdate', array('class' => 'form-control', 'min' => $currentDate, 'max' => $maxDate), "date"); ?>
    <?= $validator->error('sdate'); ?>
    </div>


    <div class="col-md-6">
        <label for="blimit"> Bookings Limit : </label>
        <?= $form->textBox('blimit', array('class' => 'form-control')); ?>
        <?= $validator->error('blimit'); ?>
    </div>

    <div class="col-md-12">
        <br>
        <button type="submit" name="btn_update" class="btn btn-primary">Update</button>
    </div>
</form>

</body>
</html>