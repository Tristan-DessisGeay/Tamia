<footer class="footer" style="background-color:#BB7D61;">
    <p style="font-size: 10px; color: white">♥ par Tristan Dessis-Geay et Loane Aviles ♥</p>
</footer>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
    $(function(){
        function getRandInt(max) {
            return Math.floor(Math.random() * max);
        }

        noisette = document.createElement("img");
        noisette.src = "assets/image/noisette.png";
        noisette.classList.add("noisette");

        function noisettePop() {
            $('.noisette').css('animation-play-state', 'running');
            noisette.style.width = "40px";
            noisette.style.height = "40px";
            noisette.style.opacity = '1';
            noisette.style.top = "0px";
            noisette.style.left = getRandInt(window.innerWidth-50)+"px";

            $('body').append(noisette);

            $('.noisette').animate({
                top: '+='+(window.innerHeight-90)+'px'
            }, {
                duration: 4000, 
                easing: 'linear',
                complete: function(){
                    $('.noisette').css('animation-play-state', 'paused');
                    $('.noisette').animate({
                        opacity: '0'
                    }, 500, function(){
                        setTimeout(function() {
                            noisettePop();
                        }, 10000);
                    });
            }});
        }

        noisettePop();

        $('.noisette').click(function(){
            $(this).css('animation-play-state', 'paused');
            $(this).animate({
                width: '+=20px',
                height: '+=20px',
                top: '-=10px',
                left: '-=10px'
            }, {
                duration: 100,
                queue: false,
                complete: function() {
                    $(this).css('opacity', '0');
                }
            });
        });

    });
</script>