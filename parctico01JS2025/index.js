const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");

let gameSpeed = 5;
let gravity = 0.5;
let gameOver = false;
let score = 0;
let highScore = 0;

const jumpSound = new Audio("jump.mp3");
const pointSound = new Audio("point.mp3");

let dinoColors = ["green", "blue", "purple", "orange", "red"];

let dino = {
    x: 50,
    y: canvas.height - 47,
    width: 44,
    height: 47,
    vy: 0,
    isJumping: false,
    color: "green"
};

let obstacle = {
    x: canvas.width,
    y: canvas.height - 40,
    width: 25,
    height: 40
};

dinoImg.src = "css/dino.png";
cactusImg.src = "css/cactus.png";

function gameLoop() {
    if (!gameOver) {
        update();
        draw();
        requestAnimationFrame(gameLoop);
    }
}

function update() {
    score++;

    if (score % 100 === 0) {
        gameSpeed += 0.5;
        pointSound.play();
    }

    if (score > highScore) {
        highScore = score;
        document.getElementById("highScore").innerText = "High Score: " + highScore;
    }

    if (dino.isJumping) {
        dino.vy += gravity;
        dino.y += dino.vy;
        if (dino.y >= canvas.height - dino.height) {
            dino.y = canvas.height - dino.height;
            dino.isJumping = false;
            dino.vy = 0;
            dino.color = "green"; // vuelve al color base
        }
    }

    obstacle.x -= gameSpeed;
    if (obstacle.x + obstacle.width < 0) {
        obstacle.x = canvas.width + Math.random() * 200;
    }

    if (collision(dino, obstacle)) {
        gameOver = true;
        document.getElementById("restartBtn").style.display = "block";
    }
}

function collision(rect1, rect2) {
    return (
        rect1.x < rect2.x + rect2.width &&
        rect1.x + rect1.width > rect2.x &&
        rect1.y < rect2.y + rect2.height &&
        rect1.y + rect1.height > rect2.y
    );
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.fillStyle = "#000";
    ctx.font = "20px Arial";
    ctx.fillText("Score: " + score, 10, 25);

    if (dinoImg.complete && !dino.isJumping) {
        ctx.drawImage(dinoImg, dino.x, dino.y, dino.width, dino.height);
    } else {
        ctx.fillStyle = dino.color;
        ctx.fillRect(dino.x, dino.y, dino.width, dino.height);
    }

    if (cactusImg.complete) {
        ctx.drawImage(cactusImg, obstacle.x, obstacle.y, obstacle.width, obstacle.height);
    } else {
        ctx.fillStyle = "brown";
        ctx.fillRect(obstacle.x, obstacle.y, obstacle.width, obstacle.height);
    }
}

document.addEventListener("keydown", function(e) {
    if (e.code === "Space" && !dino.isJumping && !gameOver) {
        dino.isJumping = true;
        dino.vy = -10;
        dino.color = dinoColors[Math.floor(Math.random() * dinoColors.length)];
        jumpSound.play();
        e.preventDefault();
    }
});

document.getElementById("restartBtn").addEventListener("click", function() {
    gameOver = false;
    score = 0;
    gameSpeed = 5;
    dino.y = canvas.height - dino.height;
    dino.isJumping = false;
    dino.vy = 0;
    obstacle.x = canvas.width;
    this.style.display = "none";
    gameLoop();
});

window.onload = function() {
    gameLoop();
};
