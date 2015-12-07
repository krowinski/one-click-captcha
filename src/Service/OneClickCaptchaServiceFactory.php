<?php
namespace OneClickCaptcha\Service;

use Imagine\Gd\Imagine;
use OneClickCaptcha\Config\Config;
use OneClickCaptcha\Proxy\ImagineProxy;
use OneClickCaptcha\Repository\SessionPostRepository;

/**
 * Class OneClickCaptchaServiceFactory
 * @package OneClickCaptcha\Service
 * @codeCoverageIgnore
 */
class OneClickCaptchaServiceFactory
{
    /**
     * @return OneClickCaptchaService
     */
    public function getOneClickCaptcha()
    {
        return new OneClickCaptchaService(
            new Config(),
            new SessionPostRepository(),
            new ImagineProxy(new Imagine())
        );
    }

    /**
     * @param Config $config
     * @return OneClickCaptchaService
     */
    public function getOneClickCaptchaUsingConfig(Config $config)
    {
        return new OneClickCaptchaService(
            $config,
            new SessionPostRepository(),
            new ImagineProxy(new Imagine())
        );
    }
}