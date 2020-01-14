<?php
/**
 * Created by PhpStorm.
 * User: muling
 * Date: 17/4/25
 * Time: 上午10:59
 */

namespace apps\kafka;

include_once("/mfw_www/htdocs/global.php");

class MSend_Log_To_Kafka {

    /**
     * 入口
     */
    function main() {
        \apps\MFacade_Tool_lock::lock("batch2kafka");
        sleep(10);
        $time = time();

        //备份文件
        $this->backup($time);
    }

    /**
     * 备份并定期删除分钟文件
     * @param $time
     */
    private function backup($time) {
        $h = date('H', $time);
        $m = date('i', $time);

        foreach (MConf::$EventTypes as $eventType => $eventValue) {
            $this->__trace('BEGIN EVENT %s', $eventType);
            $dataDir = COMMON_RUNDATA_PATH . 'log/' . $eventType . '/';
            $branpubDataDir = DATA_DIR . 'log/share/' . $eventType . '/';
            $backupDir = DATA_DIR . 'log_backup/' . $eventType . '/';

            if ($eventValue['is_batch']) {
                $files = $this->getReadyBackUpFiles($dataDir, $time);

                foreach ($files as $file) {
                    $filePath = $dataDir . $file;
                    $backupPath = $this->getBackupPath($backupDir, $file);

                    $this->move($filePath, $backupPath);
                }

                $branpubFiles = $this->getReadyBackUpFiles($branpubDataDir, $time);
                foreach ($branpubFiles as $file) {
                    $filePath = $branpubDataDir . $file;
                    $backupPath = $this->getBackupPath($backupDir, $file);

                    $this->move($filePath, $backupPath);
                }
            }

            if ('04' == $h && '00' == $m) {
                $this->deleteTooOldBackup($backupDir, $eventValue['hdays']);
            }

            $this->__trace('END EVENT %s', $eventType);
            $this->__trace('');
        }
    }


    /**
     * 备份文件
     * @param $dataDir
     * @param $time
     * @return array
     */
    private function getReadyBackUpFiles($dataDir, $time) {
        $files = array();

        if (!file_exists($dataDir)) {
            $this->__trace('@_getReadyHistoryFiles: path is not exists: %s', $dataDir);
            return array();
        }

        $fd = opendir($dataDir);
        if (false === $fd) {
            $this->__trace('@_getReadyHistoryFiles: fail to open path: %s', $dataDir);
            return array();
        }

        while (($filename = readdir($fd)) !== false) {
            if ('.' === substr($filename, 0, 1)) {
                continue;
            }

            $fileDate = $this->getFilePathDate($filename);
            if ($this->verifyFile($fileDate, $time)) {
                $files[] = $filename;
            }
        }

        closedir($fd);

        sort($files); // 按时间点排序
        return $files;
    }

    private function verifyFile($fileDate, $time) {
        $result = false;
        $len = strlen($fileDate);

        if ($len == 10) {
            $result = $this->verifyHourFile($fileDate, $time);
        } else if ($len == 12) {
            $result = $this->verifyMinuteFile($fileDate, $time);
        }

        return $result;
    }

    /**
     * @param $fileDate string
     * @param $time int
     * @return bool
     */
    private function verifyHourFile($fileDate, $time) {
        $interval = 75 * 60; // 75分钟
        $stamp = strtotime($fileDate . '00');

        return $this->verify($stamp, $time, $interval);
    }

    private function verifyMinuteFile($fileDate, $time) {
        $interval = 15 * 60; // 15分钟
        $stamp = strtotime($fileDate);

        return $this->verify($stamp, $time, $interval);
    }

    private function verify($stamp, $time, $interval) {
        $result = false;
        $dayInterval = 24 * 60 * 60; // 1天
        if ($stamp != false) {
            $result = (($time - $interval) > $stamp) && (($time - $dayInterval) < $stamp);
        }

        return $result;
    }

    private function getBackupPath($rootPath, $filename) {
        $fileDate = $this->getFilePathDate($filename);

        $dayName = substr($fileDate, 0, 8);
        if ($dayName == false) {
            $dayName = "error_backup";
        }

        $backupDir = $rootPath . $dayName . '/';
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        return $backupDir . $filename;
    }

    private function getFilePathDate($filename) {
        $names = explode('.', $filename);
        return end($names);
    }


    /**
     * 备份文件
     * @param $oldname
     * @param $newname
     */
    private function move($oldname, $newname) {
        if (file_exists($newname)) {
            $newname = $newname . '_' . mt_rand();
        }
        $ret = rename($oldname, $newname);

        $this->__trace('MOVE_%s: %s to %s', $ret ? 'SUCC' : 'FAIL', $oldname, $newname);
    }

    /**
     * 删除旧文件
     * @param $backupDir
     * @param $historyDay
     */
    private function deleteTooOldBackup($backupDir, $historyDay) {
        if (!file_exists($backupDir)) {
            $this->__trace('@_deleteTooOldBackup: path is not exists: %s', $backupDir);
            return;
        }

        if (is_null($historyDay) || $historyDay < 0) {
            return;
        }

        $fd = opendir($backupDir);
        if (false === $fd) {
            $this->__trace('@_deleteTooOldBackup: fail to open path: %s', $backupDir);
            return;
        }


        $dayThreshold = date('Ymd', strtotime('-' . $historyDay . ' days'));
        while (($filename = readdir($fd)) !== false) {
            if ('.' === substr($filename, 0, 1)) {
                continue;
            }

            if (0 >= strcmp($filename, $dayThreshold)) {
                $cmd = 'rm -Rf ' . escapeshellarg($backupDir . $filename);
                $this->__trace('Drop too old Backup Path: %s', $cmd);
                exec($cmd, $output, $ret);
            }
        }

        closedir($fd);
    }

    /**
     * 日志调试
     * @param $textFormat
     */
    protected function __trace($textFormat /*$param*/) {
        $format = '[' . date('Y-m-d H:i:s') . '] [Trace] ' . $textFormat . "\n";
        $params = array_slice(func_get_args(), 1);
        echo vsprintf($format, $params);
    }

    /**
     * 错误日志
     * @param $textFormat
     */
    protected function __error($textFormat /*$param*/) {
        $format = '[' . date('Y-m-d H:i:s') . '] [Error] ' . $textFormat . "\n";
        $params = array_slice(func_get_args(), 1);
        echo vsprintf($format, $params);
    }

}

$app = new MSend_Log_To_Kafka();
$app->main();

