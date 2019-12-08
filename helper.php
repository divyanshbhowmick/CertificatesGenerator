<?php require_once('mailer.php') ?>
<?php
function storefile()
{
    $dir = getcwd() . '/uploads';
    $number = count(scandir($dir)) - 2;
    $file_extension = substr($_FILES['dataUpload']['name'], strrpos($_FILES['dataUpload']['name'], ".") + 1);
    $file_name = "sheet_" . ($number + 1) . '.' . $file_extension;
    $file_location = getcwd() . '/uploads//';
    move_uploaded_file($_FILES['dataUpload']['tmp_name'], $file_location . $file_name);
    return $file_name;
}

function sendMail($name, $email)
{
    $subject = "Important";
    $from = "divyansh@bharatorigins.in";
    $message = "Hello " . $name;
    $headers = "From:" . $from;
    mail($email, $subject, $message, $headers);
    echo "The email was sent!";
}

function readcsv($file_name)
{
    if (isset($file_name) && $file = fopen("uploads/" . $file_name, 'r')) {

        //Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
        $firstline = fgets($file, 4096);

        $num = strlen($firstline) - strlen(str_replace(",", "", $firstline));
        //save the different fields of the firstline in an array called fields
        $fields = array();
        $fields = explode(",", $firstline, ($num + 1));
        $name_index = 0;
        $email_index = 0;
        for ($i = 0; $i <= $num; $i++) {

            if (!strcasecmp($fields[$i], "name")) $name_index = $i;
            else if (!(strcasecmp($fields[$i], "email"))) $email_index = $i;
        }
        echo $name_index . $email_index;
        $line = array();
        $i = 0;

        //CSV: one line is one record and the cells/fields are seperated by ";"
        //so $dsatz is an two dimensional array saving the records like this: $dsatz[number of record][number of cell]
        while ($line[$i] = fgets($file, 4096)) {
            $data[$i] = array();
            $data[$i] = explode(",", $line[$i], ($num + 1));
            $i++;
        }
        foreach ($data as $value) {
            foreach ($value as $key => $val) {
                if ($key == $name_index) $name = $val;
                else if ($key == $email_index) $email = $val;
            }
            if (isset($name) && isset($email)) configureDetails($name, $email);
        }
    }
}
