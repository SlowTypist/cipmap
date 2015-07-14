<!DOCTYPE html>
<html lang = "de">
<head>
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
            margin-bottom: 15px;
        }
        input[type=checkbox] {
            margin-bottom: 15px;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(function() {
        $( "#fromDate" ).datepicker
        (
        { 
            dateFormat: 'yy-mm-dd',
             onSelect: function( selectedDate ) {
            $( "#toDate" ).datepicker( "option", "minDate", selectedDate );}
        }
        );
        $( "#toDate" ).datepicker
        (
        { 
            dateFormat: 'yy-mm-dd',
            onSelect: function( selectedDate ) {
            $( "#fromDate" ).datepicker( "option", "maxDate", selectedDate );}
        }
        );
        });
    </script>
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
