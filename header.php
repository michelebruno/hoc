<?php
if (!defined('ABSPATH')) exit();

require_once __DIR__ . '/functions.php';


?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="title" content="<?php wp_title('|', true, 'right'); ?>">
    <meta name="description" content="<?php bloginfo('description'); ?>"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(["font-normal !font-DEFAULT"]); ?>>
<?php wp_body_open(); ?>
<nav class="shadow-lg">
    <nav class="container mx-auto">
        Questa è la navbar
    </nav>
</nav>



