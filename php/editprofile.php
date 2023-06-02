<?php 
session_start();
include_once 'db.php';
$unique_id = $_SESSION['unique_id'];
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$bio = $_POST['bio'];
$location = $_POST['location'];
$Links = $_POST['Links'];
$birthdate= $_POST['birthdate'];

//checking field are not empty
if(!empty($bio) && !empty($location) && !empty($Links ) && !empty($birthdate))
{
    if(isset($_FILES['cimage'])) 
    {
        $img_name = $_FILES['cimage']['name']; //getting image name
        $img_typ = $_FILES['cimage']['type']; //getting image type
        $tmp_name = $_FILES['cimage']['tmp_name'];
        $img_explode = explode('.', $img_name);
        $img_extension = end($img_explode); 
        $extensions = ['png', 'jpeg', 'jpg']; //these are some valid image extensions
        if(in_array($img_extension, $extensions) === true)
        {
            
            $time = time();
            $newimagename = $time . $img_name; //creating a unique name for image
            
            if(move_uploaded_file($tmp_name, "../coverimg/" .$newimagename)) 
            {
                if(!empty($firstname) && !empty($lastname))
                {
                    $sql = mysqli_query($conn, "UPDATE users SET fname = '{$firstname}', lname = '{$lastname}',cover = '{$newimagename}',bio= '{$bio}',location ='{$location}',birthday ='{$birthdate}',social_media='{$Links}'
                    
                    WHERE unique_id= '{$unique_id}';");
                    
                    if($sql){
                        echo "success";
                    }else{
                        echo "database error";
                    }
                    

                }else
                {
                    $sql2 = mysqli_query($conn, "UPDATE users SET cover = '{$newimagename}',bio= '{$bio}',location ='{$location}',birthday ='{$birthdate}',social_media='{$Links}'
                    
                    WHERE unique_id= '{$unique_id}';");
                    if($sql2){
                        echo "success";
                    }else{
                        echo "database error";
                    }
                }

            }else
            {
                    echo "nhi hua";
            }
            

        }
        else{
            echo"please select an image with extension jpg png jpeg";
        }
       
    }
    else{
        echo " image not set";
    }
}
else
{
    echo " Please fill all required fields";
}


?>