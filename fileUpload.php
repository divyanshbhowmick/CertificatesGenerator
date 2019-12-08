<?php require_once('helper.php'); ?>
<?php
if (isset($_POST['submit'])) {
    if (isset($_FILES['dataUpload'])) {
        if ($_FILES['dataUpload']['error'] > 0) echo $_FILES['dataUpload']['error'] . "<br/>";
        else {
            if (!$_FILES['dataUpload']['type'] == "application/vnd.ms-excel") echo "Wrong file type!";
            else {
                $file_name = storefile();
                readcsv($file_name);
            }
        }
    }
}
