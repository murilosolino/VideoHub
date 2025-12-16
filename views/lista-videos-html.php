<?php $this->layout('layout'); ?>

<ul class="videos__container" alt="videos alura">
    <?php foreach ($listaVideos as $video): ?>
        <?php if (filter_var($video->url, FILTER_VALIDATE_URL)): ?>
            <li class="videos__item">
                <?php if ($video->getFilePath()): ?>
                    <a href="<?= $video->url ?>">
                        <img src="<?= $video->getFilePath(); ?>" alt="Capa do Vídeo" height="100%" width="100%">
                    </a>
                <?php else: ?>
                    <iframe width="100%" height="100%" src="<?= $video->url ?>"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                <?php endif; ?>
                <div class="descricao-video">
                    <h3><?= $video->titulo ?></h3>
                    <div class="acoes-video">
                        <a href="/editar-video?id=<?= $video->id ?>">Editar</a>
                        <a href="/remover-capa?id=<?= $video->id ?>">Remover Capa</a>
                        <a href="/remover-video?id=<?= $video->id ?>">Excluir</a>
                    </div>
                </div>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>