<?php
# Includes the autoloader for libraries installed with composer
    require __DIR__ . '/vendor/autoload.php';

# Imports the Google Cloud client library
use Google\Cloud\Storage\StorageClient;

class storage {

    private $projectId;
    private $storage;
    private $bucketName;


    public function __construct(){  
        putenv("GOOGLE_APPLICATION_CREDENTIALS=".$_SERVER['DOCUMENT_ROOT']."/credentials/cloud-ticketing-system-a69fb2997ee4.json");
        # Your Google Cloud Platform project ID
        $this->projectId = 'cloud-ticketing-system';

        # Instantiates a client
        $this->storage = new StorageClient([
            'projectId' => $this->projectId
        ]);

        $this->bucketName = 'cloud-ticketing-system.appspot.com';
        $this->storage->registerStreamWrapper();

    }


    /**
     * Upload a file in folder of your choice.
     * If the folder doesn't exist, it will be automaticlly created.
     *
     * @param string $objectName the name of the object.
     * @param string $source the path to the file to upload.
     * @param string $destinationFolder the bucket folder in which to upload the file
     * ***FOLDER NAMES END WITH / e.g. ID21/ *** 
     *
     * @return Psr\Http\Message\StreamInterface
     */
    function uploadObject($objectName, $source, $destinationFolder)
    {
        $file = fopen($source, 'r');
        $bucket = $this->storage->bucket($this->bucketName);
        $object = $bucket->upload($file, [
            'name' => $destinationFolder.$objectName
        ]);
        // printf('<br>Uploaded %s to gs://%s/%s%s<br><br>' . PHP_EOL, basename($source), $this->bucketName, $destinationFolder, $objectName);
    }

    /**
     * Create an empty folder.
     * This method is similar to uploadObject but we pass / to the end of the name
     * to create folder. 
     * @param string name for the new folder.
     */
    function createFolder($folderName)
    {
        $bucket = $this->storage->bucket($this->bucketName);
        $object = $bucket->upload("null", [
            'name' => $folderName.'/'
        ]);
        //  printf('<br>Uploaded %s to gs:///%s<br>' . PHP_EOL, $this->bucketName, $folderName);
    }
    
    /**
     * Download an object from Cloud Storage and save it as a local file.
     *
     * @param string $objectName the name of your Google Cloud object.
     * This is the full path of the object.To obtain it, use the list 
     * some of the list functions bellow.                
     * @param string $destination the local destination to save the encrypted object.
     * @return void
     */
    function downloadObject($objectName, $destination)
    {
        $bucket = $this->storage->bucket($this->bucketName);
        $object = $bucket->object($objectName);
        $object->downloadToFile($destination);
        printf('<br>Downloaded gs://%s/%s to %s<br>' . PHP_EOL,
            $this->bucketName, $objectName, basename($destination));
    }


    /**
     * List Cloud Storage bucket objects.
     * @return list with the names of all objects in the bucket.
     */
    function listBucket()
    {
        $bucket = $this->storage->bucket($this->bucketName);
        $listWithObjects = [];
        foreach ($bucket->objects() as $object) {
            // printf('Object: %s' . '<br>', $object->name());
            $listWithObjects[] = $object->name();
        }
        return $listWithObjects;
    }


    /**
     * Show the content of particular folder.
     * @param string the name of the folder you would like to list.
     * @return list with the name of all objects in the folder.
     */
    function listFolder($folderName){
        $folderContent = [];
        $bucket = $this->storage->bucket($this->bucketName);

        $objects = $bucket->objects([
            'prefix' => $folderName,
            'fields' => 'items/name,nextPageToken'
        ]);

        foreach ($objects as $object) {
            // echo $object->name() . '<br>';
            $folderContent[] = $object->name();
        }
        return $folderContent;
    }


    /**
     * Delete an object.
     *
     * @param string $objectName the name of your Cloud Storage object. 
     * *Folders are also objects and can be deleted with this function
     * but the folder have to be emptied first*.
     * @param array $options(might be null).
     * @return void
     */
    function deleteObject($objectName, $options = [])
    {
        $bucket = $this->storage->bucket($this->bucketName);
        $object = $bucket->object($objectName);
        $object->delete();
        // printf('<br>Deleted gs://%s/%s<br>' . PHP_EOL, $this->bucketName, $objectName);
    }

    /**
     * @param string pass file name to get url to the file.
     * @return publicly available url.
     */
    function getURL($objectName){
        return 'https://storage.cloud.google.com/'.$this->bucketName.'/'.$objectName;
    }

    /**
     * @param string the ID of the desired chat
     * @return json file containing the chat history
     */
    function getChat($ID){
        $chat = file_get_contents("gs://cloud-ticketing-system.appspot.com/chat/".$ID.".json");
        return json_decode($chat);
    }

    /**
     * @param the message to be uploaded
     * @param the chat ID
     * @return the number of bytes that were written to the file, or false on failure.
     */
    function saveChat($message, $ID){
        $encoded = json_encode($message);
        return file_put_contents("gs://cloud-ticketing-system.appspot.com/chat/".$ID.".json", $encoded);
    }

}

?>
