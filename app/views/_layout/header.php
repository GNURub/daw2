<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>TheCatLong...</title>
    <meta name="description" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- JS -->
    <!-- please note: The JavaScript files are loaded in the footer to speed up page construction -->

    <!-- CSS -->
    <link href='https://fonts.googleapis.com/css?family=Pacifico|Roboto:400,700,300,500,400italic|Montserrat:400,700|Material+Icons' rel='stylesheet' type='text/css'>
<!--     <link href="<?php echo URL; ?>css/material.css" rel="stylesheet"> -->
    <link href="<?=URL; ?>css/all.css" rel="stylesheet">
</head>
<body>
<!--         <a href="<?php echo URL; ?>songs">songs</a> -->
    <header class="cabecera">
        <nav class="utils">
          <div>
            <a href="" >
              <span class="title pacifico">The Cat Long</span>
            </a>
          </div>
          <div class="buscador">
            <i class="material-icons">search</i>
            <input type="search">
          </div>
          <ul class="menu">
            <li></li>
            <li>
              <?php
                if (!self::getSession('username')) {
              ?>
                  <a href="/home/signup">Registro</a>
              <?php
                }else{
              ?>
                  <a href="/client/">Perfil</a>
              <?php
                }
              ?>
            </li>
            <li>
              <a href="javascript: void(0)" class="button-icon"><i class="material-icons">more_vert</i></a>
              <ul>
              </ul>
            </li>
            <li>
              <?php
                if (!self::getSession('username')) {
              ?>
                  <a href="/home/signin">Login</a>
              <?php
                }else{
              ?>
                  <a href="/home/logout">Logout</a>
              <?php
                }
              ?>
            </li>
          </ul>
        </nav>
        <nav>
          
        </nav>
    </header>
