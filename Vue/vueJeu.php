<?php $this->titre = "Snake Game";?>

<section class="snakeGame">

    <div class="entete-jeu">
            <button class="start">START</button>
            <div class="score">
                <p class="score-text">Score : </p>
                <p id="computerScore">0</p>
            </div>
        </div>
        <canvas id="canvas">
             <audio id="audioLose" class="hidden" src="public/music/mort.mp3"></audio>
            <audio id="audioWin" class="hidden" src="public/music/miam.mp3"></audio>
        </canvas>

        <div class="controles">
            <div class="haut">
                <i class="fas fa-arrow-up" id="up"></i>
            </div>
            <div class="cotes">
                <i class="fas fa-arrow-left" id="left"></i>
                <i class="fas fa-arrow-right" id="right"></i>

            </div>

            <div class="bas">
                <i class="fas fa-arrow-down" id="down"></i>
            </div>

        </div>

</section>
