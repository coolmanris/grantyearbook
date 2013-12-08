<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" type="text/css" href="style.css">
<title>Grant High School Yearbook</title>

</head>
<?php session_start();
if(!empty($_POST["password"])){ //Set the password variable in the session to the password entered
    $_SESSION['password'] = $_POST["password"];
} else if(empty($_SESSION["password"])) { 
    $_SESSION['password'] = ""; //If password was not entered initialize it so there are no errors
}
function formatBytes($size, $precision = 2) //function to change file size suffix based on size
{
    $base = log($size) / log(1024);
    $suffixes = array('B', 'k', 'M', 'G', 'T');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}
function content() {
    $version = PHP_VERSION_ID/100 - 500; //Get the version number and remove the 5 from th front of it
    $_SESSION['validPassword'] = true; //Save that the password was valid
    echo '<a href="redirect.php">Logout</a><br>';
    echo "<h2>Current Files</h2><p>Click on link to download.</p>";
    $files = scandir('./files'); //Change directory to where the files will be saved
    sort($files); // this does the sorting
    echo "<table><tr><th>File Name</th><th>File Size</th><th>Date uploaded</th></tr>";
    foreach($files as $file){
        if ($file != "." and $file != ".." and $file != "index.php") { //Ignore the . and .. directories and index.php in the files directory when listing files
            echo "<tr>";
            echo '<td><a href="./files/'.$file.'"target="_blank" download>'.$file.'</a>';
            echo "<td>" . formatBytes(filesize('./files/' . $file)) ; //Creates a link to each file, displays filesize, and forces download
            echo "<td>" . date ("F d Y H:i:s", filemtime('./files/' . $file)); //Shows date modified
            echo "</tr>";
        }
    }
    echo "</table>";
    echo '<form name="input" action="/verify.php" method="post">
<input type="submit" value="Click to refresh page"';
        echo ">
</form>";
    echo '<script>var verify = true;</script>';
    $html = file_get_contents('./fileupload.php');
    echo $html;
    echo '<script>var verify = false;</script>';
    if(!empty($_POST["overwrite"])){ //Set the overwrite variable in the session to the variable entered
    $_SESSION['overwrite'] = $_POST["overwrite"];
} else if(empty($_SESSION["overwrite"])) { 
    $_SESSION['overwrite'] = ""; //If overwrite was not entered initialize it so there are no errors
}
    echo '<form id="button" name="input" action="/verify.php" method="post">
<input type="submit" value=';
    if($_SESSION['overwrite'] == "Overwrite disabled") { //Create buttons for user input on overwriting
    echo '"Overwrite enabled" name="overwrite"'; //Sets overwrite to the opposite of what it should be
    } else {
    echo '"Overwrite disabled" name="overwrite"';
    }
        echo '><span id="invalid">If you toggle the overwrite button the page will refresh, clearing your queue of file uploads.</span></form> '; //Alt text(If you click either of these buttons the page will refresh, clearing your queue of file uploads
    if (!isset($_SESSION['overwritten'])) {
        $_SESSION['overwritten'] = "";
    }
    if ($_SESSION['overwritten'] === false) {
        echo "<p id=invalid>File not overwritten</p>";
    } else if ($_SESSION['overwritten'] === true) {
        echo "<p id=valid>File successfully overwritten</p>";
    }
    $_SESSION['overwritten'] = "";
    echo "<p>If you find any bugs, report them to the website's <a href='https://github.com/waylon531/grantyearbook/issues'>github</a></p>";
    echo 'This server is running php version 5.' . $version;}
//Checks the entered password against the password hash
//Get the version number and remove the 5 from th front of it
    if ("23a33778aadbd7cf9a529979b01dbff5" == md5($_SESSION['password'])) { //Check password using the md5 function.
        content();
    
    } else {
        $_SESSION['invalid'] = true; //If the password was incorrectly entered change invalid to true so that when you go back to the home page invalid password is displayed
        echo '<meta http-equiv="refresh" content="0;URL=index.php" /> '; //If the password was incorrect return you to the login page
    }
?>
