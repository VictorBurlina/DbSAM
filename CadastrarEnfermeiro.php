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
    $coren = $_POST['coren'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    try {
        $stmt = $pdo->prepare("INSERT INTO tblEnfermeiro (nome, COREN, usuario, senha) VALUES (:nome, :coren, :usuario, :senha)");
        $resultado = $stmt->execute([
            ':nome' => $nome,
            ':coren' => $coren,
            ':usuario' => $usuario,
            ':senha' => $senha
        ]);

        if ($resultado) {
            $mensagem = "Enfermeiro cadastrado com sucesso!";
            $nome = '';
            $coren = '';
            $usuario = '';
            $senha = '';
        } else {
            $mensagem = "Erro ao cadastrar o enfermeiro.";
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
    <title>Cadastrar Enfermeiro</title>
</head>
<body>
    <h1>Cadastrar Novo Enfermeiro</h1>

    <?php if (!empty($mensagem)): ?>
        <p style="color: green;"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required>
        <label>COREN:</label>
        <input type="text" name="coren" required>
        <label>Usuário:</label>
        <input type="text" name="usuario" required>
        <label>Senha:</label>
        <input type="password" name="senha" required>
        <button type="submit">Cadastrar Enfermeiro</button>
    </form>
</body>
</html>