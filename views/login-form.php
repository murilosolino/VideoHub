<?php require_once __DIR__ . "/inicio-html.php" ?>

<main class="container">

    <form class="container__formulario" method="post">
        <h2 class="formulario__titulo">Efetue login</h3>
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="usuario">E-mail</label>
                <input name="email" class="campo__escrita" required
                    placeholder="Digite seu usuário" id='usuario' />
            </div>


            <div class="formulario__campo">
                <label class="campo__etiqueta" for="senha">Senha</label>
                <input type="password" name="password" class="campo__escrita" required placeholder="Digite sua senha"
                    id='senha' />
            </div>

            <input class="formulario__botao" type="submit" value="Entrar" />
    </form>

</main>

<?php if (isset($_GET['success'])): ?>
    <?php if ($_GET['success'] == 1): ?>
        <script>
            alert('Operação realizada com sucesso!');
        </script>
    <?php else: ?>
        <script>
            alert('Email ou senha inválidos. Por favor verifique os seus dados.');
        </script>
    <?php endif; ?>
<?php endif; ?>

<?php require_once __DIR__ . "/fim-html.php" ?>