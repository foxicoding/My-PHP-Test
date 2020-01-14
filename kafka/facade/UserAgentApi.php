<?php
/**
 * Created by PhpStorm.
 * User: wenhao
 * Date: 2019/3/8
 * Time: 14:37
 */

namespace apps\kafka;

/**
 * @deprecated
 *
 * Class MFacade_UserAgentApi
 * @package apps\kafka
 */
class MFacade_UserAgentApi {

    private $userAgent;

    private $sys = 'unknown';
    private $sysVersion = 'unknown';
    private $browser = 'unknown';
    private $browserVersion = 'unknown';
    private $brand = 'unknown';
    private $hardwareModel = 'unknown';
    private $kernel = 'unknown';
    private $kernelVersion = 'unknown';
    private $deviceType = 'unknown';


    private static $a_Kernels = array(
        'applewebkit' => 'webkit',
        'trident' => 'trident',
        'blink' => 'blink',
        'presto' => 'presto',
        'gecko' => 'gecko'
    );

    private static $a_DeviceTypes = array(
        'windows phone os ' => 'wos',
        'winnt' => 'windows',
        'win98' => 'windows',
        'win95' => 'windows',
        'windows' => 'windows',

        'iphone' => 'iphone',
        'ipad' => 'ipad',
        'ipod' => 'ipod',
        'macintosh' => 'mac',
        'mac os x' => 'mac',
        'ppc mac' => 'mac',

        'android' => 'android',
        'linux' => 'linux',
        'unix' => 'unix'
    );

    public function __construct($ua) {
        $this->userAgent = $ua;
    }

    public static function parseUserAgent($ua) {
        $api = new MFacade_UserAgentApi($ua);

        $api->parseSystem();
        $api->parseBrowser();
        $api->parseKernel();
        $api->parseBrand();
        $api->parseDeviceType();
        $api->parseHardwareModel();

        return $api->package();
    }

    private function package() {
        return array(
            'sys' => $this->sys,
            'sys_ver' => $this->sysVersion,
            'browser' => $this->browser,
            'browser_ver' => $this->browserVersion,
            'brand' => $this->brand,
            'hardware_model' => $this->hardwareModel,
            'kernel' => $this->kernel,
            'kernel_ver' => $this->kernelVersion,
            'device_type' => $this->deviceType
        );
    }

    private function parseSystem() {
        $platform = \Ko_Tool_UA::AGetPlatfrom($this->userAgent);

        if (!empty($platform)) {
            if (isset($platform['platform'])) {
                $this->sys = $platform['platform'];
            }

            if (isset($platform['platform_version'])) {
                $this->sysVersion = $platform['platform_version'];
            }
        }
    }

    private function parseBrowser() {
        $browser = \Ko_Tool_UA::AGetBrowser($this->userAgent);

        if (!empty($browser)) {
            if (isset($browser['browser'])) {
                $this->browser = $browser['browser'];
            }

            if (isset($browser['browser_version'])) {
                $this->browserVersion = $browser['browser_version'];
            }
        }
    }

    private function parseKernel() {
        $ua = strtolower($this->userAgent);

        foreach (self::$a_Kernels as $key => $val) {
            if (preg_match("|" . preg_quote($key) . ".*?([0-9\.]+)|i", $ua, $match)) {
                $this->kernel = $val;
                $this->kernelVersion = count($match) > 1 ? $match[1] : '';
                break;
            }
        }
    }

    private function parseDeviceType() {
        $ua = strtolower($this->userAgent);
        foreach (self::$a_DeviceTypes as $key => $val) {
            if (false !== (strpos($ua, $key))) {
                $this->deviceType = $val;
                break;
            }
        }
    }

    private function parseBrand() {
        $mobiles = \Ko_Tool_UA::AGetMobile($this->userAgent);

        if (!empty($mobiles)) {
            if (isset($mobiles['mobile'])) {
                $this->brand = $mobiles['mobile'];
            }
        }
    }

    private function parseHardwareModel() {
        $this->hardwareModel = $this->brand;
    }
}