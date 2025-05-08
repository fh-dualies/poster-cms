<?php

function include_with_prop($fileName, $prop)
{
    extract($prop);
    include $fileName;
}