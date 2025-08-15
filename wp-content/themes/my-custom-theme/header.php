<?php if (!defined('ABSPATH')) exit; ?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="header">
  <div class="container">
    <div class="grid">
      <div class="col" style="grid-column: span 6;">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><?php bloginfo('name'); ?></a>
      </div>
      <nav class="col" style="grid-column: span 6; text-align:right;">
        <?php wp_nav_menu(['theme_location'=>'primary','container'=>false]); ?>
      </nav>
    </div>
  </div>
</header>
<main class="container">
