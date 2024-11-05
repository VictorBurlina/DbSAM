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
$medico_info = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM tblMedico WHERE usuario = :usuario");
        $stmt->execute([':usuario' => $usuario]);
        $medico = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($medico && $medico['senha'] === $senha) {
            $_SESSION['medico_id'] = $medico['id']; 
            $_SESSION['medico_nome'] = $medico['nome']; 

            
            $mensagem = "O usuário é um médico válido.";
            $medico_info = $medico;
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
    <title>Login Médico</title>
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
        <button type="submit">Login</button>
    </form>

    <?php if ($medico_info): ?>
        <h2>Informações do Médico:</h2>
        <p><strong>ID:</strong> <?php echo $medico_info['id']; ?></p>
        <p><strong>Nome:</strong> <?php echo $medico_info['nome']; ?></p>
        <p><strong>Especialidade:</strong> <?php echo $medico_info['especialidade']; ?></p>
        <p><strong>CRM:</strong> <?php echo $medico_info['crm']; ?></p>
    <?php endif; ?>
</body>
</html>