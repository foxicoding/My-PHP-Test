<?php

namespace apps\kafka\log;

define('UNKNOWN', '?');
define('LIBVERSION', '0.7.19');
define('EMPTY', '');
define('FUNC_TYPE', 'function');
define('UNDEF_TYPE', 'undefined');
define('OBJ_TYPE', 'object');
define('STR_TYPE', 'string');
define('MAJOR', 'major');
define('MODEL', 'model');
define('NAME', 'name');
define('TYPE', 'type');
define('VENDOR', 'vendor');
define('VERSION', 'version');
define('ARCHITECTURE', 'architecture');
define('CONSOLE', 'console');
define('MOBILE', 'mobile');
define('TABLET', 'tablet');
define('SMARTTV', 'smarttv');
define('WEARABLE', 'wearable');
define('EMBEDDED', 'embedded');


class MCommon_UserAgentParser {

    private function has($str1, $str2) {
        if (gettype($str1) == 'string' && gettype($str2) == 'string') {
            return strpos(strtolower($str2), strtolower($str1)) !== false;
        } else {
            return false;
        }
    }


    private function lowerize() {
        return (function ($str) {
            if (gettype($str) == 'string') {
                return strtolower($str);
            } else {
                return $str;
            }
        });
    }


    private function major($version) {
        return gettype($version) == 'string' ? explode('.', preg_replace("/[^\d\.]/", '', $version))[0] : '';
    }


    private function trim() {
        return (function ($str) {
            return preg_replace('/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/', '', $str);
        });
    }


    private function rgx(&$res, $ua, $arrays) {
        $i = 0;
        $j = 0;
        $k = 0;
        $matches = array();
        $match = 0;

        while ($i < count($arrays) && !$matches) {
            $regex = $arrays[$i];
            $props = $arrays[$i + 1];

            $j = 0;
            $k = 0;

            while ($j < count($regex) && !$matches) {
                preg_match($regex[$j++], $ua, $matches);

                if (count($matches)) {
                    for ($p = 0; $p < count($props); $p += 1) {
                        $match = $matches[++$k];
                        $q = $props[$p];

                        if (is_array($q) && count($q) > 0) {
                            if (count($q) == 2) {
                                if (gettype($q[1]) == 'object') {
                                    $res[$q[0]] = $q[1]($match);
                                } else {
                                    $res[$q[0]] = $q[1];
                                }
                            } else if (count($q) == 3) {
                                if (gettype($q[1]) == 'object') {
                                    $res[$q[0]] = $match ? $q[1]($match, $q[2]) : '';
                                } else {
                                    $res[$q[0]] = $match ? preg_replace($q[1], $q[2], $match) : '';
                                }
                            } else if (count($q) == 4) {
                                if (gettype($q[2]) == 'string' && gettype($q[3]) == 'string') {
                                    $res[$q[0]] = $match ? $q[3](preg_replace($q[1], $q[2], $q[3])) : '';
                                }
                            }
                        } else {
                            $res[$q] = $match ? $match : '';
                        }
                    }
                }
            }
            $i += 2;
        }
    }


    private function str() {
        return (function ($str, $map) {
            if (is_array($map)) {
                foreach ($map as $i => $v) {
                    if (is_array($map[$i]) && count($map[$i]) > 0) {
                        for ($j = 0; $j < count($map[$i]); $j += 1) {
                            if ($this->has($map[$i][$j], $str)) {
                                return ($i === UNKNOWN) ? '' : $i;
                            }
                        }
                    } else if ($this->has($map[$i], $str)) {
                        return ($i === UNKNOWN) ? '' : $i;
                    }
                }
            }
            return $str;
        });
    }


    private function maps() {
        return array(
            'browser' => array(
                'oldsafari' => array(
                    'version' => array(
                        '1.0' => '/8',
                        '1.2' => '/1',
                        '1.3' => '/3',
                        '2.0' => '/412',
                        '2.0.2' => '/416',
                        '2.0.3' => '/417',
                        '2.0.4' => '/419',
                        '?' => '/'
                    )
                )
            ),

            'device' => array(
                'amazon' => array(
                    'model' => array(
                        'Fire Phone' => ['SD', 'KF']
                    )
                ),
                'sprint' => array(
                    'model' => array(
                        'Evo Shift 4G' => '7373KT'
                    ),
                    'vendor' => array(
                        'HTC' => 'APA',
                        'Sprint' => 'Sprint'
                    )
                )
            ),

            'os' => array(
                'windows' => array(
                    'version' => array(
                        'ME' => '4.90',
                        'NT 3.11' => 'NT3.51',
                        'NT 4.0' => 'NT4.0',
                        '2000' => 'NT 5.0',
                        'XP' => ['NT 5.1', 'NT 5.2'],
                        'Vista' => 'NT 6.0',
                        '7' => 'NT 6.1',
                        '8' => 'NT 6.2',
                        '8.1' => 'NT 6.3',
                        '10' => ['NT 6.4', 'NT 10.0'],
                        'RT' => 'ARM'
                    )
                )
            )
        );
    }

