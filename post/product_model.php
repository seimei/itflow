<?php
$name = sanitizeInput($_POST['name']);
$description = sanitizeInput($_POST['description']);
$price = floatval($_POST['price']);
$category = intval($_POST['category']);
$tax = intval($_POST['tax']);
$location = sanitizeInput($_POST['location']);
$code = sanitizeInput($_POST['code']);