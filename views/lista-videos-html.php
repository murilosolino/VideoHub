<?php

require_once __DIR__ . '/inicio-html.php';
?>

<ul class="videos__container" alt="videos alura">
    <?php foreach ($listaVideos as $video): ?>
        <?php if (filter_var($video->url, FILTER_VALIDATE_URL)): ?>
            <li class="videos__item">
                <iframe width="100%" height="100%" src="<?= $video->url ?>"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
                <div class="descricao-video">
                    <img src="./img/logo.png" alt="logo canal alura">
                    <h3><?= $video->titulo ?></h3>
                    <div class="acoes-video">
                        <a href="/editar-video?id=<?= $video->id ?>">Editar</a>
                        <a href="/remover-video?id=<?= $video->id ?>">Excluir</a>
                    </div>
                </div>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

<?php if (isset($_GET['success'])): ?>
    <?php if ($_GET['success'] == 1): ?>
        <script>
            alert('Operação realizada com sucesso!');
        </script>
    <?php else: ?>
        <script>
            alert('Ocorreu um erro durante a Operação!');
        </script>
    <?php endif; ?>
<?php endif; ?>

<?php require_once __DIR__ . '/fim-html.php';
