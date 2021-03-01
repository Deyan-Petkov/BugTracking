
<!DOCTYPE html>
<html>
<head>
    <title>Bug Tracker</title>
</head>
<body>

<!-- Creating folder form -->
<form action="" method="post">
    <br><input type="text" name="folderName" placeholder="type folder name here">
    <button type="submit" name="createFolder">Create Folder</button>
</form>
<br>

<?php
   include 'storage.php';
   //connect to Google Storage
   $storage = new storage();

//if new folder name is submitted - create the folder
if (isset($_POST['folderName'])) {
    print_r($_POST);
    echo "<br><br>";
    //create folder with the input from the form above
    $storage->createFolder($_POST['folderName']);
}


//form for uploading files
echo '<form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <button type="submit" name="upload">Upload File</button>
    </form>';


//If file is selected and submitted then upload it to the given folder parameter
if (isset($_POST['upload'])) {
    //params - name of the file, local path to the file, folder name
    $storage->uploadObject($_FILES['file']['name'], $_FILES['file']['tmp_name'], 'ticketID/');

    echo "File Uploaded to folder: ticketID/";
}



echo '<form action="" method="post">
        <br>
            <button type="submit" name="listBucket">List Bucket</button>
        <br>
      </form>'; 
//List the content of the bucket
if(isset($_POST['listBucket'])){
    echo "<br>LIST OF ALL OBJECTS IN THE BUCKET<br>";
    $folders = $storage->listBucket();
    echo "<pre>";
    print_r($folders);
    echo "</pre>";
    echo "<br><br>";
}


// Listing the ocntent of particular folder
echo '<form action="" method="post">
    <br><input type="text" name="listFolder" placeholder="type name here">
    <button type="submit" name="listFolderButton">List Folder</button>
</form>
<br>';

if(isset($_POST['listFolderButton'])){
    echo "CONTENT OF FOLDER ".$_POST['listFolder'];
    $content = $storage->listFolder($_POST['listFolder']);
    echo "<pre>";
    print_r($content);
    echo "</pre>";

}
 

    /**
     * This is how we delete object.
     * The name of the object is the path to the object
     * You can see all objects paths by using the form above
     * clicking on button "List Bucket".
     * listBucket() function lists all objects in a bucket
     * and listFolder() list the objects in particular folder.
     */
// $storage->deleteObject('NameOfTheObjectHere', null);

    /**
     * This is how we delete folder.
     * To be deleted, the folder needs to be empty.
     * If you type in the name of the folder then don't forget to append / at the end.
     * The arrays returned by listFolder() and listBucket() contain the / sign so
     * if you use index of the array as parameter do deleteObject() then there is no need to pass / sign
     */
//  $storage->deleteObject('NameOfTheFolderHere/', null);

?>

</body>
</html>