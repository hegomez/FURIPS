<?php
    $bd_furips = new PDO('mysql:host=localhost;dbname=formatos_web', 'furips', 'furips');
    $bd_furips->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bd_furips->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $bd_furips->exec("SET NAMES 'utf8'");