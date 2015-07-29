<!DOCTYPE html>
<html lang = "de">
<head profile="http://www.w3.org/2005/10/profile">

    <meta charset="UTF-8">
    <title>Cherry</title> 
    <h1>Homework delivery system</h1>
    <style type="text/css">
        /* just for the demo */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 10px;
        }
        label {
            position: relative;
            vertical-align: middle;
            bottom: 1px;
        }
        input[type=text],
        input[type=password],
        input[type=submit],
        input[type=email] {
            display: block;
            margin-bottom: 10px;
        }
        input[type="number"] {
            width:30px;
        }
        input[type=checkbox] {
            margin-bottom: 15px;
        }
    </style>
    <link rel="icon" 
      type="image/png" 
      href="http://www3.uni-bonn.de/favicon.ico">
</head>
<body>

<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>
