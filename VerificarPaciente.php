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
$paciente = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nome_paciente'])) {
        $nome_paciente = $_POST['nome_paciente'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM tblPaciente WHERE nome = :nome");
            $stmt->execute([':nome' => $nome_paciente]);
            $paciente = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($paciente) {
                header("Location: CadastrarReceita.php?paciente_id=" . $paciente['id']);
                exit;
            } else {
                $mensagem = "Paciente não encontrado. Cadastre o paciente antes de cadastrar a receita.";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Paciente</title>
</head>
<body>
    <h1>Verificar Paciente</h1>
    
    <?php if (!empty($mensagem)): ?>
        <p style="color: red;"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
        <label>Nome do Paciente:</label>
        <input type="text" name="nome_paciente" required>
        <button type="submit">Verificar Paciente</button>
    </form>
</body>
</html>