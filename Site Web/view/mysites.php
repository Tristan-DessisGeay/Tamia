<?php require_once('view/include/header.php'); ?>
<link rel="stylesheet" href="assets/css/mysites.css">
<main>
    <h1>Mes sites d'e-commerce</h1>
    <div id="search">
        <input type="text" autofocus>
        <img src="assets/image/loupe.png">
    </div>
    <?php 
        $libelleArray = array();
        $idArray = array();
        foreach($sites as $site) { 
            array_push($libelleArray, '"'.$site->get('libelle_s').'"');
            array_push($idArray, '"'.$site->get('id_s').'"');
    ?>
        <div class="siteBox" id="<?php echo $site->get('id_s')  ?>">
            <a href="../index.php?action=myproducts&id_s=<?php echo $site->get('id_s') ?>"><img src="<?php echo $site->get('image_url_s') ?>"></a>
            <p><?php echo $site->get('libelle_s') ?></p>
            <div>
                <a href="../index.php?action=updateSite&id_s=<?php echo $site->get('id_s') ?>"><img src="assets/image/edit.png"></a>
                <a class="deleteB"><img src="assets/image/delete.png"></a>
            </div>
        </div>
    <?php 
        } 
        $libelleArray = implode(",", $libelleArray);
        $idArray = implode(",", $idArray);
        echo '<script> var libelleArray = ['.$libelleArray.']; var idArray = ['.$idArray.']  </script>';
    ?>
    <div class="siteBox">
        <a href="../index.php?action=createSite"><img src="assets/image/plus.png" width=""></a>
        <p>Ajouter un site</p>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function(){
        $('.siteBox')
        .mouseenter(function(){
            if(window.innerWidth>1000) $(this).children('div').css('visibility', 'visible');
        })
        .mouseleave(function(){
            if(window.innerWidth>1000) $(this).children('div').css('visibility', 'hidden');
        });
        $('#search img').click(function() {
            $('#search input').change();
        });
        $('#search input').change(function() {
            for(let i=0;i<libelleArray.length;i++) {
                if(!libelleArray[i].includes($(this).val())) {
                    $('#'+idArray[i]).css('display', 'none');
                }else{
                    $('#'+idArray[i]).css('display', 'grid');
                }
            }
        });
        $('.deleteB').click(function() {
            id_s = $(this).parent().parent().attr('id');
            re = confirm("Êtes-vous sûre de vouloir supprimer ce site et ses produits ?");
            if(re) {
                window.location.replace('index.php?action=deleteSite&id_s='+id_s);
            }
        });
    });
</script>