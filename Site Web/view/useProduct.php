<?php require_once('view/include/header.php'); ?>
<link rel="stylesheet" href="assets/css/useProduct.css">
<main>
    <h1>Utilisation du modèle de votre produit</h1>
    <div id="miniatureCadre">
        <img src="<?php echo $image_url ?>">
    </div>
    <div id="infoCadre">
        <p id="libelle">Libellé: <?php echo $libelle ?></p>
        <p id="site">Provenant du site: <?php echo $siteLibelle ?></p>
        <p id="echelle">Échelle de prédictions: <?php echo $frequence ?></p>
    </div>
    <div id="resultatCadre">
        <div id="eventList">
            <?php for($i=0;$i<count($eventlist_p);$i++) { ?>
                <div><p><?php echo $eventlist_p[$i] ?></p><span class="event_i">(?)</span></div>
            <?php } ?>
        </div>
        <img id="lianes" src="assets/image/lianes.png">
        <div id="resultCadre">
            <p id="re">? ventes estimées</p>
        </div>
    </div>
    <div id="containerCanvas" style="padding: 10px;height: min-content;display: grid;">
        <canvas style="align-self: center;" id="courbeApprentissage"></canvas>
    </div>
    <button>Effectuer une prédiction de ventes</button>
</main>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
    $(function(){

        lastScrollVal = 0; 
        lastScrollTime = $.now();
        $('#eventList').scroll(function() {
            if(($.now()-lastScrollTime)>3000) {
                if($(this).scrollTop() > lastScrollVal) {
                    lastScrollVal += $(this).height()*0.2;
                    $(this).scrollTop(lastScrollVal);
                }else {
                    lastScrollVal -= $(this).height()*0.2;
                    $(this).scrollTop(lastScrollVal);
                }
            }else {
                dif = $(this).scrollTop() - lastScrollVal;
                $(this).scrollTop(lastScrollVal+dif);
            }
            lastScrollTime = $.now();
        });

        function curveMAJ() {
            /*
                Mise à jour de la courbe d'apprentissage du modèle du produit en question.
            */
            $.ajax({
                url: "../cgi-bin/history.py",
                data: {site:<?php echo "$id_s"?>,produit:<?php echo "$id_p"?>} // Changer dynamiquement l'id du site et celui du produit
            }).done(function(data){
                if(data!=0) {
                    data = data.split(";")
                }else{
                    data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                }
                const canvas = document.getElementById("courbeApprentissage").getContext("2d");

                    Chart.defaults.global.legend.display = false;
                    new Chart(canvas, {
                        type: "line",
                        data: {
                            labels: Array.from({length:data.length},(_,k)=>k+1),
                            datasets: [{
                                data:data,
                                fill:false,
                                borderColor: "#D98E35",
                                tension: 0.1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Taux d'erreur"
                                    },
                                    ticks: {
                                        autoskip: true
                                    }
                                }],
                                xAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Etapes d'entrainement"
                                    },
                                    ticks: {
                                        autoskip: true
                                    }
                                }]
                            }
                        }
                    });
                });
            }

        $("#courbeApprentissage").click(function () {
            curveMAJ();
        });

        curveMAJ();

        $("button").click(function(){
            $("#lianes").attr("src", "assets/image/loading.gif");
            $.ajax({
                url: "../cgi-bin/predict.py",
                data: {
                    site:'<?php echo $id_s?>',
                    produit:'<?php echo $id_p?>',
                    property_id:'<?php echo $propertyid_p?>',
                    filters:'<?php echo $eventlist2_p?>',
                    event_name:'<?php echo $event_p?>'
                }
            }).done(function(data){
                $("#lianes").attr("src", "assets/image/lianes.png");
                console.log(data);
                if(data==-0.1) {
                    alert("Le modèle est en cours d'entrainement. 24h sont nécessaires pour l'élaboration de la première version du modèle.")
                }else {
                    data = data.split(';');
                    if(data[0] < 2) $('#re').html(data[0]+" vente estimée");
                    else $('#re').html(data[0]+" ventes estimées");
                    data.shift();
                    count = 0;
                    $('.event_i').each(function() {
                        $(this).html('('+data[count]+')');
                        count++;
                    });
                }
            });
        });
    });
</script>