<?php
    foreach (glob("Controllers/*.php") as $filename)
    {
        include $filename;
    }

    foreach (glob("Core/*.php") as $filename)
    {
        include $filename;
    }

    foreach (glob("Config/*.php") as $filename)
    {
        include $filename;
    }
