<?php
date_default_timezone_set('America/Sao_Paulo');
$pdo = new PDO('mysql:host=localhost;dbname=sistema', 'root', '');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Sistema de Reserva</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="center">
            <div class="logo">
                <h2>Reserva.Dev</h2>
            </div>

            <nav class="menu">
                <ul>
                    <li><a href="admin.php">Reservas</a></li>
                    <li><a href="https://github.com/lumoura0" target="_blank">Contato</a></li>
                </ul>
            </nav>
            <div class="clear"></div>
        </div>
    </header>

    <section class="reserva">
        <div class="center">
            <h1>Faça a sua reserva agora !!!</h1>
            <?php
            if (isset($_POST['acao'])) {
                //Quero fazer uma reserva!
                $nome = $_POST['nome'];
                $dataHora = $_POST['dataHora'];
                $date = DateTime::createFromFormat('d/m/Y H:i:s', $dataHora);
                $dataHora =  $date->format('Y-m-d H:i:s');
                $sql = $pdo->prepare("INSERT INTO `tb_agendados` VALUES (null,?,?)");
                $sql->execute(array($nome, $dataHora));
                echo '<div class="sucesso">Seu horário foi agendado com sucesso!</div>';
            }
            ?>
            <form method="post">
                <input type="text" name="nome" placeholder="Seu nome...">
                <select name="dataHora">
                    <?php
                    for ($i = 0; $i <= 23; $i++) {
                        $hora = $i;
                        if ($i < 10) {
                            $hora = '0' . $hora;
                        }

                        $hora .= ':00:00';

                        $verifica = date('Y-m-d') . ' ' . $hora;
                        $sql = $pdo->prepare("SELECT * FROM `tb_agendados` WHERE horario = '$verifica'");
                        $sql->execute();

                        if ($sql->rowCount() == 0 && strtotime($verifica) > time()) {
                            $dataHora = date('d/m/Y') . ' ' . $hora;
                            echo '<option value="' . $dataHora . '">' . $dataHora . '</option>';
                        }
                    }
                    ?>


                </select>
                <input type="submit" name="acao" value="Enviar!">
            </form>
        </div>
    </section>
</body>
</html>