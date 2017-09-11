<?php

include('ganon.php');

$usdUrl = 'https://www.bitbaba.xyz/wp-content/themes/bitbaba/coinvertor/btcmarkets.php?base=BTC&quote=all&convert=USD&sort=price';
$tryUrl = 'https://www.bitbaba.xyz/wp-content/themes/bitbaba/coinvertor/btcmarkets.php?base=BTC&quote=all&convert=TRY&sort=price';


//<editor-fold desc="crawl USD data">
unlink('test_input.html');
$urlDwn = file_get_contents($usdUrl);

print_r($urlDwn);

file_put_contents('test_input.html', $urlDwn);
$html = file_get_dom('test_input.html');
$finalArrUSD = array();
foreach ($html('.bitmarkets tr') as $tr) {
    $temp = array();
    $i = 0;
    foreach ($tr('th') as $td) {
        switch ($i) {
            case 0:
                $key = 'exchange';
                break;
            case 1:
                $key = 'temel';
                break;
            case 2:
                $key = 'buing';
                break;
            case 3:
                $key = 'selling';
                break;
            case 4:
                $key = 'price';
                break;
            case 5:
                $key = 'volume';
                break;

        }
        $i++;
        $temp[$key] = $td->getPlainText();

    }

    array_push($finalArrUSD, (object)$temp);
}
//</editor-fold>

//<editor-fold desc="crawl TRY data">
unlink('test_input.html');
$urlDwn = file_get_contents($tryUrl);
file_put_contents('test_input.html', $urlDwn);
$html = file_get_dom('test_input.html');
$finalArrTRY = array();
foreach ($html('.bitmarkets tr') as $tr) {
    $temp = array();
    $i = 0;
    foreach ($tr('th') as $td) {
        switch ($i) {
            case 0:
                $key = 'exchange';
                break;
            case 1:
                $key = 'temel';
                break;
            case 2:
                $key = 'buing';
                break;
            case 3:
                $key = 'selling';
                break;
            case 4:
                $key = 'price';
                break;
            case 5:
                $key = 'volume';
                break;

        }
        $i++;
        $temp[$key] = $td->getPlainText();
    }
    array_push($finalArrTRY, (object)$temp);
}
//</editor-fold>

$outPut = array();
foreach ($finalArrTRY as $finTry) {

    $t = new stdClass();

    $t->exchange = $finTry->exchange;
    $t->priceTry = $finTry->price;
    $t->volumeTry = $finTry->volume;

    foreach ($finalArrUSD as $finUsd) {
        if ($finUsd->exchange == $finTry->exchange && $finUsd->temel == $finTry->temel) {
            $t->pricesUsd = $finUsd->price;
            $t->volumeUsd = $finUsd->volume;
            $t->temel = $finUsd->temel;
        }
    }

    array_push($outPut, $t);

}


print_r($outPut);


// XBTCE Crawl

$json = file_get_contents('http://195.142.108.105/xbtce'');
$obj = json_decode($json);


$t = new stdClass();

$formatter = new NumberFormatter('tr_TR', NumberFormatter::DEFAULT_STYLE);
$formatter->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2);

$t->exchange = 'XBTCE';
$t->priceTry = $formatter->format($obj->price*3.53);
$t->volumeTry = 0;

// $t->volumeTry = $formatter->format(intval($obj->volume * 3.53));


$t->pricesUsd = $formatter->format($obj->price);
$t->volumeUsd = 0;

array_push($outPut, $t);


// XBTCE Crawl


$new_array = array_filter($outPut, function ($obj) {
    $filterExchanges = array("BITFINEX", "BTCTURK", "BITSTAMP", "PARIBU","POLONIEX", "KOINIM", "CEXIO", "BTCE" , "XBTCE");
    if (in_array(strtoupper($obj->exchange), $filterExchanges)) {
        return true;
    }
    return false;
});

$new_array = array_filter($new_array, function ($obj) {
    $filterExchanges = array("BITSTAMP", "CEXIO", "BTCE");
    if (in_array(strtoupper($obj->exchange), $filterExchanges) && strtoupper($obj->temel) != 'USD') {
        return false;
    }
    return true;
});

$outPut = array();
foreach ($new_array as $x) {
    $t = explode(',', $x->priceTry);
    $r = (float)$t[0];
    $x->sortPrice = $r;

    array_push($outPut, $x);
}

echo(json_encode($outPut));


