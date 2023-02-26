<?php require_once('view/include/header.php'); ?>
<link rel="stylesheet" href="assets/css/signin.css">
<main>
    <h1>Avez vous déjà un compte chez nous ?</h1>
    <form action="../index.php?action=connect" method="post">
        <div class="field">
            <label for="email">Adresse mail</label>
            <div class="fieldInput">
                <input type="text" id="email" name="email" required autofocus>
                <div>
                    <img  class="buisson" src="assets/image/buisson.gif" width="42px" height="38px">
                </div>
            </div>
        </div>
        <div class="field">
            <label for="mdp">Mot de passe</label>
            <div class="fieldInput">
                <input type="password" id="mdp" name="mdp" required>
                <div>
                    <img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px" hidden>
                </div>
            </div>
        </div>
        <button type="submit">Connexion</button>
    </form>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function(){
        $('input').click(function(){
            $('.buisson').attr('hidden', true);
            $(this).parent().children('div').children('img').attr('hidden', false);
        });
        <?php if($error==1) { ?>
            $('.fieldInput div').css({
                'border': '0.5px solid red',
                'border-left': 'none'
            });
            $('.fieldInput input').css({
                'border': '0.5px solid red',
                'border-right': 'none'
            });
            $('.fieldInput').animate({marginLeft: '+=10px'}, 100);
            $('.fieldInput').animate({marginLeft: '-=8px'}, 100);
            $('.fieldInput').animate({marginLeft: '+=3px'}, 100);
            $('.fieldInput').animate({marginLeft: '-=5px'}, 100);
        <?php } ?>
    });
</script>