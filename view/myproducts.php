<?php require_once('view/include/header.php'); ?>
<link rel="stylesheet" href="assets/css/myproducts.css">
<main>
    <h1>Produits du site : "<?php echo $libelle ?>"</h1>
    <div id="search">
        <input type="text" autofocus value="<?php echo $search ?>" action="$('#search img').click()">
        <img src="assets/image/loupe.png">
    </div>
    <?php foreach($products as $product) { ?>
        <div class="productBox" id="<?php echo $product->get('id_p') ?>">
            <a href="../index.php?action=useProduct&id_p=<?php echo $product->get('id_p') ?>"><img src="<?php echo $product->get('image_url_p') ?>"></a>
            <p><?php echo $product->get('libelle_p') ?></p>
            <div>
                <a href="../index.php?action=updateProduct&id_p=<?php echo $product->get('id_p') ?>"><img src="assets/image/edit.png"></a>
                <a class="deleteB"><img src="assets/image/delete.png"></a>
            </div>
        </div>
    <?php } ?>
    <div id="pannel-right">
        <div id="arrowRight">
            <div id="ar">
                <p><</p>
            </div>
        </div>
        <div id="contentRight">
            <div class="productBox">
                <a href="../index.php?action=createProduct&id_s=<?php echo $_GET['id_s'] ?>"><img src="assets/image/plus.png"></a>
                <p>Ajouter un produit</p>
            </div>
            <div class="separator"></div>
            <div id="displayOrder">
                <p>Ordre d'affichage</p>
                <label for="orderC">Chronologique: </label>
                <input type="checkbox" id="orderC" <?php echo $orderC ?>>
                <label for="orderA">Alphabétique: </label>
                <input type="checkbox" id="orderA" <?php echo $orderA ?>>
            </div>
        </div>
    </div>
    <div id="pannel-left">
        <div id="contentLeft">
            <p>Catégories</p>
            <div class="categories"></div>
            <p id="titleCurrentCat">Catégorie sélectionnée</p>
            <span id="currentCat"></span>
        </div>
        <div id="arrowLeft">
            <div id="al">
                <p>></p>
            </div>
        </div>
    </div>
    <div id="pages">
        <div class="pagesA" id="pre"><a><</a></div>
        <div><p><?php echo $currentPage ?> / <?php echo $totalPage ?></p></div>
        <div class="pagesA" id="nex"><a>></a></div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function(){
        cp = <?php echo $currentPage ?>;
        tp = <?php echo $totalPage ?>;

        paths = <?php echo json_encode($paths_dict) ?>;
        currentPath = '<?php echo $currentPath ?>';
        $('#currentCat').text(currentPath.slice(0, -1));

        for(path_p in paths) {
            if(paths[path_p][2]) {
                cat = '<div class="cats"><p>'+path_p.slice(0, -1)+'</p>';
                if(paths[path_p][1]) cat+='<img src="assets/image/feuille.png">';
                cat += '</div>';
                $('#contentLeft .categories').append(cat);
            }
        }

        $(document).ready(function() {
            <?php if(isset($_GET['path_p'])) { ?>
                $('#al').click();
                catPath = currentPath.slice(0, -1).split('/');
                catPath.pop();
                if(catPath.length>0) {
                    console.log(catPath);
                    first = catPath.shift();
                    pannel = $('#pannel-left').children('#contentLeft').children('.categories');
                    clickOnCat($(pannel).children('.cats').children('p:contains("'+first+'")').parent(), catPath);
                }
            <?php } ?>
        });

        function clickOnCat(element, completPath=null) {
            cat = $(element).children('p').text()+'/';
            urlPath = null;
            <?php if(isset($_GET['path_p'])) echo 'urlPath="'.$_GET['path_p'].'";' ?>
            sub = false;
            if(urlPath!=null&&currentPath+cat==urlPath.slice(0, (currentPath+cat).length)) sub=true;
            if($(element).parent().parent()[0]==$('#contentLeft')[0]) {
                if(paths.hasOwnProperty(cat)) currentPath = cat;
            }else {
                if(paths.hasOwnProperty(currentPath+cat)) currentPath += cat;
            }
            if(!paths[currentPath][1]||sub) {
                sous_cats = paths[currentPath][0];
                if(sous_cats.length>0) {
                    sub_cat_pannel = document.createElement('div');
                    sub_cat_pannel.classList.add('sub_cats');
                    sousCategories = '';
                    for(sc in sous_cats) {
                        splitCat = sous_cats[sc].split('/');
                        catText = splitCat[splitCat.length-2];
                        sousCategories += '<div class="cats"><p>'+catText+'</p>';
                        if(paths[sous_cats[sc]][1]) sousCategories += '<img src="assets/image/feuille.png">';
                        sousCategories += '</div>';
                    }
                    final = '<div id="content"><p>Sous-catégorie(s)</p>'+sousCategories+'</div><div id="arrow"><div><p>></p></div></div>'
                    $(sub_cat_pannel).html(final);
                    $('main').append(sub_cat_pannel);
                    $(sub_cat_pannel).animate({
                        marginLeft: '+=200px'
                    }, 200, function() {
                        $(this).children('#arrow').children('div').children('p').text('<');
                        if(completPath!=null&&completPath.length>0) {
                            first = completPath.shift();
                            console.log([completPath, first]);
                            clickOnCat($(sub_cat_pannel).children('#content').children('.cats').children('p:contains("'+first+'")').parent(), completPath);
                        }
                    });
                }
            }else {
                if($('#orderC').is(":checked")&&$('#orderA').is(":checked")) {
                    order = 'ca';
                }else if($('#orderA').is(":checked")) {
                    order = 'a';
                }else if($('#orderC').is(":checked")) {
                    order = 'c';
                }else {
                    order = 'c';
                }
                window.location.replace('index.php?action=myproducts&id_s=<?php echo $_GET['id_s'] ?>&order='+order+'&search='+$('#search input').val()+'&path_p='+currentPath);
            }
        }
        $('.cats').click(function(event) {
            event.stopPropagation();
            clickOnCat(this);
        });

        $('main').on('click', '.cats', function(event) {
            event.stopPropagation();
            clickOnCat(this);
        });

        $('main').on("click", ".sub_cats #arrow div", function(event) {
            event.stopPropagation();
            $(this).parent().parent().animate({
                marginLeft: '-=220px'
            }, 200, function(){
                currentPath = currentPath.slice(0, -1).split('/');
                if(currentPath.length>1) {
                    currentPath.pop();
                    currentPath = currentPath.join('/')+'/';
                }
                $(this).remove();
            });
        });

        $('.productBox')
        .mouseenter(function(){
            if(window.innerWidth>1000) $(this).children('div').css('visibility', 'visible');
        })
        .mouseleave(function(){
            if(window.innerWidth>1000) $(this).children('div').css('visibility', 'hidden');
        });
        $('.deleteB').click(function() {
            id_p = $(this).parent().parent().attr('id');
            re = confirm("Êtes-vous sûre de vouloir supprimer ce produit ?");
            if(re) {
                if($('#orderC').is(":checked")&&$('#orderA').is(":checked")) {
                    order = 'ca';
                }else if($('#orderA').is(":checked")) {
                    order = 'a';
                }else if($('#orderC').is(":checked")) {
                    order = 'c';
                }else {
                    order = 'c';
                }
                window.location.replace('index.php?action=deleteProduct&id_p='+id_p+'&id_s=<?php echo $_GET['id_s'] ?>&order='+order+'&search='+$('#search input').val());
            }
        });
        ar = false;
        $('#ar').click(function(event){
            event.stopPropagation();
            if(!ar) {
                $('#pannel-right').animate({
                    marginLeft: '-=200px'
                }, 200, function(){
                    $('#ar p').text('>');
                    ar = true;
                });
            }else {
                $('#pannel-right').animate({
                    marginLeft: '+=200px'
                }, 200, function(){
                    $('#ar p').text('<');
                    ar = false;
                });
            }
        });
        al = true;
        $('#al').click(function(event){
            event.stopPropagation();
            if(!al) {
                $('#pannel-left').animate({
                    marginLeft: '-=200px'
                }, 200, function(){
                    $('#al p').text('>');
                    al = true;
                });
            }else {
                $('#pannel-left').animate({
                    marginLeft: '+=200px'
                }, 200, function(){
                    $('#al p').text('<');
                    al = false;
                });
            }
        });
        searchModif = false;
        $('#search input').change(function() {
            searchModif = true;
        });
        $('#search img').click(function() {
            if($('#orderC').is(":checked")&&$('#orderA').is(":checked")) {
                order = 'ca';
            }else if($('#orderA').is(":checked")) {
                order = 'a';
            }else if($('#orderC').is(":checked")) {
                order = 'c';
            }else {
                order = 'c';
            }
            window.location.replace('index.php?action=myproducts&id_s=<?php echo $_GET['id_s'] ?>&order='+order+'&search='+$('#search input').val());
        });
        $('#search input').on('keypress',function(e) {
            if(e.which == 13) {
                $('#search img').click();
            }
        });
        $('#pre').click(function(){
            if(!searchModif) {
                if(cp>1) {
                    if($('#orderC').is(":checked")&&$('#orderA').is(":checked")) {
                        order = 'ca';
                    }else if($('#orderA').is(":checked")) {
                        order = 'a';
                    }else if($('#orderC').is(":checked")) {
                        order = 'c';
                    }else {
                        order = 'c';
                    }
                    window.location.replace('index.php?action=myproducts&id_s=<?php echo $_GET['id_s'] ?>&num_page='+(cp-1)+'&order='+order+'&search='+$('#search input').val());
                }
            }else {
                alert('Lancez d\'abord votre nouvelle recherche');
            }
        });
        $('#nex').click(function(){
            if(!searchModif) {
                if(cp<tp) {
                    if($('#orderC').is(":checked")&&$('#orderA').is(":checked")) {
                        order = 'ca';
                    }else if($('#orderA').is(":checked")) {
                        order = 'a';
                    }else if($('#orderC').is(":checked")) {
                        order = 'c';
                    }else {
                        order = 'c';
                    }
                    window.location.replace('index.php?action=myproducts&id_s=<?php echo $_GET['id_s'] ?>&num_page='+(cp+1)+'&order='+order+'&search='+$('#search input').val());
                }
            }else {
                alert('Lancez d\'abord votre nouvelle recherche');
            }
        });
        $('#pannel-right').click(function(event) {
            event.stopPropagation();
        });
        $('#pannel-left').click(function(event) {
            event.stopPropagation();
        });
        $('main').on("click", ".sub_cats", function(event) {
            event.stopPropagation();
        });
        $('main').click(function() {
            if(ar) $('#ar').click();
            if(!al) $('#al').click();
            $('.sub_cats #arrow div').click();
        });
    });
</script>