    private function browser() {
        return [['/(sogoumobilebrowser|qihoobrowser|newsarticle|baidubrowser|weibo
            |sohunews|oppobrowser|samsungbrowser|vivobrowser|alipayclient|mxios|crios)\\/([\\w\\.]+)/i'],
            ['name', 'version'],
            ['/(sogousearch)[\\/\\w]+\\/([\\w\\.]+)/i'], ['name', 'version'],
            ['/(yidianzixun|qq_map_mobile)/i'], ['name'],
            ['/(opera\\smini)\\/([\\w\\.-]+)/i', '/(opera\\s[mobiletab]+).+version\\/([\\w\\.-]+)/i',
            '/(opera).+version\\/([\\w\\.]+)/i',
            '/(opera)[\\/\\s]+([\\w\\.]+)/i'], ['name', 'version'],
            ['/(opios)[\\/\\s]+([\\w\\.]+)/i'], [['name', 'Opera Mini'], 'version'],
            ['/\\s(opr)\\/([\\w\\.]+)/i'], [['name', 'Opera'], 'version'],
            ['/(kindle)\\/([\\w\\.]+)/i',
                '/(lunascape|maxthon|netfront|jasmine|blazer)[\\/\\s]?([\\w\\.]*)/i',
                '/(avant\\s|iemobile|slim|baidu)(?:browser)?[\\/\\s]?([\\w\\.]*)/i',
                '/(?:ms|\\()(ie)\\s([\\w\\.]+)/i',
                '/(rekonq)\\/([\\w\\.]*)/i',
                '/(chromium|flock|rockmelt|midori|epiphany|silk|skyfire|ovibrowser|bolt|iron|
        vivaldi|iridium|phantomjs|bowser|quark)\\/([\\w\\.-]+)/i'],
            ['name', 'version'],
            ['/(trident).+rv[:\\s]([\\w\\.]+).+like\\sgecko/i'], [['name', 'IE'], 'version'],
            ['/(edge|edgios|edga)\\/((\\d+)?[\\w\\.]+)/i'], [['name', 'Edge'], 'version'],
            ['/(yabrowser)\\/([\\w\\.]+)/i'], [['name', 'Yandex'], 'version'],
            ['/(puffin)\\/([\\w\\.]+)/i'], [['name', 'Puffin'], 'version'],
            ['/(focus)\\/([\\w\\.]+)/i'], [['name', 'Firefox Focus'], 'version'],
            ['/(opt)\\/([\\w\\.]+)/i'], [['name', 'Opera Touch'], 'version'],
            ['/((?:[\\s\\/])uc?\\s?browser|(?:juc.+)ucweb)[\\/\\s]?([\\w\\.]+)/i'], [['name', 'UCBrowser'], 'version'],
            ['/(comodo_dragon)\\/([\\w\\.]+)/i'], [['name', '/_/', ' '], 'version'],
            ['/(micromessenger)\\/([\\w\\.]+)/i'], [['name', 'WeChat'], 'version'],
            ['/(brave)\\/([\\w\\.]+)/i'], [['name', 'Brave'], 'version'],
            ['/(qqbrowserlite)\\/([\\w\\.]+)/i'], ['name', 'version'],
            ['/(QQ)\\/([\\d\\.]+)/i'], ['name', 'version'],
            ['/m?(qqbrowser)[\\/\\s]?([\\w\\.]+)/i'], ['name', 'version'],
            ['/(BIDUBrowser)[\\/\\s]?([\\w\\.]+)/i'], ['name', 'version'],
            ['/(2345Explorer)[\\/\\s]?([\\w\\.]+)/i'], ['name', 'version'],
            ['/(MetaSr)[\\/\\s]?([\\w\\.]+)/i'], ['name'],
            ['/(LBBROWSER)/i'], ['name'],
            ['/xiaomi\\/miuibrowser\\/([\\w\\.]+)/i'], ['version', ['name', 'MIUI Browser']],
            ['/;fbav\\/([\\w\\.]+);/i'],
            ['version', ['name', 'Facebook']],
            ['/safari\\s(line)\\/([\\w\\.]+)/i',
                '/android.+(line)\\/([\\w\\.]+)\\/iab/i'],
            ['name', 'version'],
            ['/headlesschrome(?:\\/([\\w\\.]+)|\\s)/i'],
            ['version', ['name', 'Chrome Headless']],
            ['/\\swv\\).+(chrome)\\/([\\w\\.]+)/i'],
            [['name', '/(.+)/', '$1 WebView'], 'version'],
            ['/((?:oculus|samsung)browser)\\/([\\w\\.]+)/i'],
            [['name', '/(.+(?:g|us))(.+)/', '$1 $2'], 'version'],
            ['/android.+version\\/([\\w\\.]+)\\s+(?:mobile\\s?safari|safari)*/i'],
            ['version', ['name', 'Android Browser']],
            ['/(chrome|omniweb|arora|[tizenoka]{5}\\s?browser)\\/v?([\\w\\.]+)/i'],
            ['name', 'version'],
            ['/(dolfin)\\/([\\w\\.]+)/i'],
            [['name', 'Dolphin'], 'version'],
            ['/((?:android.+)crmo|crios)\\/([\\w\\.]+)/i'],
            [['name', 'Chrome'], 'version'],
            ['/(coast)\\/([\\w\\.]+)/i'],
            [['name', 'Opera Coast'], 'version'],
            ['/fxios\\/([\\w\\.-]+)/i'],
            ['version', ['name', 'Firefox']],
            ['/version\\/([\\w\\.]+).+?mobile\\/\\w+\\s(safari)/i'],
            ['version', ['name', 'Mobile Safari']],
            ['/version\\/([\\w\\.]+).+?(mobile\\s?safari|safari)/i'],
            ['version', 'name'],
            ['/webkit.+?(gsa)\\/([\\w\\.]+).+?(mobile\\s?safari|safari)(\\/[\\w\\.]+)/i'],
            [['name', 'GSA'], 'version'],
            ['/webkit.+?(mobile\\s?safari|safari)(\\/[\\w\\.]+)/i'],
            ['name', ['version', $this->str(), $this->maps()['browser']['oldsafari']['version']]],
            ['/(konqueror)\\/([\\w\\.]+)/i',
                '/(webkit|khtml)\\/([\\w\\.]+)/i'],
            ['name', 'version'],
            ['/(navigator|netscape)\\/([\\w\\.-]+)/i'],
            [['name', 'Netscape'], 'version'],
            ['/(swiftfox)/i',
'/(icedragon|iceweasel|camino|chimera|fennec|maemo\\sbrowser|minimo|conkeror)[\\/\\s]?([\\w\\.\\+]+)/i',
'/(firefox|seamonkey|k-meleon|icecat|iceape|firebird|phoenix|palemoon|basilisk|waterfox)\\/([\\w\\.-]+)$/i',
                '/(mozilla)\\/([\\w\\.]+).+rv\\:.+gecko\\/\\d+/i',
                '/(polaris|lynx|dillo|icab|doris|amaya|w3m|netsurf|sleipnir)[\\/\\s]?([\\w\\.]+)/i',
                '/(links)\\s\\(([\\w\\.]+)/i',
                '/(gobrowser)\\/?([\\w\\.]*)/i',
                '/(ice\\s?browser)\\/v?([\\w\\._]+)/i',
                '/(mosaic)[\\/\\s]([\\w\\.]+)/i'],
            ['name', 'version']];
    }

