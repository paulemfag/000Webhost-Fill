<?php
$regexGmail = '/^(.)+(@)+(gmail\.com)$/';
$regexYahoo = '/^(.)+(@)+(yahoo\.com)$/';
$regexYahooFr = '/^(.)+(@)+(yahoo\.fr)$/';
$regexOutlook = '/^(.)+(@)+(outlook\.com)$/';
$regexOutlookFr = '/^(.)+(@)+(outlook\.fr)$/';
$regexLive = '/^(.)+(@)+(live\.fr)$/';
$regexHotmail = '/^(.)+(@)+(hotmail\.fr)$/';

//Vérification du type d'adresse mail

//si c'est une adresse gmail
if (preg_match($regexGmail, $mailbox)) {
    $mailhref = 'https://mail.google.com';
    $hrefTitle = 'Gmail';
} //si c'est une adresse yahoo
elseif (preg_match($regexYahoo, $mailbox) || preg_match($regexYahooFr, $mailbox)) {
    $mailhref = 'https://mail.yahoo.com';
    $hrefTitle = 'Yahoo';
} //si c'est une adresse outlook ou live
elseif (preg_match($regexOutlook, $mailbox) || preg_match($regexLive, $mailbox) || preg_match($regexOutlookFr, $mailbox)) {
    $mailhref = 'https://office.live.com/start/Outlook.aspx?ui=fr%2DFR&rs=FR';
    $hrefTitle = 'Outlook';
} //si c'est une adresse hotmail
elseif (preg_match($regexHotmail, $mailbox) || preg_match($regexLive, $mailbox)) {
    $hrefTitle = 'Hotmail';
    $mailhref = 'https://signup.live.com/signup.aspx?id=64855&mkt=fr-fr&lic=1';
}
