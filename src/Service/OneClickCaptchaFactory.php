<?php

declare(strict_types=1);

namespace OneClickCaptcha\Service;

use Imagine\Gd\Imagine;
use OneClickCaptcha\Config\Config;
use OneClickCaptcha\Proxy\ImageProxy;
use OneClickCaptcha\Repository\SessionStorage;

class OneClickCaptchaFactory
{
    public static function getOneClickCaptcha(): OneClickCaptchaService
    {
        return new OneClickCaptchaService(new Config(), new SessionStorage(), new ImageProxy(new Imagine()));
    }

    public static function getOneClickCaptchaUsingConfig(Config $config): OneClickCaptchaService
    {
        return new OneClickCaptchaService($config, new SessionStorage(), new ImageProxy(new Imagine()));
    }
}
