<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<?php

require "database.php";
require "events.class.php";
$event = new Events();

if(isset($_POST["event_date"])) $event->date = $_POST["event_date"];
if(isset($_POST["event_time"])) $event->time = $_POST["event_time"];
if(isset($_POST["event_location"])) $event->location = $_POST["event_location"];
if(isset($_POST["event_description"])) $event->description = $_POST["event_description"];

if(isset($_GET["fun"])) $fun = $_GET["fun"];
else $fun = 0;

switch ($fun) {
    case 1: // create
        $event->create_record();
        break;
    case 2: // read
        $event->read_record();
        break;
    case 3: // update
        $event->update_record();
        break;
    case 4: // delete
        $event->delete_record();
        break;
    case 11: // insert database record from create_record()
        $event->insert_record();
        break;
    case 33: // update database record from update_record()
        $event->refresh_record();
        break;
    case 44: // delete database record from delete_record()
        $event->remove_record();
        break;
    case 0: // list
    default: // list
        $event->list_records();
}