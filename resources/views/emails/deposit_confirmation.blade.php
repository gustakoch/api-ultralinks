<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Depósito</title>
</head>
<body>
    <h1>Confirmação de Depósito</h1>
    <p>Olá {{ $fullname }}</p>
    <p>Seu depósito foi recebido com sucesso!</p>
    <p>Detalhes do depósito:</p>
    <ul>
        <li><strong>Valor:</strong> R$ {{ $amount }}</li>
        <li><strong>Código de Autorização:</strong> {{ $authorizationCode }}</li>
    </ul>
    <p>Obrigado por utilizar nosso serviço.</p>
</body>
</html>
