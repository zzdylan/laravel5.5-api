<?php

namespace App\Services;

use Overtrue\EasySms\EasySms;

class Sms extends EasySms
{
    public function __construct(){
        parent::__construct(config('sms'));
    }
}