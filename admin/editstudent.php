<?php require('../config/autoload.php'); ?>
<?php
	

include("header.php");
$dao=new DataAccess();
$info=$dao->getData('*','student','sid='.$_GET['id']);
$file=new FileUpload();
$elements=array(
        "sname"=>$info[0]['sname'],"sage"=>$info[0]['age'],"simg"=>"");

	$form = new FormAssist($elements,$_POST);

$labels=array('id'=>"Student ID",'sname'=>"Student Name","sage"=>"Student Age");

$rules=array(
    "sname"=>array("required"=>true,"minlength"=>3,"maxlength"=>30,"alphaonly"=>true),
    "sage"=>array("required"=>true,"minlength"=>2,"maxlength"=>2,"integeronly"=>true),
    "s_img"=>array("filerequired"=>true)

     
);
    
    
$validator = new FormValidator($rules,$labels);

if(isset($_POST["btn_update"]))
{
if($validator->validate($_POST))
{

if(isset($_FILES['simg']['name'])){
			if($fileName=$file->doUploadRandom($_FILES['simg'],array('.jpg','.png','.jpeg'),100000,5,'../uploads'))
			{
				$flag=true;
					
			}
}
$data=array(

        'sname'=>$_POST['sname'],
        'sage'=>$_POST['sage'],
          //'simage'=>$_POST['simage'],
    );
  $condition='sid='.$_GET['id'];
if(isset($flag))
			{	$data['simg']=$fileName;
		
			}
    

if($dao->update($data,'student',$condition))
    {
        $msg="Successfullly Updated";

    }
    else
        {$msg="Failed";} ?>

<span style="color:red;"><?php echo $msg; ?></span>

<?php
    
}


}


	
	
	
	
?>

<html>
<head>
	<style>
		.form{
		border:3px solid blue;
		}
	</style>
</head>
<body>


	<form action="" method="POST" enctype="multipart/form-data" >
 
<div class="row">
                    <div class="col-md-6">
Name:

<?= $form->textBox('sname',array('class'=>'form-control')); ?>
<?= $validator->error('sname'); ?>

</div>
</div>

<div class="row">
                    <div class="col-md-6">
Age:

<?= $form->textBox('sage',array('class'=>'form-control')); ?>
<?= $validator->error('sage'); ?>

</div>
</div>


<div class="row">
                    <div class="col-md-6">
IMAGE:


<?= $form->fileField('simg',array('class'=>'form-control')); ?>

</div>
</div>





<button type="submit" name="btn_update"  >UPDATE</button>
</form>

</body>
</html>