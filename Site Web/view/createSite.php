
<?php require_once('view/include/header.php'); ?>
<link rel="stylesheet" href="assets/css/createSite.css">
<main>
    <h1><?php echo $title ?></h1>
    <form action="../index.php?action=<?php echo $a ?>" method="post">
        <div>
            <div class="field">
                <label for="libelle">Libellé</label>
                <div class="fieldInput">
                    <input type="text" id="libelle" name="libelle" required autofocus value="<?php echo $libelle ?>">
                    <div>
                        <img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px">
                    </div>
                </div>
            </div>
            <div class="field">
                <label for="propertyid">ID de propriété</label>
                <div class="fieldInput">
                    <input type="text" id="propertyid" name="propertyid" required value="<?php echo $propertyid ?>">
                    <div>
                        <img class="buisson" src="assets/image/buisson.gif" width="42px" height="38px" hidden>
                    </div>
                </div>
            </div>
        </div>
        <div class="field" id="imageBlock">
            <label for="image">Miniature du site</label>
            <div id="imageField">
                <img src="<?php echo $image ?>" alt="image profil" id="image">
            </div>
        </div>
        <input type="text" name="image" id="fieldImage" hidden value="<?php echo $image ?>">
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
                    $('#image').attr('src', dataURL);
                    $('#fieldImage').val(dataURL);
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
            if($('#libelle').val()!=""&&$('#propertyid').val()!=""&&$('#fieldImage').val()!="") {
                $('button').html('<img src="assets/image/loading.gif">');
            }
        });

    });
</script>