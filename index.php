<?php
    require './Browser.php'; // from https://github.com/cbschuld/Browser.php
    $browser = new Browser();

    if (($browser->getBrowser() == Browser::BROWSER_CHROME) ||
        ($browser->getBrowser() == Browser::BROWSER_OPERA && $browser->getVersion() >= 9.0) ||
        ($browser->getBrowser() == Browser::BROWSER_IE && $browser->getVersion() >= 6.0) ||
        ($browser->getBrowser() == Browser::BROWSER_FIREFOX && $browser->getVersion() >= 2.0) ||
        ($browser->getBrowser() == Browser::BROWSER_SAFARI && $browser->getVersion() >= 3.0)
        )
    {
        header('Location: http://www.seank.com/client/math');
    }
    else
    {
        header('Location: http://www.seank.com/server/math');    
    }
?>
