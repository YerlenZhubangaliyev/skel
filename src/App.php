<?php

use Composer\Autoload\ClassLoader;

/**
 * Application initialization
 */
class App
{

    /**
     * Local developer machine environment
     */
    const ENV_LOCAL = 'Local';

    /**
     * Development environment
     */
    const ENV_DEVELOPMENT = 'Development';

    /**
     * Test environment
     */
    const ENV_TEST = 'Test';

    /**
     * Staging (Pre-production) environment
     */
    const ENV_STAGING = 'Staging';

    /**
     * Production environment
     */
    const ENV_PRODUCTION = 'Production';

    /**
     * Constructor
     *
     * @param \Composer\Autoload\ClassLoader $loader
     */
    public function __construct(ClassLoader $loader)
    {
        $className = sprintf('App\\Applications\\%s', APPLICATION);

        if (!class_exists($className)) {
            printf("Class %s for application %s does not exists", $className, APPLICATION);
            exit(1);
        }

        if (0 === strcasecmp(self::ENV_STAGING, ENVIRONMENT) ||
            0 === strcasecmp(self::ENV_PRODUCTION, ENVIRONMENT)
        ) {
            error_reporting(0);
            ini_set('display_errors', 0);
            ini_set('opcache.enable', 1);
        }

        if (0 === strcasecmp(self::ENV_LOCAL, ENVIRONMENT) ||
            0 === strcasecmp(self::ENV_DEVELOPMENT, ENVIRONMENT) ||
            0 === strcasecmp(self::ENV_TEST, ENVIRONMENT)
        ) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            ini_set('opcache.enable', 0);
        }

        echo (new $className($loader))->handle();
    }
}
