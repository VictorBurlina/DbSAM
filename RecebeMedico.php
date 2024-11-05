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
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $especialidade = $_POST['especialidade'];
    $crm = $_POST['crm'];

    try {
        $stmt = $pdo->prepare("INSERT INTO tblMedico (usuario, senha, nome, especialidade, crm) VALUES (:usuario, :senha, :nome, :especialidade, :crm)");
        $resultado = $stmt->execute([
            ':usuario' => $usuario,
            ':senha' => $senha,
            ':nome' => $nome,
            ':especialidade' => $especialidade,
            ':crm' => $crm
        ]);

        if ($resultado) {
            $mensagem = "Médico foi cadastrado na tabela com sucesso. Por favor, caso queira cadastrar mais um, pode cadastrar!";
        } else {
            $mensagem = "Erro ao cadas   trar médico.";
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
    <title>Cadastrar Médico</title>
</head>
<body>
    <?php if (!empty($mensagem)): ?>
        <p style="color: red;"><?php echo $mensagem; ?></p>
    <?php endif; ?>
    
    <form action="" method="POST">
        <label>Usuário:</label>
        <input type="text" name="usuario" required>
        <label>Senha:</label>
        <input type="password" name="senha" required>
        <label>Nome:</label>
        <input type="text" name="nome" required>
        <label>Especialidade:</label>
        <input type="text" name="especialidade" required>
        <label>CRM:</label>
        <input type="text" name="crm" required>
        <button type="submit">Cadastrar Médico</button>
    </form>
</body>
</html>