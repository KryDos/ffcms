<?php

namespace engine;


class antivirus extends singleton
{
    protected static $instance = null;
    // ('dir/dir2/file.ext' => md5_size())
    protected $scan_md5 = array();
    protected $version_md5 = array();
    // array(success, md5wrong, notfound, inject)
    protected $check = array();
    protected $excluded_directory = array();

    public static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function doFullScan($rescan = false)
    {
        if(!cache::getInstance()->get('antivirus_scan', 7200) || $rescan) {
            $this->loadVersionMd5List();
            $this->loadExcludedDirectory();
            $this->recursiveScanDir();
            // файл исходных контрольных сумм не скомпроментирован
            if (sizeof($this->version_md5) > 0) {
                foreach ($this->scan_md5 as $found_file => $md5_file) {
                    // TODO: in feture add .js scaner (probably - external project)
                    if (system::getInstance()->suffixEquals($found_file, '.php')
                        || system::getInstance()->suffixEquals($found_file, '.phtml')
                        || system::getInstance()->contains('.php', $found_file)) {
                        if ($this->version_md5[$found_file] == null) {
                            $this->check['notfound'][$found_file] = $md5_file;
                            if($this->containsHackMethods(@file_get_contents(root . '/' . $found_file)))
                                $this->check['inject'][$found_file] = $md5_file;
                        } elseif ($this->version_md5[$found_file] != $md5_file) {
                            $this->check['md5wrong'][$found_file] = $md5_file;
                            if($this->containsHackMethods(@file_get_contents(root . '/' . $found_file)))
                                $this->check['inject'][$found_file] = $md5_file;
                        } else {
                            $this->check['success'][$found_file] = $md5_file;
                        }
                    }
                }
            }
            cache::getInstance()->store('antivirus_scan', serialize($this->check));
            unset($this->scan_md5);
            unset($this->version_md5);
        } else {
            $this->check = unserialize(cache::getInstance()->get('antivirus_scan', 7200));
        }
    }

    private function loadExcludedDirectory()
    {
        if(file_exists(root."/cache/.antivir_exclude")) {
            $prepared_file = @file_get_contents(root."/cache/.antivir_exclude");
            $this->excluded_directory = unserialize($prepared_file);
        }
        $this->excluded_directory[] = 'cache';
    }

    public function getExcludedDirs() {
        if(file_exists(root . '/cache/.antivir_exclude')) {
            return unserialize(@file_get_contents(root . '/cache/.antivir_exclude'));
        }
        return array();
    }

    public function addExcludedDir($dir) {
        if(file_exists(root . '/' . $dir)) {
            $exc_array = unserialize(@file_get_contents(root . '/cache/.antivir_exclude'));
            $exc_array[] = $dir;
            @file_put_contents(root . '/cache/.antivir_exclude', serialize($exc_array));
            return true;
        }
        return false;
    }

    public function removeExcludedDir($dir) {
        $result = false;
        $exc_array = unserialize(@file_get_contents(root . '/cache/.antivir_exclude'));
        if(sizeof($exc_array) > 0) {
            foreach($exc_array as $key=>$value) {
                if($dir === $value) {
                    unset($exc_array[$key]);
                    $result = true;
                }
            }
        }
        @file_put_contents(root . '/cache/.antivir_exclude', serialize($exc_array));
        return $result;
    }

    private function recursiveScanDir($dir = null)
    {
        $dir_scan = null;
        if ($dir == null)
            $dir_scan = root . '/';
        else
            $dir_scan = root . '/' . $dir . '/';
        $objects = scandir($dir_scan);
        foreach ($objects as $item) {
            $md5sum = null;
            if (is_file($dir_scan . $item)) {
                $md5sum = md5_file($dir_scan . $item);
            } elseif (is_dir($dir_scan . $item)) {
                if (!system::getInstance()->prefixEquals($item, ".")) {
                    if ($dir == null)
                        self::recursiveScanDir($item);
                    else
                        self::recursiveScanDir($dir . '/' . $item);
                }
            }
            if ($md5sum != null) {
                $tmp_name = null;
                if($dir != null)
                    $tmp_name .= $dir . '/';
                $tmp_name .= $item;
                $is_excluded = false;
                foreach($this->excluded_directory as $excluded_start) {
                    if(system::getInstance()->prefixEquals($tmp_name, $excluded_start))
                        $is_excluded = true;
                }
                if(!$is_excluded)
                    $this->scan_md5[$tmp_name] = $md5sum;
            }
        }
    }

    private function loadVersionMd5List()
    {
        $md5file = root . "/resource/antivirus/.md5sum";
        if (file_exists($md5file)) {
            $this->version_md5 = unserialize(@file_get_contents($md5file));
        }
    }

    public function containsHackMethods($content)
    {
        if (preg_match('/eval\(|exec\(|passthru\(|shell_exec\(|system\(|proc_open\(|popen,curl_exec\(|curl_multi_exec\(|parse_ini_file\(|show_source\(|base64_/s', $content)) {
            return true;
        }
        return false;
    }

    public function getScanResult($type = null) {
        return $type === null ? $this->check : $this->check[$type];
    }
}
