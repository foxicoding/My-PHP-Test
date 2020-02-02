<?php
namespace apps\kafka\log;
class MFacade_logEnvApi
{
    const ENV_PRODUCT = 'product';
    const ENV_BRANPUB = 'branpub';
    const ENV_DEVELOP = 'develop';
    const LOG_PATH_DOCKER = '/mfw_data/log/share/';
    const LOG_PATH = '/mfw_rundata/log/';

    public static function sGetEnv()
    {
        if (1 === IS_BRANPUB_SERVER)
            return self::ENV_BRANPUB;
        else if (1 === IS_DEV_SERVER)
            return self::ENV_DEVELOP;
        else
            return self::ENV_PRODUCT;
    }
    public static function sGetLogPath()
    {
        if(1 === IS_BRANPUB_SERVER || 1 === IS_DEV_SERVER){
            return self::LOG_PATH_DOCKER;
        }

        return self::LOG_PATH;
    }
}