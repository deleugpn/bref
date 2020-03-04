<?php

namespace Bref\Event;

interface ExceptionHandler
{
    public function error(\Throwable $error);
}