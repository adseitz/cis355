<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<?php
session_start();
require "database.php";
require "persons.class.php";
$person = new Persons();

if(isset($_POST["name"])) $person->name = $_POST["name"];
if(isset($_POST["email"])) $person->email = $_POST["email"];
if(isset($_POST["mobile"])) $person->mobile = $_POST["mobile"];

if(isset($_GET["fun"])) $fun = $_GET["fun"];
else $fun = 0;

switch ($fun) {
    case 1: // create
        $person->create_record();
        break;
    case 2: // read
        $person->read_record();
        break;
    case 3: // update
        $person->update_record();
        break;
    case 4: // delete
        $person->delete_record();
        break;
    case 11: // insert database record from create_record()
        $person->insert_record();
        break;
    case 33: // update database record from update_record()
        $person->refresh_record();
        break;
    case 44: // delete database record from delete_record()
        $person->remove_record();
        break;
    case 0: // list
    default: // list
        $person->list_records();
}