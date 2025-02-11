<?php 

 require('../config/autoload.php'); 
include("header.php");

$file=new FileUpload();
$elements=array(
        "tname"=>"", "album"=>"", "artist"=>"", "rdate"=>"", "art"=>"", "url"=>"");


$form=new FormAssist($elements,$_POST);



$dao=new DataAccess();

$labels=array('tname'=>"Track Name : ", 'album'=>"Album Name : ", 'artist'=>"Artist : ", 'rdate'=>"Release Date : ", 'art'=>"Artwork : ", 'url'=>'URL : ');

$rules=array(
    "tname"=>array("required"=>true,"minlength"=>1,"maxlength"=>50),
    "album"=>array("required"=>true,"minlength"=>1,"maxlength"=>50),
    "artist"=>array("required"=>true,"minlength"=>1,"maxlength"=>50),
    "rdate"=>array("required"=>true),
    "art"=>array("filerequired"=>true),
    "url"=>array("required"=>true)

);
    
    
$validator = new FormValidator($rules,$labels);

if(isset($_POST["btn_insert"]))
{

if($validator->validate($_POST))
{
    if($fileName=$file->doUploadRandom($_FILES['art'],array('.jpg','.png','.jpeg'),100000,5,'../uploads'))
		{

$data=array(

    'tname'=>$_POST['tname'],
    'album'=>$_POST['album'],
    'artist'=>$_POST['artist'],
    'rdate'=>$_POST['rdate'],
          'art'=>$fileName,
    'url'=>$_POST['url']
    );
	



  
    if($dao->insert($data,"discography"))
    {
        echo "<script> alert('New record created successfully');</script> ";
header('location:manage_disco.php');


    }
}
else
{$msg="Insertion failed";} ?>

<span style="color:red;"><?php echo $msg; ?></span>

<?php

}
else
echo $file->errors();
}

?>
<html>
<head>
<style>

</style>
</head>
<body>

 <form action="" method="POST" enctype="multipart/form-data">
 
 <h1>Discography</h1>
<div class="row">
<h2></h2>
<div class="col-md-6">
Track Name :

<?= $form->textBox('tname',array('class'=>'form-control')); ?>
<?= $validator->error('tname'); ?>

</div>
<div class="col-md-6">
Album/EP Name :

<?= $form->textBox('album',array('class'=>'form-control')); ?>
<?= $validator->error('album'); ?>

</div>

<div class="col-md-6">
Artist :

<?= $form->textBox('artist',array('class'=>'form-control')); ?>
<?= $validator->error('artist'); ?>

</div>
<?php
$maxDate = date('Y-m-d', strtotime('+2 years'));
?>

<div class="col-md-6">
    Release Date:
    <?= $form->inputBox('rdate', array(
        'class' => 'form-control',
        'type' => 'date', 
        'min' => '1900-01-01', 
        'max' => $maxDate, 
    ), "date"); ?>
    <?= $validator->error('rdate'); ?>
</div>

<div class="col-md-6">
Artwork :

<?= $form->fileField('art',array('class'=>'form-control')); ?>
<span style="color:red;"><?= $validator->error('art'); ?></span>

</div>

<div class="col-md-6">
URL :
<?= $form->inputBox('url',array('class'=>'form-control')); ?>
<span style="color:red;"><?= $validator->error('url'); ?></span>

</div>

</div>
<br>
<button type="submit" name="btn_insert"  >Submit</button> <br>

<div >
    <h2></h2>
<br>
                <table border="1" class="table" style="margin-top:100px;">
                    <tr>
                        <th>ID</th>
                        <th>Track</th>
                        <th>Album</th>
                        <th>Artist/s</th>
                        <th>Release</th>
                        <th>Artwork</th>
                        <th>URL</th>
                        <th>Actions</th>
                        <th>    </th>
                    </tr>
                    <?php
                    $actions = array(
                        'EDIT' => array('label' => 'EDIT', 'link' => 'update_disco.php', 'params' => array('id' => 'tid'), 'attributes' => array('class' => 'btn btn-success')),
                        'DEL' => array('label' => 'DEL', 'link' => 'del_disco.php', 'params' => array('id' => 'tid'), 'attributes' => array('class' => 'btn btn-danger'))
                    );

                    $config = array(
                        'srno' => true,
                        'hiddenfields' => array('tid'),
                        'actions_td' => true,
                        'images' => array(
                            'field' => 'art',
                            'path' => '../uploads/',
                            'attributes' => array('style' => 'width:100px;')
                        )
                    );

                    $fields = array('tid', 'tname', 'album', 'artist', 'rdate', 'art', 'url');
                    $records = $dao->selectAsTable($fields, 'discography', 1, array(), $actions, $config);

                    echo $records;

// Display success/error message based on the deletion operation
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 'deleted') {
        echo "<script>alert('Record deleted successfully');</script>";
    } elseif ($_GET['msg'] == 'error') {
        echo "<script>alert('Error deleting record');</script>";
    } elseif ($_GET['msg'] == 'invalid') {
        echo "<script>alert('Invalid ID specified');</script>";
    }
}
?>
                
                </table>
            </div>


</form>


</body>

</html>



<?php 
$dao = new DataAccess();
?>


            
