<header>
    <div id="left">
        <a href="index.php" style="height: 45px"><img src="assets/image/logo.png" width="45px" height="45px"></a>
        <a href="index.php">TAMiA</a>
        <?php
            if(isset($_SESSION['id_u'])) {
                echo '<a href="../../index.php?action=mysites">Mes sites</a>';
            }
        ?>
    </div>
    <div id="right">
        <?php
            if(!isset($_SESSION['id_u'])) {
                echo '
                    <a href="../../index.php?action=signin">Connexion</a>
                    <a href="../../index.php?action=signup">Je suis nouveau!</a>
                ';
            }else {
                $profilImage = $_SESSION['image_profil_u'];
                echo '
                    <a href="../../index.php?action=signout">Déconnexion</a>
                    <a href="../../index.php?action=editprofil" style="height: 45px"><img src="'.$profilImage.'" width="45px" height="45px"></a>
                ';
            }
        ?>
    </div>
    <div class="waves-container"> 
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
            </defs>
            <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
            </g>
        </svg> 
    </div>
</header>