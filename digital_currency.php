<?php

error_reporting(E_ALL);
header('Content-type: application/json');

function convertPersianToEnglish($number) {

    $result = str_replace(['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'], ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], $number);
    return $result;

}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://arzdigital.com/coins");
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36");
$curl_result = curl_exec($curl);
curl_close($curl);

preg_match_all("#data-faname='(.*?)' data-name='(.*?)' data-slug='(.*?)' data-symbol='(.*?)'><td#", $curl_result, $result_currency_1);
preg_match_all('#pulser-change="(.*?)">(.*?)</span>#', $curl_result, $result_currency_2);
preg_match_all('#<span class="(.*?)">(.*?)</span><span class="arz-toman arz-value-unit">#', $curl_result, $result_currency_3);

$name_persion = $result_currency_1[1];
$name_english = $result_currency_1[2];
$namad = $result_currency_1[4];
$dollar = $result_currency_2[2];           
$rep = str_replace('$', '', $dollar);
$toman = $result_currency_3[2];

for($i=0;$i<=count($dollar)-1;$i++){

    $list = [
        'name_persion' => $name_persion[$i],
        'name_english' => $name_english[$i],
        'grade' => $namad[$i],
        'p-toman' => convertPersianToEnglish($toman[$i]),
        'p-dolar' => $rep[$i]
    ];

    $results[] = $list;
}

echo json_encode(['ok' => true, 'github' => 'https://github.com/rezajafarian', 'results' => $results], 448);


