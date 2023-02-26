<?php require_once('view/include/header.php'); ?>
<link rel="stylesheet" href="assets/css/signup.css">
<main>
    <h1><?php echo $title ?></h1>
    <form action="../index.php?action=<?php echo $a ?>" method="post">
        <div>
            <div class="field">
                <label for="prenom">Prénom</label>
                <div class="fieldInput">
                    <input type="text" id="prenom" name="prenom" required autofocus value="<?php echo $prenom ?>">
                    <div>
                        <img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px">
                    </div>
                </div>
            </div>
            <div class="field">
                <label for="nom">Nom</label>
                <div class="fieldInput">
                    <input type="text" id="nom" name="nom" required value="<?php echo $nom ?>">
                    <div>
                        <img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px" hidden>
                    </div>
                </div>
            </div>
            <div class="field">
                <label for="email">Adresse mail <?php if($error==1) echo "<span style='color: red'>- Erreur: déjà utilisée</span>" ?></label>
                <div class="fieldInput">
                    <input type="text" id="email" name="email" required value="<?php echo $email ?>">
                    <div>
                        <img  class="buisson" src="assets/image/buisson.gif" width="42px" height="38px" hidden>
                    </div>
                </div>
            </div>
            <div class="field">
                <label for="mdp">Mot de passe</label>
                <div class="fieldInput">
                    <input type="password" id="mdp" name="mdp" required value="<?php echo $mdp ?>">
                    <div>
                        <img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px" hidden>
                    </div>
                </div>
            </div>
        </div>
        <div class="field" id="photoProfil">
            <label for="profilImg">Photo de profile</label>
            <div id="imageField">
                <img src="<?php echo $profilImg ?>" alt="image profil" id="profilImg">
            </div>
        </div>
        <input type="text" name="profilImg" id="fieldProfilImg" hidden value="<?php echo $profilImg ?>">
        <button type="submit"><?php echo $msg ?></button>
    </form>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function(){
        $('#imageField').click(function(){
            let input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = _ => {
                let file =   Array.from(input.files)[0];
                let reader = new FileReader();
                reader.onload = function() {
                    let dataURL = reader.result;
                    $('#profilImg').attr('src', dataURL);
                    $('#fieldProfilImg').val(dataURL);
                }
                reader.readAsDataURL(file);
            };
            input.click();
        });
        $('input').click(function(){
            $('.buisson').attr('hidden', true);
            $(this).parent().children('div').children('img').attr('hidden', false);
        });
        $('button').click(function(){
            if($('#prenom').val()!=""&&$('#nom').val()!=""&&$('#email').val()!=""&&$('#mdp').val()!=""&&$('#fieldProfilImg').val()!="") {
                $('button').html('<img src="assets/image/loading.gif">');
            }
        });

    });
</script>