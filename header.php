<?php
if (!defined('ABSPATH')) exit();

require_once __DIR__ . '/functions.php';


?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="description" content="<?php bloginfo('description'); ?>"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class(["font-light ", "text-dark"]); ?>>
<?php wp_body_open();

    get_template_part('template-parts/header')
?>
<main>




