<?php
/**
 * Build the setup options form.
 *
 * @package galleries
 * @subpackage build
 */

/* set some default values */

/* get values based on mode */
$output = '';
switch ($options[xPDOTransport::PACKAGE_ACTION])
{
    case xPDOTransport::ACTION_INSTALL:
        $output = 
            '<h2>Galleries Installer</h2>
            <p>Thanks for installing the Galleries Manager! Please review the setup options below before proceeding.</p><br />';
        break;
    case xPDOTransport::ACTION_UPGRADE:
        $output = 
            '<h2>Galleries Upgrade</h2>
            <p>The Galleries Manager will be upgraded! Please review the setup options below before proceeding.</p><br />';
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        $output = 
            '<h2>Galleries UnInstaller</h2>
            <p>Are you sure you want to uninstall the Galleries Manager.</p><br />';
        break;
        break;
}
return $output;
