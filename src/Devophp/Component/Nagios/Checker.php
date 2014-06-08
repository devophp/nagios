<?php

namespace Devophp\Component\Nagios;

use Devophp\Component\Nagios\CheckResponse;
use RuntimeException;

class Checker
{
    private $pluginpath = null;
    
    public function setPluginPath($path)
    {
        if (!file_exists($path)) {
            throw new RuntimeException("Pluginpath does not exist: " . $path);
        }
        $this->pluginpath = $path;
    }
    
    public function getPluginPath()
    {
        return $this->pluginpath;
    }
    
    public function autoDetectPluginPath()
    {
        // try common plugin path locations:
        try {
            // default location
            $this->setPluginPath('/usr/local/nagios/libexec/');
            return true;
        } catch (RuntimeException $e) {
            // directory does not exist
        }
        
        try {
            // Mac OS X / homebrew
            $this->setPluginPath('/usr/local/Cellar/nagios-plugins/2.0/sbin/');
            return true;
        } catch (RuntimeException $e) {
            // directory does not exist
        }
        
        // None of the default locations were detected
        throw new RuntimeException("Can't autodetect plugin path.");
    }
    
    public function check($checkname, $arguments)
    {
        $cmd = $this->pluginpath . 'check_' . $checkname;
        if (!file_exists($cmd)) {
            throw new RuntimeException("Nagios check plugin file does not exist: $cmd");
        }
        
        $res = exec($cmd . ' ' . $arguments, $lines, $code);
        $text = implode("\n", $lines);
        
        $response = new CheckResponse($code, $text);
        return $response;
    }
}
