<?php require_once('view/include/header.php'); ?>
<link rel="stylesheet" href="assets/css/createProduct.css">
<main>
    <h1><?php echo $title ?></h1>
    <div id="leftPane">
        <div class="field">
            <label for="libelle">Libellé</label>
            <div class="fieldInput">
                <input type="text" id="libelle" name="libelle" required autofocus value="<?php echo $libelle ?>">
                <div>
                    <img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px">
                </div>
            </div>
        </div>
        <?php if($msg=='Valider') { ?>
        <div class="field">
            <label for="event">Évènement de vente</label>
            <div class="fieldInput">
                <input type="text" id="event" name="event" required value="<?php echo $event ?>">
                <div>
                    <img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px" hidden>
                </div>
            </div>
        </div>
        <div class="field">
            <label for="frequence">Échelle de prédictions</label>
            <div id="contentPredict">
                <div id="jour"><p>Journalière</p></div>
                <div id="semaine"><p>Hebdomadaire</p></div>
                <div id="mois"><p>Mensuelle</p></div>
            </div>
        </div>
        <?php } ?>
        <div class="field">
            <label for="path">Catégorie</label>
            <div class="fieldInput">
                <input type="text" id="path" name="path" required value="<?php echo $path_p ?>">
                <div>
                    <img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px" hidden>
                </div>
            </div>
        </div>
        <?php if($msg!='Valider') { ?>
        <div id="remarque">
            <p>Remarque: Des informations telles que l'évènement de vente, l'échelle de prédiction ou encore la liste des évènements à prendre en compte ne sont pas modifiables après la création d'un produit.<br>Cela aurait pour conséquence de fausser les résultats de prédiction.</p>
        </div>
        <?php } ?>
    </div>
    <div class="field" id="photoProduct">
        <label for="image_url">Miniature du produit</label>
        <div id="imageField">
            <img src="<?php echo $image_url ?>" alt="miniature produit" id="miniatureP">
        </div>
    </div>
    <?php if($msg=='Valider') { ?>
    <div id="eventListBox">
        <label for="">Évènements à prendre en compte</label>
        <div id="eventList">
            <div class="fieldInput">
                <input type="text" id="event" name="event" required>
                <div>
                    <img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px" hidden>
                </div>
            </div>
        </div>
        <div id="eventListButtons">
            <div id="addField">+</div>
            <div id="removeField">-</div>
        </div>
    </div>
    <?php } ?>
    <input type="text" name="image_url" id="image_url" hidden value="<?php echo $image_url ?>">
    <button><?php echo $msg ?></button>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function(){
        <?php if($msg=='Valider') { ?>
        echelles = ['jour', 'semaine', 'mois'];
        currentEchelle = <?php echo $frequence-1 ?>;
        $('#contentPredict div').click(function() {
            currentEchelle = echelles.indexOf($(this).attr('id'));
            $('#contentPredict div').css({
                'background-color': 'white',
                'color': 'black'
            });
            $('#'+echelles[currentEchelle]).css({
                'background-color': 'rgb(228, 149, 113)',
                'color': 'white'
            });
        });
        $('#'+echelles[currentEchelle]).click();
        <?php } ?>
        $('#imageField').click(function(){
            let input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = _ => {
                let file =   Array.from(input.files)[0];
                let reader = new FileReader();
                reader.onload = function() {
                    let dataURL = reader.result;
                    $('#miniatureP').attr('src', dataURL);
                    $('#image_url').val(dataURL);
                }
                reader.readAsDataURL(file);
            };
            input.click();
        });
        $('main').on('click', 'input', function(){
            $('.buisson').attr('hidden', true);
            $(this).parent().children('div').children('img').attr('hidden', false);
        });
        <?php if($msg=='Valider') { ?>
        $('#addField').click(function() {
            if($('#eventList').children().last().children('input').val()!='') {
                $('#eventList').append('<div class="fieldInput"><input type="text" id="event" name="event" required><div><img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px" hidden></div></div>');
            }
        });
        $('#removeField').click(function() {
            if($('#eventList').children().length>1) {
                $('#eventList').children().last().remove();
            }
        });
        <?php } ?>
        $('button').click(function(){
            ok = true;
            <?php if($msg=='Valider') { ?>
            eventFields = $('#eventList').children();
            eventListS = '';
            for(let i=0;i<eventFields.length;i++) {
                value = $(eventFields[i]).children('input').val();
                if(value!='') {
                    eventListS += value+';';
                }else {
                    ok = false;
                    break;
                }
            }
            eventListS = eventListS.slice(0, -1);
            if($('#event').val()=='') {
                ok=false;
            }
            <?php } ?>
            if(ok&&$('#libelle').val()!=''&&$('#path').val()!=''&&$('#image_url').val()!='') {
                form = $(
                    '<form action="../index.php?action=createdProduct" method="POST">' +
                        <?php if(isset($_GET['id_p'])) { ?>
                        '<input hidden name="id_p" value="<?php echo $_GET['id_p'] ?>"/>' +
                        <?php } ?>
                        '<input hidden name="id_s" value="<?php echo $_GET['id_s'] ?>"/>' +
                        '<input hidden name="libelle" value="'+$('#libelle').val()+'"/>' +
                        '<input hidden name="path" value="'+$('#path').val()+'"/>' +
                        '<input hidden name="image_url" value="'+$('#image_url').val()+'"/>' +
                        <?php if($msg=='Valider') { ?>
                        '<input hidden name="event" value="'+$('#event').val()+'"/>' +
                        '<input hidden name="eventlist" value="'+eventListS+'"/>' +
                        '<input hidden name="frequence" value="'+(currentEchelle+1)+'"/>' +
                        <?php } ?>
                    '</form>'
                );
                $('body').append(form);
                $(form).submit();
            }else {
                alert('Vous devez renseinger tous les champs.');
            }
        });
    });
</script>