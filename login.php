<?php

use BD_KDD\BD;
require 'base.php';

if(isset ($id))
    {

        $bd = new BD;
        $foo = $bd->URL();
        header($foo);

    }

       