<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Resutado</title>
</head>
<body>
    <div>
        <?php
            $real = $_POST['cart'] ?? 0;
            $inicio = date("m-d-Y", strtotime("-7 days"));
            $fim = date("m-d-Y");
            $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''.$inicio.'\'&@dataFinalCotacao=\''.$fim.'\'&$top=100&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,cotacaoVenda,dataHoraCotacao';
            $dados = json_decode(file_get_contents($url), true);
            $cotacao = $dados["value"][0]["cotacaoCompra"];
            $urlEuro = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoMoedaPeriodo(moeda=@moeda,dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@moeda=\'EUR\'&@dataInicial=\''.$inicio.'\'&@dataFinalCotacao=\''.$fim.'\'&$top=100&$orderby=cotacaoVenda%20desc&$format=json&$select=cotacaoCompra,cotacaoVenda,dataHoraCotacao,tipoBoletim';
            $dadosEuro = json_decode(file_get_contents($urlEuro), true);
            $cotacaoEuro = $dadosEuro["value"][0]["cotacaoCompra"];
            $euro = $real/$cotacaoEuro;
            $dolar = $real/$cotacao;
            echo "O valor em reais é ".number_format($real, 2, ",", ".");
            echo "<p> Seus R\$" .number_format($real, 2, ",", ".")." equivalem a <strong>US\$" .number_format($dolar, 2, ",", ".").
            "</strong></p>";
            echo "<p> Seus R\$" .number_format($real, 2, ",", ".")." equivalem a <strong>EU\$" .number_format($euro, 2, ",", ".").
            "</strong></p>";
        ?>
        <br>
        <button id="butao" onclick="javascript:history.go(-1)">Voltar</button>
    </div>
</body>
</html>