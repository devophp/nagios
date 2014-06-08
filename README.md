# Nagios check component

This library lets you run Nagios checks and parse the output from your PHP application.

## Example:

    ```php
    $nagioschecker = new \Devophp\Component\Nagios\Checker();
    $nagioschecker->autoDetectPluginPath();
    
    $response = $nagioschecker->check('users', '-w 3 -c 5');

    echo "Statuscode: " . $response->getStatusCode() . ' (' . $response->getStatusText() . ')' . "\n";
    echo "ServiceOutput: " . $response->getServiceOutput() . "\n";
    echo "ServicePerfData: " . $response->getServicePerfData() . "\n";
    ```

## Included console tool

This library comes with a simple command line tool that you can use to run tests through this library.

Some example commands:

    bin/console nagios:check users --arguments="-w 3 -c 5"
    
This will output:

    Running check 'users' with arguments: '-w 3 -c 5'
    Pluginpath: /usr/local/Cellar/nagios-plugins/2.0/sbin/
    Statuscode: 0 (OK)
    ServiceOutput: USERS OK - 2 users currently logged in
    ServicePerfData: users=2;3;5;0
    
