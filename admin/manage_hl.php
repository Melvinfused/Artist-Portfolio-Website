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
        /* Inline styles for the buttons */
        .btnh {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        
        .btn-container {
            text-align: left;
            margin-top: 50px;
        }
    </style>
</head>
<body>

 <form action="" method="POST" enctype="multipart/form-data">
    <h1>Set-up Banner</h1>
 <div class="btn-container">
    <h3>Set Release to Feature</h3> <br>
    
    <a href="manage_highlight.php" class="btn btn-danger square-btn-adjust" style="margin-left: 20px;">Configure</a> <br>
<br>
    <h3>Set Show to Feature</h3> <br>
    
    <a href="manage_highlight2.php" class="btn btn-danger square-btn-adjust" style="margin-left: 20px;">Configure</a>
</div>
 </form>


</body>

</html>



<?php 
$dao = new DataAccess();
?>


            
