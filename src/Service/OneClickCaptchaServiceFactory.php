<?php
declare(strict_types=1);

namespace OneClickCaptcha\Service;

use Imagine\Gd\Imagine;
use OneClickCaptcha\Config\Config;
use OneClickCaptcha\Proxy\ImageProxy;
use OneClickCaptcha\Repository\SessionStorageInterfaceRepository;

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
    public function getOneClickCaptcha(): OneClickCaptchaService
    {
        return new OneClickCaptchaService(
            new Config(),
            new SessionStorageInterfaceRepository(),
            new ImageProxy(new Imagine())
        );
    }

    /**
     * @param Config $config
     * @return OneClickCaptchaService
     */
    public function getOneClickCaptchaUsingConfig(Config $config): OneClickCaptchaService
    {
        return new OneClickCaptchaService(
            $config,
            new SessionStorageInterfaceRepository(),
            new ImageProxy(new Imagine())
        );
    }
}