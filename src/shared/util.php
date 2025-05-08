<?php

function include_with_prop($fileName, $prop): void
{
  extract($prop);
  include $fileName;
}
