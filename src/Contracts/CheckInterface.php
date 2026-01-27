<?php

namespace PulseCheck\Contracts;

use PulseCheck\Result;

interface CheckInterface
{
    public function run(): Result;
}
