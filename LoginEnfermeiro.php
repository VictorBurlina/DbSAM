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
$enfermeiro = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM tblEnfermeiro WHERE usuario = :usuario AND senha = :senha");
        $stmt->execute([':usuario' => $usuario, ':senha' => $senha]);
        $enfermeiro = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($enfermeiro) {
            $_SESSION['enfermeiro_id'] = $enfermeiro['id'];
            $_SESSION['enfermeiro_nome'] = $enfermeiro['nome'];
            $mensagem = "Login bem-sucedido! Bem-vindo, " . $enfermeiro['nome'] . ".";
        } else {
            $mensagem = "Usuário ou senha inválidos.";
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
    <title>Login Enfermeiro</title>
</head>
<body>
    <h1>Login de Enfermeiro</h1>

    <?php if (!empty($mensagem)): ?>
        <p style="color: <?php echo isset($enfermeiro) ? 'green' : 'red'; ?>;"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label>Usuário:</label>
        <input type="text" name="usuario" required>
        <label>Senha:</label>
        <input type="password" name="senha" required>
        <button type="submit">Login</button>
    </form>

    <?php if ($enfermeiro): ?>
        <h2>Informações do Enfermeiro:</h2>
        <p><strong>ID:</strong> <?php echo $enfermeiro['id']; ?></p>
        <p><strong>Nome:</strong> <?php echo $enfermeiro['nome']; ?></p>
        <p><strong>COREN:</strong> <?php echo $enfermeiro['coren']; ?></p>
        <p><strong>Usuário:</strong> <?php echo $enfermeiro['usuario']; ?></p>
    <?php endif; ?>
</body>
</html>