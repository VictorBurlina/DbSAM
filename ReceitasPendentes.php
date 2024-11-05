<?php
session_start();

if (!isset($_SESSION['enfermeiro_id'])) {
    header("Location: LoginEnfermeiro.php");
    exit;
}

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

$pacientes = [];
$mensagem = '';

try {
    $stmt = $pdo->query("SELECT * FROM tblPaciente");
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensagem = "Erro: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastrar_receita'])) {
    $nome_paciente = $_POST['nome_paciente'];
    $nome_medicamento = $_POST['nome_medicamento'];
    $data_administracao = $_POST['data_administracao'];
    $hora_administracao = $_POST['hora_administracao'];
    $dose = $_POST['dose'];

    try {
        $stmt = $pdo->prepare("INSERT INTO tblReceitas (nome_paciente, nome_medicamento, data_administracao, hora_administracao) VALUES (:nome_paciente, :nome_medicamento, :data_administracao, :hora_administracao)");
        $resultado = $stmt->execute([
            ':nome_paciente' => $nome_paciente,
            ':nome_medicamento' => $nome_medicamento,
            ':data_administracao' => $data_administracao,
            ':hora_administracao' => $hora_administracao
        ]);

        if ($resultado) {
            $mensagem = "Receita cadastrada com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar a receita.";
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
    <title>Receitas Pendentes</title>
</head>
<body>
    <h1>Receitas Pendentes</h1>

    <?php if (!empty($mensagem)): ?>
        <p style="color: green;"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>Nome do Paciente</th>
                <th>Leito</th>
                <th>Cadastrar Receita</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($pacientes)): ?>
                <tr><td colspan="3">Nenhum paciente encontrado.</td></tr>
            <?php else: ?>
                <?php foreach ($pacientes as $paciente): ?>
                    <?php
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tblReceitas WHERE nome_paciente = :nome");
                    $stmt->execute([':nome' => $paciente['nome']]);
                    $tem_receitas = $stmt->fetchColumn() > 0;
                    ?>

                    <tr>
                        <td><?php echo $paciente['nome']; ?></td>
                        <td><?php echo $paciente['leito']; ?></td>
                        <td>
                            <?php if (!$tem_receitas): ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="nome_paciente" value="<?php echo $paciente['nome']; ?>">
                                    <label>Nome do Medicamento:</label>
                                    <input type="text" name="nome_medicamento" required>
                                    <label>Data da Administração:</label>
                                    <input type="date" name="data_administracao" required>
                                    <label>Hora da Administração:</label>
                                    <input type="time" name="hora_administracao" required>
                                    <label>Dose:</label>
                                    <input type="text" name="dose" required>
                                    <button type="submit" name="cadastrar_receita">Cadastrar Receita</button>
                                </form>
                            <?php else: ?>
                                <span>Receita já cadastrada</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>