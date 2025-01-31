<?php

defined('CONTROL') or die('Acesso Negado!');

//vai para a próxima partida
if (isset($_GET['proximo'])) {

    //incrementa a quantidade de partidas
    $_SESSION['quantidade_partidas']++;

    //limpar tabuleiro do jogo
    $_SESSION['tabuleiro_jogo'] = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];

    //reinicia quantidade de jogadas
    $_SESSION['quantidade_jogadas'] = 1;

    //alternar o jogador
    $_SESSION['jogador_ativo'] = $_SESSION['jogador_ativo'] == 1 ? 2 : 1;

    //vai para o próximo jogo
    header('Location:index.php?route=game');
}

if (isset($_GET['jogador']) && isset($_GET['x']) && isset($_GET['y'])) {

    //armazena os valores do link
    $jogador = $_GET['jogador'];
    $x = $_GET['x'];
    $y = $_GET['y'];
    $vencedor = null;

    //verifica se já existe uma figura na celula
    if (empty($_SESSION['tabuleiro_jogo'][$x][$y])) {
        //define a figura do jogador
        $_SESSION['tabuleiro_jogo'][$x][$y] = $jogador == 1 ? 'X' : 'O';

        //verifica se o jogador venceu
        $status = verifica_status_jogo($jogador);

        if (!empty($status)) {

            //quem é o vencedor?
            $vencedor = $jogador == 1 ? $_SESSION['jogador_1_nome'] : $_SESSION['jogador_2_nome'];
            //incrementa um ponto para o vencedor
            $_SESSION[$jogador == 1 ? 'jogador_1_pontos' : 'jogador_2_pontos']++;
        }

        //verifica se foi empate
        if ($_SESSION['quantidade_jogadas'] == 9 && empty($vencedor)) {
            $vencedor = 'EMPATE';
        }

        if (empty($vencedor)) {

            //muda o jogador ativo
            $_SESSION['jogador_ativo'] = $jogador == 1 ? 2 : 1;
            //incrementa a quantidade de jogadas
            $_SESSION['quantidade_jogadas']++;
        }
    }
}

function verifica_status_jogo($jogador)
{
    /*
        verifica o vencedor
            1       2       3       4       5       6       7       8
        | x x x | - - - | - - - | x - - | - x - | - - x | x - - | - - x |
        | - - - | x x x | - - - | x - - | - x - | - - x | - x - | - x - |
        | - - - | - - - | x x x | x - - | - x - | - - x | - - x | x - - |
    */

    $marca = $jogador ==  1 ? 'X' : 'O';
    $tabuleiro_jogo = $_SESSION['tabuleiro_jogo'];
    $status = null;

    //situação 1
    if ($tabuleiro_jogo[0][0] == $marca && $tabuleiro_jogo[0][1] == $marca && $tabuleiro_jogo[0][2] == $marca) {
        $status = 'vencedor1';
    }

    //situação 2
    if ($tabuleiro_jogo[1][0] == $marca && $tabuleiro_jogo[1][1] == $marca && $tabuleiro_jogo[1][2] == $marca) {
        $status = 'vencedor2';
    }

    //situação 3
    if ($tabuleiro_jogo[2][0] == $marca && $tabuleiro_jogo[2][1] == $marca && $tabuleiro_jogo[2][2] == $marca) {
        $status = 'vencedor3';
    }

    //situação 4
    if ($tabuleiro_jogo[0][0] == $marca && $tabuleiro_jogo[1][0] == $marca && $tabuleiro_jogo[2][0] == $marca) {
        $status = 'vencedor4';
    }

    //situação 5
    if ($tabuleiro_jogo[0][1] == $marca && $tabuleiro_jogo[1][1] == $marca && $tabuleiro_jogo[2][1] == $marca) {
        $status = 'vencedor5';
    }

    //situação 6
    if ($tabuleiro_jogo[0][2] == $marca && $tabuleiro_jogo[1][2] == $marca && $tabuleiro_jogo[2][2] == $marca) {
        $status = 'vencedor6';
    }

    //situação 7
    if ($tabuleiro_jogo[0][0] == $marca && $tabuleiro_jogo[1][1] == $marca && $tabuleiro_jogo[2][2] == $marca) {
        $status = 'vencedor7';
    }

    //situação 8
    if ($tabuleiro_jogo[2][0] == $marca && $tabuleiro_jogo[1][1] == $marca && $tabuleiro_jogo[0][2] == $marca) {
        $status = 'vencedor8';
    }

    return $status;
}

?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">
            <h3 class="text-center">Jogo Da Velha</h3>
            <hr>
            <div class="row">
                <div class="col">
                    <h3 class="text-center <?= $_SESSION['jogador_ativo'] == 1 ? 'text-warning' : '' ?>"><?= $_SESSION['jogador_1_nome'] ?></h3>
                    <h3 class="text-center"><?= $_SESSION['jogador_1_pontos'] ?></h3>
                </div>
                <div class="col">
                    <h4 class="text-center">
                        <span class="text-info">PARTIDA Nº <?= $_SESSION['quantidade_partidas'] ?></span>
                    </h4>
                </div>
                <div class="col text-end">
                    <h3 class="text-center <?= $_SESSION['jogador_ativo'] == 2 ? 'text-warning' : '' ?>"><?= $_SESSION['jogador_2_nome'] ?></h3>
                    <h3 class="text-center"><?= $_SESSION['jogador_2_pontos'] ?></h3>
                </div>
            </div>
            <hr>

            <?php for ($row = 0; $row <= 2; $row++): ?>

                <div class="d-flex justify-content-center">

                    <?php for ($col = 0; $col <= 2; $col++): ?>

                        <!-- Verifica se tem um vencedor -->
                        <?php if (isset($vencedor)): ?>
                                <div class="board-cell text-center">
                                    <?php if ($_SESSION['tabuleiro_jogo'][$row][$col] == 'X'): ?>
                                        <img src="assets/images/times.png">
                                    <?php elseif ($_SESSION['tabuleiro_jogo'][$row][$col] == 'O'): ?>
                                        <img src="assets/images/circle.png">
                                    <?php endif; ?>
                                </div>
                        <?php else: ?>
                            <a href="index.php?route=game&jogador=<?= $_SESSION['jogador_ativo'] ?>&x=<?= $row ?>&y=<?= $col ?>">

                                <div class="board-cell text-center">
                                    <?php if ($_SESSION['tabuleiro_jogo'][$row][$col] == 'X'): ?>
                                        <img src="assets/images/times.png">
                                    <?php elseif ($_SESSION['tabuleiro_jogo'][$row][$col] == 'O'): ?>
                                        <img src="assets/images/circle.png">
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endif; ?>

                    <?php endfor; ?>

                </div>

            <?php endfor; ?>

            <?php if (!empty($vencedor)): ?>
                <div class="text-center mt-5">
                    <h3 class="text-center text-warning"><?= $vencedor ?></h3>
                    <div class="text-center mt-5">
                        <a href="index.php?route=game&proximo=1" class="btn btn-success w-25">PRÓXIMO JOGO</a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="text-center mt-5">
                <a href="index.php?route=start" class="btn btn-dark w-25">REINICIAR</a>
            </div>
        </div>
    </div>
</div>