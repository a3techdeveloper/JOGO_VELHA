<?php
defined('CONTROL') or die('Acesso Negado!');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //dados do jogo
    $data = [
        //jogador 1
        'jogador_1_nome' => $_POST['text_jogador_1'],
        'jogador_1_figura' => 'X',
        'jogador_1_pontos' => 0,

        //jogador 2
        'jogador_2_nome' => $_POST['text_jogador_2'],
        'jogador_2_figura' => 'O',
        'jogador_2_pontos' => 0,

        //tabuleiro jogo
        'tabuleiro_jogo' => [
            ['', '', ''],
            ['', '', ''],
            ['', '', '']
        ],

        'quantidade_jogadas' => 1,
        'quantidade_partidas' => 1,
        'jogador_ativo' => 1
    ];

    $_SESSION = $data;

    //iniciar o jogo
    header('Location: index.php?route=game');
}

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-6 card bg-secondary text-white p-5">
            <form action="index.php?route=start" method="post">
                <h3 class="text-center">Jogo Da Velha</h3>
                <hr>

                <!-- jogador 1 -->
                <div class="mb-3">
                    <label for="text_jogador_1" class="form-label">JOGADOR 1</label>
                    <input type="text" name="text_jogador_1" id="text_jogador_1" class="form-control" required>
                </div>

                <!-- jogador 2 -->
                <div class="mb-3">
                    <label for="text_jogador_2" class="form-label">JOGADOR 2</label>
                    <input type="text" name="text_jogador_2" id="text_jogador_2" class="form-control" required>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-dark w-25">INICIAR JOGO</button>
                </div>
            </form>
        </div>
    </div>
</div>