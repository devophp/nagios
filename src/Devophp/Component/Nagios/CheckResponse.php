<?php

namespace Devophp\Component\Nagios;

use RuntimeException;

class CheckResponse
{
    private $statuscode;
    private $serviceoutput;
    private $serviceperfdata;
    
    
    public function getStatusCode()
    {
        return $this->statuscode;
    }
    
    public function getStatusText()
    {
        switch ($this->statuscode) {
            case 0:
                return 'OK';
                break;
            case 1:
                return 'Warning';
                break;
            case 2:
                return 'Critical';
                break;
            case 3:
                return 'Unknown';
                break;
            default:
                return 'Confused';
                break;
        }
    }
    
    private $output;
    public function getOutput()
    {
        return $this->output;
    }
    
    public function getServiceOutput()
    {
        return $this->serviceoutput;
    }
    
    public function getServicePerfData()
    {
        return $this->serviceperfdata;
    }
    
    public function __construct($statuscode, $output)
    {
        // Based on http://nagios.sourceforge.net/docs/3_0/pluginapi.html
        $this->statuscode = $statuscode;
        $this->output = $output;
        
        $lines = explode("\n", $output);
        // Simple one line statuscodes only
        if (count($lines)>1) {
            throw new RuntimeException("Multiline responses not yet supported");
        }
        
        $mainline=$lines[0];
        $part = explode("|", $mainline, 2); 
        $this->serviceoutput = trim($part[0]);
        $this->serviceperfdata = trim($part[1]);
    }
}
