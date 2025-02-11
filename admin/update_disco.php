<?php 

 require('../config/autoload.php'); 
include("header.php");
$dao=new DataAccess();
$info=$dao->getData('*','discography','tid='.$_GET['id']);

$file=new FileUpload();
$elements=array(
        "tname"=>"", "album"=>"", "artist"=>"", "rdate"=>"", "art"=>"", "url"=>"");


$form=new FormAssist($elements,$_POST);



$dao=new DataAccess();

$labels=array('tname'=>"Track Name : ", 'album'=>"Album Name : ", 'artist'=>"Artist : ", 'rdate'=>"Release Date : ", 'art'=>"Artwork : ", 'url'=>'URL : ');

$rules=array(
    "rdate"=>array("required"=>true),
    "art"=>array("filerequired"=>true),
    "url"=>array("required"=>true)

);
    
    
   
$validator = new FormValidator($rules,$labels);

if(isset($_POST["btn_update"]))
{

if($validator->validate($_POST))
{
    
    if(isset($_FILES['art'])){
        if($fileName=$file->doUploadRandom($_FILES['art'],array('.jpg','.png','.jpeg'),100000,5,'../uploads'))
        {
            $flag=true;
                
        }
    }
    $data=array(

        'rdate'=>$_POST['rdate'],
        'art'=>$fileName,
        'url'=>$_POST['url']
       
    );
    $condition='tid='.$_GET['id'];
    if(isset($flag))
                {   
                    $data['art']=$fileName;
            
                }
        
    
    if($dao->update($data,'discography',$condition))
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
</head>
<body>

<form action="" method="POST" enctype="multipart/form-data">
    <h1>Update Track Information</h1>
    <div class="row">
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
            Artwork:
            <?= $form->fileField('art', array('class' => 'form-control')); ?>
            <span style="color:red;"><?= $validator->error('art'); ?></span>
        </div>
        <div class="col-md-6">
            URL:
            <?= $form->inputBox('url', array('class' => 'form-control')); ?>
            <?= $validator->error('url'); ?>
        </div>
    </div>
    <br>
    <button type="submit" name="btn_update">Update</button>
    <br>

</form>


</body>

</html>