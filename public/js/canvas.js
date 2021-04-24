class Canvas {
    constructor(canvas, snakeBody, direction, pommePosition) {
        this.snakeBody = snakeBody;
        this.direction = direction;
        this.pommePosition = pommePosition;
        this.canvas = canvas;
        this.ctx = this.canvas.getContext("2d");
        this.canvasWidth = 900;
        this.canvasHeigth = 600;
        this.timer = 90;
        this.ateApple = false;
        this.blockSize = 30;
        this.newScore = 0;
        this.computerScore = document.getElementById("computerScore");
        this.widthInBlocks = this.canvasWidth / this.blockSize;
        this.heigthInBlocks = this.canvasHeigth / this.blockSize;
        this.eat = document.getElementById("audioWin");
        this.eat.volume = 0.2;
        this.loose = document.getElementById("audioLose");
        this.timeOut = null;
        this.init();
        this.keyboard();
        this.mobileGame();

    }

    // Initialise le Canvas
    init() {
        document.querySelector(".start").addEventListener("click", () => {
            this.restart();
        });
        this.canvas.height = this.canvasHeigth;
        this.canvas.width = this.canvasWidth;
    }

    // Met à jour le Canvas en fonction des évènements
    refreshCanvas() {
        this.snakeMove();
        if (this.snakeCheckCollision()) {
            this.gameOver();
            this.loose.volume = 0.2;
            document.getElementById("audioLose").play();

            // Instanciation de la class AJAX afin d'utiliser les méthodes POST ET GET
            let ajax1 = new AjaxMethode();

            // let that = this;

            ajax1.ajaxGet(
                "http://localhost:8888/Jeu%20serpent/index.php?action=scoreBdd",
                function (data) {
                    if (data < that.newScore) {
                        let commande = new FormData();
                        commande.append("score", that.newScore);
                        // Envoi de l'objet FormData au serveur
                        ajax1.ajaxPost("index.php?action=score", commande, function (
                            reponse
                        ) {
                            // Affichage dans la console en cas de succès
                            console.log("ESSAI ENVOYÉ");
                        });
                    } else {
                        console.log("Score inférieur");
                    }
                }
            );
        }

        // Actualisation du Canvas
        else {
            // Le serpent a mangé la pomme
            if (this.isEatingApple()) {
                document.getElementById("audioWin").play();
                this.newScore++;
                this.timer -= 1;
                this.drawScore();

                this.ateApple = true;
                do {
                    this.setNewPositionApple();
                } while (this.isAppleOnSnake());
            }

            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
            this.snakeDraw();
            this.appleDraw();
            this.timeOut = setTimeout(() => {
                this.refreshCanvas();
            }, this.timer);
        }
    }

    // Méthode pour dessiner un bloc
    drawBlock(ctx, position) {
        let x = position[0] * this.blockSize;
        let y = position[1] * this.blockSize;
        this.ctx.fillRect(x, y, 27, 27);
    }

    // Méthode pour annoncer le Game Over
    gameOver() {
        this.ctx.save();
        this.ctx.font = "bold 120px 'Londrina Solid'";
        this.ctx.fillStyle = "#000";
        this.ctx.textAlign = "center";
        this.ctx.textBasline = "middle";
        this.ctx.strokeStyle = "black";
        let centreX = this.canvasWidth / 2;
        let centreY = this.canvasHeigth / 2;
        this.ctx.lineWidth = 2;
        this.ctx.strokeText("Game Over", centreX, centreY - 20);
        this.ctx.font = "400 30px 'Londrina Solid'";
        this.ctx.fillText(
            "Appuyez sur la barre espace pour rejouer",
            centreX,
            centreY + 20
        );
        this.ctx.restore();
    }

    // Méthode pour relancer le jeu
    restart() {
        this.pommePosition = [10, 10];
        this.snakeBody = [
            [6, 4],
            [5, 4],
            [4, 4],
        ];
        this.direction = "right";
        this.computerScore.innerHTML = "0";
        this.newScore = 0;
        clearTimeout(this.timeOut);
        this.timer = 90;
        this.refreshCanvas();
    }

    // Méthode pour afficher le score
    drawScore() {
        let number = this.computerScore.innerHTML;
        number++;
        this.computerScore.innerHTML = number;
    }


    mobileGame() {
        let newDirection;
        document.getElementById('right').addEventListener('click', () => {
            newDirection = "right";
            this.snakeSetDirection(newDirection);
        });

        document.getElementById('left').addEventListener('click', () => {
            newDirection = "left";
            this.snakeSetDirection(newDirection);
        });

        document.getElementById('up').addEventListener('click', () => {
            newDirection = "up";
            this.snakeSetDirection(newDirection);
        });

        document.getElementById('down').addEventListener('click', () => {
            newDirection = "down";
            this.snakeSetDirection(newDirection);
        });
    };

    // Méthode pour écouter les touches du clavier
    keyboard() {

        window.document.addEventListener("keydown", (e) => {
            let newDirection;
            switch (e.keyCode) {
                case 37:
                    e.preventDefault();
                    newDirection = "left";
                    break;
                case 38:
                    e.preventDefault();
                    newDirection = "up";
                    break;
                case 39:
                    e.preventDefault();
                    newDirection = "right";
                    break;
                case 40:
                    e.preventDefault();
                    newDirection = "down";
                    break;
                case 32:
                    e.preventDefault();
                    this.restart();
                    return;
                default:
                    return;
            }
            this.snakeSetDirection(newDirection);
        });
    }

    /*=============================================>>>>>
              = Méthodes liées au serpent =
              ===============================================>>>>>*/

    // Méthode pour afficher le corps du serpent
    snakeDraw() {
        this.ctx.save();
        this.ctx.fillStyle = "#050401";
        for (let i = 0; i < this.snakeBody.length; i++) {
            this.drawBlock(this.ctx, this.snakeBody[i]);
        }
        this.ctx.restore();
    }

    // Ajoute un bloc à l'avant du serpent et retire son dernier bloc à l'arrière
    snakeMove() {
        let nextPosition = this.snakeBody[0].slice();
        switch (this.direction) {
            case "left":
                nextPosition[0] -= 1;
                break;
            case "right":
                nextPosition[0] += 1;
                break;
            case "down":
                nextPosition[1] += 1;
                break;
            case "up":
                nextPosition[1] -= 1;
                break;
            default:
                throw "Invalid Direction";
        }
        this.snakeBody.unshift(nextPosition);
        if (!this.ateApple) {
            this.snakeBody.pop();
        } else {
            this.ateApple = false;
        }
    }

    // Méthode qui gère les directions autorisées pour le serpent
    snakeSetDirection(newDirection) {
        let allowedDirections;
        switch (this.direction) {
            case "left":
            case "right":
                allowedDirections = ["up", "down"];
                break;
            case "up":
            case "down":
                allowedDirections = ["left", "right"];
                break;
            default:
                throw "Invalid Direction";
        }
        if (allowedDirections.indexOf(newDirection) > -1) {
            this.direction = newDirection;
        }
    }

    // Méthode pour vérifier si le serpent a tapé un mur ou son propre corps
    snakeCheckCollision() {
        let wallCollision = false;
        let snakeCollision = false;
        let snakeHead = this.snakeBody[0];
        let rest = this.snakeBody.slice(1);
        let snakeHeadX = snakeHead[0];
        let snakeHeadY = snakeHead[1];
        let minX = 0;
        let minY = 0;
        let maxX = this.widthInBlocks - 1;
        let maxY = this.heigthInBlocks - 1;
        let isNotBetweenHorizontalWalls = snakeHeadX < minX || snakeHeadX > maxX;
        let isNotBetweenVerticalWalls = snakeHeadY < minY || snakeHeadY > maxY;

        if (isNotBetweenVerticalWalls || isNotBetweenHorizontalWalls) {
            wallCollision = true;
        }

        for (let i = 0; i < rest.length; i++) {
            if (snakeHeadX == rest[i][0] && snakeHeadY == rest[i][1]) {
                snakeCollision = true;
            }
        }

        return wallCollision || snakeCollision;
    }

    // Méthode pour vérifier si le serpent est sur la même case que la pomme
    isEatingApple() {
        let head = this.snakeBody[0];
        if (
            head[0] === this.pommePosition[0] &&
            head[1] === this.pommePosition[1]
        ) {
            return true;
        } else {
            return false;
        }
    }

    /*=============================================>>>>>
              = Méthodes liées à la pomme =
              ===============================================>>>>>*/

    // Méthode pour afficher la pomme
    appleDraw() {
        this.ctx.save();
        this.ctx.fillStyle = "red";
        let x = this.pommePosition[0] * this.blockSize;
        let y = this.pommePosition[1] * this.blockSize;
        this.ctx.fillRect(x, y, 27, 27);
        this.ctx.restore();
    }

    // Méthode pour définir une position aléatoire à la pomme
    setNewPositionApple() {
        let newX = Math.round(Math.random() * (this.widthInBlocks - 1));
        let newY = Math.round(Math.random() * (this.heigthInBlocks - 1));
        this.pommePosition = [newX, newY];
    }

    // Méthode vérifier si la pomme est sur le serpent ou non
    isAppleOnSnake() {
        let IsOnSnake = false;
        for (let i = 0; i < this.snakeBody.length; i++) {
            if (
                this.pommePosition[0] == this.snakeBody[i][0] &&
                this.pommePosition[1] == this.snakeBody[i][1]
            ) {
                IsOnSnake = true;
            }
        }
        return IsOnSnake;
    }
}

// Instanciation de la classe Canvas
let canvas1 = new Canvas(
    document.getElementById("canvas"),
    [
        [6, 4],
        [5, 4],
        [4, 4],
    ],
    "right",
    [10, 10]
);