    private function cpu() {
        return [['/(?:(amd|x(?:(?:86|64)[_-])?|wow|win)64)[;\\)]/i'],
            [['architecture', 'amd64']],
            ['/(ia32(?=;))/i'],
            [['architecture', $this->lowerize()]],
            ['/((?:i[346]|x)86)[;\\)]/i'],
            [['architecture', 'ia32']],
            ['/windows\\s(ce|mobile);\\sppc;/i'],
            [['architecture', 'arm']],
            ['/((?:ppc|powerpc)(?:64)?)(?:\\smac|;|\\))/i'],
            [['architecture', '/ower/', '', $this->lowerize()]],
            ['/(sun4\\w)[;\\)]/i'],
            [['architecture', 'sparc']],
            ['/((?:avr32|ia64(?=;))|68k(?=\\))|arm(?:64|(?=v\\d+[;l]))|(?=atmel\\s)avr|(
    ?:irix|mips|sparc)(?:64)?(?=;)|pa-risc)/i'],
            [['architecture', $this->lowerize()]]];
    }

    private function device_1() {
        return [['/\\((ipad|playbook);[\\w\\s\\);-]+(rim|apple)/i'],
            ['model', 'vendor', ['type', 'tablet']],
            ["/applecoremedia\\/[\\w\\.]+ \\((ipad)/"],
            ['model', ['vendor', 'Apple'], ['type', 'tablet']],
            ['/(apple\\s{0,1}tv)/i'],
            [['model', 'Apple TV'], ['vendor', 'Apple']],
            ['/(archos)\\s(gamepad2?)/i',
                '/(hp).+(touchpad)/i',
                '/(hp).+(tablet)/i',
                '/(kindle)\\/([\\w\\.]+)/i',
                '/\\s(nook)[\\w\\s]+build\\/(\\w+)/i',
                '/(dell)\\s(strea[kpr\\s\\d]*[\\dko])/i'],
            ['vendor', 'model', ['type', 'tablet']],
            ['/(kf[A-z]+)\\sbuild\\/.+silk\\//i'],
            ['model', ['vendor', 'Amazon'], ['type', 'tablet']],
            ['/(sd|kf)[0349hijorstuw]+\\sbuild\\/.+silk\\//i'],
            [['model', $this->str(), $this->maps()['device']['amazon']['model']],
                ['vendor', 'Amazon'],
                ['type', 'mobile']],
            ['/android.+aft([bms])\\sbuild/i'],
            ['model', ['vendor', 'Amazon'], ['type', 'smarttv']],
            ['/\\((ip[honed|\\s\\w*]+);.+(apple)/i'],
            ['model', 'vendor', ['type', 'mobile']],
            ['/\\((ip[honed|\\s\\w*]+);/i'],
            ['model', ['vendor', 'Apple'], ['type', 'mobile']],
            ['/(blackberry)[\\s-]?(\\w+)/i',
'/(blackberry|benq|palm(?=\\-)|sonyericsson|acer|asus|dell|meizu|motorola|polytron)[\\s_-]?([\\w-]*)/i',
                '/(hp)\\s([\\w\\s]+\\w)/i',
                '/(asus)-?(\\w+)/i'],
            ['vendor', 'model', ['type', 'mobile']],
            ['/\\(bb10;\\s(\\w+)/i'],
            ['model', ['vendor', 'BlackBerry'], ['type', 'mobile']],
            ['/android.+(transfo[prime\\s]{4,10}\\s\\w+|eeepc|slider\\s\\w+|nexus 7|padfone)/i'],
            ['model', ['vendor', 'Asus'], ['type', 'tablet']],
            ['/(sony)\\s(tablet\\s[ps])\\sbuild\\//i',
                '/(sony)?(?:sgp.+)\\sbuild\\//i'],
            [['vendor', 'Sony'],
                ['model', 'Xperia Tablet'],
                ['type', 'tablet']],
            ['/android.+\\s([c-g]\\d{4}|so[-l]\\w+)\\sbuild\\//i'],
            ['model', ['vendor', 'Sony'], ['type', 'mobile']],

            ['/\\s(ouya)\\s/i', '/(nintendo)\\s([wids3u]+)/i'],
            ['vendor', 'model', ['type', 'console']],
            ['/android.+;\\s(shield)\\sbuild/i'],
            ['model', ['vendor', 'Nvidia'], ['type', 'console']],
            ['/(playstation\\s[34portablevi]+)/i'],
            ['model', ['vendor', 'Sony'], ['type', 'console']],
            ['/(sprint\\s(\\w+))/i'],
            [['vendor', $this->str(), $this->maps()['device']['sprint']['vendor']],
                ['model', $this->str(), $this->maps()['device']['sprint']['vendor']],
                ['type', 'mobile']],
            ['/(lenovo)\\s?(S(?:5000|6000)+(?:[-][\\w+]))/i'],
            ['vendor', 'model', ['type', 'tablet']],
            ['/(htc)[;_\\s-]+([\\w\\s]+(?=\\))|\\w+)*/i',
                '/(zte)-(\\w*)/i',
                '/(alcatel|geeksphone|lenovo|nexian|panasonic|(?=;\\s)sony)[_\\s-]?([\\w-]*)/i'],
            ['vendor', ['model', '/_/', ' '], ['type', 'mobile']],
            ['/(nexus\\s9)/i'],
            ['model', ['vendor', 'HTC'], ['type', 'tablet']],
            ['/d\\/huawei([\\w\\s-]+)[;\\)]/i', '/(nexus\\s6p)/i'],
            ['model', ['vendor', 'Huawei'], ['type', 'mobile']],
            ['/(microsoft);\\s(lumia[\\s\\w]+)/i'],
            ['vendor', 'model', ['type', 'mobile']],
            ['/[\\s\\(;](xbox(?:\\sone)?)[\\s\\);]/i'],
            ['model', ['vendor', 'Microsoft'], ['type', 'console']],
            ['/(kin\\.[onetw]{3})/i'],
            [['model', '/\\./', ' '],
                ['vendor', 'Microsoft'],
                ['type', 'mobile']],
            ['/\\s(milestone|droid(?:[2-4x]|\\s(?:bionic|x2|pro|razr))?:?(\\s4g)?)[\\w\\s]+build\\//i',
                '/mot[\\s-]?(\\w*)/i',
                '/(XT\\d{3,4}) build\\//i',
                '/(nexus\\s6)/i'],
            ['model', ['vendor', 'Motorola'], ['type', 'mobile']],
            ['/android.+\\s(mz60\\d|xoom[\\s2]{0,2})\\sbuild\\//i'],
            ['model', ['vendor', 'Motorola'], ['type', 'tablet']],
            ['/hbbtv\\/\\d+\\.\\d+\\.\\d+\\s+\\([\\w\\s]*;\\s*(\\w[^;]*);([^;]*)/i'],
            [['vendor', $this->trim()],
                ['model', $this->trim()],
                ['type', 'smarttv']],
            ['/hbbtv.+maple;(\\d+)/i'],
            [['model', '/^/', 'SmartTV'],
                ['vendor', 'Samsung'],
                ['type', 'smarttv']],
            ['/\\(dtv[\\);].+(aquos)/i'],
            ['model', ['vendor', 'Sharp'], ['type', 'smarttv']],
            ['/android.+((sch-i[89]0\\d|shw-m380s|gt-p\\d{4}|gt-n\\d+|sgh-t8[56]9|nexus 10))/i', '/((SM-T\\w+))/i'],
            [['vendor', 'Samsung'], 'model', ['type', 'tablet']],
            ['/smart-tv.+(samsung)/i'],
            ['vendor', ['type', 'smarttv'], 'model'],
            ['/((s[cgp]h-\\w+|gt-\\w+|galaxy\\snexus|sm-\\w[\\w\\d]+))/i',
                '/(sam[sung]*)[\\s-]*(\\w+-?[\\w-]*)/i', '/sec-((sgh\\w+))/i'],
            [['vendor', 'Samsung'], 'model', ['type', 'mobile']],
            ['/sie-(\\w*)/i'],
            ['model', ['vendor', 'Siemens'], ['type', 'mobile']],
            ['/(maemo|nokia).*(n900|lumia\\s\\d+)/i', '/(nokia)[\\s_-]?([\\w-]*)/i'],
            [['vendor', 'Nokia'], 'model', ['type', 'mobile']],
            ['/android\\s3\\.[\\s\\w;-]{10}(a\\d{3})/i']];
    }

    private function device_2() {
        return [['model', ['vendor', 'Acer'], ['type', 'tablet']],
            ['/android.+([vl]k\\-?\\d{3})\\s+build/i'],
            ['model', ['vendor', 'LG'], ['type', 'tablet']],
            ['/android\\s3\\.[\\s\\w;-]{10}(lg?)-([06cv9]{3,4})/i'],
            [['vendor', 'LG'], 'model', ['type', 'tablet']],
            ['/(lg) netcast\\.tv/i'],
            ['vendor', 'model', ['type', 'smarttv']],
            ['/(nexus\\s[45])/i', '/lg[e;\\s\\/-]+(\\w*)/i', '/android.+lg(\\-?[\\d\\w]+)\\s+build/i'],
            ['model', ['vendor', 'LG'], ['type', 'mobile']],
            ['/android.+(ideatab[a-z0-9\\-\\s]+)/i'],
            ['model', ['vendor', 'Lenovo'], ['type', 'tablet']],
            ['/linux;.+((jolla));/i'],
            ['vendor', 'model', ['type', 'mobile']],
            ['/((pebble))app\\/[\\d\\.]+\\s/i'],
            ['vendor', 'model', ['type', 'wearable']],
            ['/android.+;\\s(oppo)\\s?([\\w\\s]+)\\sbuild/i'],
            ['vendor', 'model', ['type', 'mobile']],
            ['/crkey/i'],
            [['model', 'Chromecast'], ['vendor', 'Google']],
            ['/android.+;\\s(glass)\\s\\d/i'],
            ['model', ['vendor', 'Google'], ['type', 'wearable']],
            ['/android.+;\\s(pixel c)[\\s)]/i'],
            ['model', ['vendor', 'Google'], ['type', 'tablet']],
            ['/android.+;\\s(pixel( [23])?( xl)?)\\s/i'],
            ['model', ['vendor', 'Google'], ['type', 'mobile']],
            ['/android.+;\\s(\\w+)\\s+build\\/hm\\1/i',
                '/android.+(hm[\\s\\-_]*note?[\\s_]*(?:\\d\\w)?)\\s+build/i',
'/android.+(mi[\\s\\-_]*(?:one|one[\\s_]plus|note lte)?[\\s_]*(?:\\d?\\w?)[\\s_]*(?:plus)?)\\s+build/i',
                '/android.+(redmi[\\s\\-_]*(?:note)?(?:[\\s_]*[\\w\\s]+))\\s+build/i'],
            [['model', '/_/', ' '],
                ['vendor', 'Xiaomi'],
                ['type', 'mobile']],
            ['/android.+(mi[\\s\\-_]*(?:pad)(?:[\\s_]*[\\w\\s]+))\\s+build/i'],
            [['model', '/_/', ' '],
                ['vendor', 'Xiaomi'],
                ['type', 'tablet']],
            ['/android.+;\\s(m[1-5]\\snote)\\sbuild/i'],
            ['model', ['vendor', 'Meizu'], ['type', 'tablet']],
            ['/(mz)-([\\w-]{2,})/i'],
            [['vendor', 'Meizu'], 'model', ['type', 'mobile']],
            ['/android.+a000(1)\\s+build/i', '/android.+oneplus\\s(a\\d{4})\\s+build/i'],
            ['model', ['vendor', 'OnePlus'], ['type', 'mobile']],
            ['/android.+[;\\/]\\s*(RCT[\\d\\w]+)\\s+build/i'],
            ['model', ['vendor', 'RCA'], ['type', 'tablet']],
            ['/android.+[;\\/\\s]+(Venue[\\d\\s]{2,7})\\s+build/i'],
            ['model', ['vendor', 'Dell'], ['type', 'tablet']],
            ['/android.+[;\\/]\\s*(Q[T|M][\\d\\w]+)\\s+build/i'],
            ['model', ['vendor', 'Verizon'], ['type', 'tablet']],
            ['/android.+[;\\/]\\s+(Barnes[&\\s]+Noble\\s+|BN[RT])(V?.*)\\s+build/i'],
            [['vendor', 'Barnes & Noble'], 'model', ['type', 'tablet']],
            ['/android.+[;\\/]\\s+(TM\\d{3}.*\\b)\\s+build/i'],
            ['model', ['vendor', 'NuVision'], ['type', 'tablet']],
            ['/android.+;\\s(k88)\\sbuild/i'],
            ['model', ['vendor', 'ZTE'], ['type', 'tablet']],
            ['/android.+[;\\/]\\s*(gen\\d{3})\\s+build.*49h/i'],
            ['model', ['vendor', 'Swiss'], ['type', 'mobile']],
            ['/android.+[;\\/]\\s*(zur\\d{3})\\s+build/i'],
            ['model', ['vendor', 'Swiss'], ['type', 'tablet']],
            ['/android.+[;\\/]\\s*((Zeki)?TB.*\\b)\\s+build/i'],
            ['model', ['vendor', 'Zeki'], ['type', 'tablet']],
            ['/(android).+[;\\/]\\s+([YR]\\d{2})\\s+build/i',
                '/android.+[;\\/]\\s+(Dragon[\\-\\s]+Touch\\s+|DT)(\\w{5})\\sbuild/i'],
            [['vendor', 'Dragon Touch'], 'model', ['type', 'tablet']],
            ['/android.+[;\\/]\\s*(NS-?\\w{0,9})\\sbuild/i'],
            ['model', ['vendor', 'Insignia'], ['type', 'tablet']],
            ['/android.+[;\\/]\\s*((NX|Next)-?\\w{0,9})\\s+build/i'],
            ['model', ['vendor', 'NextBook'], ['type', 'tablet']],
            ['/android.+[;\\/]\\s*(Xtreme\\_)?(V(1[045]|2[015]|30|40|60|7[05]|90))\\s+build/i'],
            [['vendor', 'Voice'], 'model', ['type', 'mobile']],
            ['/android.+[;\\/]\\s*(LVTEL\\-)?(V1[12])\\s+build/i'],
            [['vendor', 'LvTel'], 'model', ['type', 'mobile']],
            ['/android.+;\\s(PH-1)\\s/i'],
            ['model', ['vendor', 'Essential'], ['type', 'mobile']],
            ['/android.+[;\\/]\\s*(V(100MD|700NA|7011|917G).*\\b)\\s+build/i'],
            ['model', ['vendor', 'Envizen'], ['type', 'tablet']],
            ['/android.+[;\\/]\\s*(Le[\\s\\-]+Pan)[\\s\\-]+(\\w{1,9})\\s+build/i'],
            ['vendor', 'model', ['type', 'tablet']],
            ['/android.+[;\\/]\\s*(Trio[\\s\\-]*.*)\\s+build/i'],
            ['model', ['vendor', 'MachSpeed'], ['type', 'tablet']],
            ['/android.+[;\\/]\\s*(Trinity)[\\-\\s]*(T\\d{3})\\s+build/i'],
            ['vendor', 'model', ['type', 'tablet']],
            ['/android.+[;\\/]\\s*TU_(1491)\\s+build/i'],
            ['model', ['vendor', 'Rotor'], ['type', 'tablet']],
            ['/android.+(KS(.+))\\s+build/i'],
            ['model', ['vendor', 'Amazon'], ['type', 'tablet']],
            ['/android.+(Gigaset)[\\s\\-]+(Q\\w{1,9})\\s+build/i'],
            ['vendor', 'model', ['type', 'tablet']],
            ['/\\s(tablet|tab)[;\\/]/i', '/\\s(mobile)(?:[;\\/]|\\ssafari)/i'],
            [['type', $this->lowerize()], 'vendor', 'model'],
            ['/(android[\\w\\.\\s\\-]{0,9});.+build/i'],
            ['model', ['vendor', 'Generic']]
        ];
    }

    private function device() {
        return array_merge($this->device_1(), $this->device_2());
    }

    private function engine() {
        return [['/windows.+\\sedge\\/([\\w\\.]+)/i'],
            ['version', ['name', 'EdgeHTML']],
            ['/(presto)\\/([\\w\\.]+)/i',
                '/(webkit|trident|netfront|netsurf|amaya|lynx|w3m)\\/([\\w\\.]+)/i',
                '/(khtml|tasman|links)[\\/\\s]\\(?([\\w\\.]+)/i',
                '/(icab)[\\/\\s]([23]\\.[\\d\\.]+)/i'],
            ['name', 'version'],
            ['/rv\\:([\\w\\.]{1,9}).+(gecko)/i'],
            ['version', 'name']
        ];
    }

    private function os() {
        return [['/microsoft\\s(windows)\\s(vista|xp)/i'],
            ['name', 'version'],
            ['/(windows)\\snt\\s6\\.2;\\s(arm)/i',
                '/(windows\\sphone(?:\\sos)*)[\\s\\/]?([\\d\\.\\s\\w]*)/i',
                '/(windows\\smobile|windows)[\\s\\/]?([ntce\\d\\.\\s]+\\w)/i'],
            ['name', ['version', $this->str(), $this->maps()['os']['windows']['version']]],
            ['/(win(?=3|9|n)|win\\s9x\\s)([nt\\d\\.]+)/i'],
            [['name', 'Windows'],
                ['version', $this->str(), $this->maps()['os']['windows']['version']]],
            ['/\\((bb)(10);/i'],
            [['name', 'BlackBerry'], 'version'],
            ['/(blackberry)\\w*\\/?([\\w\\.]*)/i',
                '/(tizen)[\\/\\s]([\\w\\.]+)/i',
                '/(android|webos|palm\\sos|qnx|bada|rim\\stablet\\sos|meego|contiki)[\\/\\s-]?([\\w\\.]*)/i',
                '/linux;.+(sailfish);/i'],
            ['name', 'version'],
            ['/(symbian\\s?os|symbos|s60(?=;))[\\/\\s-]?([\\w\\.]*)/i'],
            [['name', 'Symbian'], 'version'],
            ['/\\((series40);/i'],
            ['name'],
            ['/mozilla.+\\(mobile;.+gecko.+firefox/i'],
            [['name', 'Firefox OS'], 'version'],
            ['/(nintendo|playstation)\\s([wids34portablevu]+)/i',
                '/(mint)[\\/\\s\\(]?(\\w*)/i',
                '/(mageia|vectorlinux)[;\\s]/i',
                '/(joli|[kxln]?ubuntu|debian|suse|opensuse|gentoo|(?=\\s)arch|slackware|fedora|mandriva|centos|
      pclinuxos|redhat|zenwalk|linpus)[\\/\\s-]?(?!chrom)([\\w\\.-]*)/i',
                '/(hurd|linux)\\s?([\\w\\.]*)/i',
                '/(gnu)\\s?([\\w\\.]*)/i'],
            ['name', 'version'],
            ['/(cros)\\s[\\w]+\\s([\\w\\.]+\\w)/i'],
            [['name', 'Chromium OS'], 'version'],
            ['/(sunos)\\s?([\\w\\.\\d]*)/i'],
            [['name', 'Solaris'], 'version'],
            ['/\\s([frentopc-]{0,4}bsd|dragonfly)\\s?([\\w\\.]*)/i'],
            ['name', 'version'],
            ['/(haiku)\\s(\\w+)/i'],
            ['name', 'version'],
            ['/cfnetwork\\/.+darwin/i',
                '/ip[honead]{2,4}(?:.*os\\s([\\w]+)\\slike\\smac|;\\sopera)/i'],
            [['version', '/_/', '.'], ['name', 'iOS']],
            ['/(mac\\sos\\sx)\\s?([\\w\\s\\.]*)/i',
                '/(macintosh|mac(?=_powerpc)\\s)/i'],
            [['name', 'Mac OS'], ['version', '/_/', '.']],
            ['/((?:open)?solaris)[\\/\\s-]?([\\w\\.]*)/i',
                '/(aix)\\s((\\d)(?=\\.|\\)|\\s)[\\w\\.])*/i',
                '/(plan\\s9|minix|beos|os\\/2|amigaos|morphos|risc\\sos|openvms|fuchsia)/i',
                '/(unix)\\s?([\\w\\.]*)/i'],
            ['name', 'version']];
    }

    private function regexes() {
        return array(
            'browser' => $this->browser(),
            'cpu' => $this->cpu(),
            'device' => $this->device(),
            'engine' => $this->engine(),
            'os' => $this->os()
        );
    }

    private function UAParser($ua) {
        $rgxmap = $this->regexes();

        $browser = array(
            'name' => '',
            'version' => ''
        );
        $this->rgx($browser, $ua, $rgxmap['browser']);
        $browser['major'] = $this->major($browser['version']);


        $cpu = array(
            'architecture' => ''
        );
        $this->rgx($cpu, $ua, $rgxmap['cpu']);


        $device = array(
            'vendor' => '',
            'model' => '',
            'type' => ''
        );
        $this->rgx($device, $ua, $rgxmap['device']);


        $engine = array(
            'name' => '',
            'version' => ''
        );
        $this->rgx($engine, $ua, $rgxmap['engine']);


        $os = array(
            'name' => '',
            'version' => ''
        );
        $this->rgx($os, $ua, $rgxmap['os']);

        return array(
            'browser' => $browser,
            'engine' => $engine,
            'os' => $os,
            'device' => $device,
            'cpu' => $cpu
        );
    }

    public function mfwUAParser($ua) {
        $parse = $this->UAParser($ua);

        $res = array(
            'sys' => $parse['os']['name'],
            'sys_ver' => $parse['os']['version'],
            'browser' => $parse['browser']['name'],
            'browser_major' => $parse['browser']['major'],
            'browser_ver' => $parse['browser']['version'],
            'brand' => $parse['device']['vendor'],
            'hardware_model' => $parse['device']['model'],
            'kernel' => $parse['engine']['name'],
            'kernel_ver' => $parse['engine']['version'],
            'device_type' => $parse['device']['type']
        );

        return $res;
    }
}