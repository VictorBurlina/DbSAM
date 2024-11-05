<?php
session_start();

$servidor = 'localhost';
$banco = 'dbsam';  
$usuario = 'root';
$senha = '';

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    exit;
}

$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $leito = $_POST['leito'];

    try {
        $stmt = $pdo->prepare("INSERT INTO tblPaciente (nome, leito) VALUES (:nome, :leito)");
        $resultado = $stmt->execute([
            ':nome' => $nome,
            ':leito' => $leito
        ]);

        if ($resultado) {
            $mensagem = "Paciente cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar paciente.";
        }
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Paciente</title>
</head>
<body>
    <?php if (!empty($mensagem)): ?>
        <p style="color: red;"><?php echo $mensagem; ?></p>
    <?php endif; ?>
    
    <form action="" method="POST">
        <label>Nome do Paciente:</label>
        <input type="text" name="nome" required>
        <label>Leito:</label>
        <input type="text" name="leito" required>
        <button type="submit">Cadastrar Paciente</button>
    </form>
</body>
</html>