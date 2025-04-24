const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");

let gameSpeed = 5;
let gravity = 0.5;
let gameOver = false;
let score = 0;
let highScore = 0;

let cienSound = new Audio("cien.mp3");
cienSound.load();

let popSound = new Audio("pop.mp3"); // sonido al saltar
popSound.load();

let dinoImg = new Image();
dinoImg.src = "css/dino.png";

let dinoVerdeImg = new Image();
dinoVerdeImg.src = "css/dinoverde.png"; // ✅ NUEVA imagen para salto

let cactusImg = new Image();
cactusImg.src = "css/cactus.png";

let dino = {
  x: 50,
  y: canvas.height - 47,
  width: 44,
  height: 47,
  vy: 0,
  isJumping: false,
};

let obstacle = {
  x: canvas.width,
  y: canvas.height - 40,
  width: 25,
  height: 40
};

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
    cienSound.currentTime = 0;
    cienSound.play();
  }

  if (dino.isJumping) {
    dino.vy += gravity;
    dino.y += dino.vy;
    if (dino.y >= canvas.height - dino.height) {
      dino.y = canvas.height - dino.height;
      dino.isJumping = false;
      dino.vy = 0;
    }
  }

  obstacle.x -= gameSpeed;
  if (obstacle.x + obstacle.width < 0) {
    obstacle.x = canvas.width + Math.random() * 200;
  }

  if (collision(dino, obstacle)) {
    gameOver = true;
    document.getElementById("restartBtn").style.display = "block";
    if (score > highScore) highScore = score;
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
  ctx.fillText("High Score: " + highScore, 480, 25);

  let currentDinoImg = dino.isJumping ? dinoVerdeImg : dinoImg;

  if (!currentDinoImg.complete) {
    ctx.fillStyle = "green";
    ctx.fillRect(dino.x, dino.y, dino.width, dino.height);
  } else {
    ctx.drawImage(currentDinoImg, dino.x, dino.y, dino.width, dino.height);
  }

  if (!cactusImg.complete) {
    ctx.fillStyle = "brown";
    ctx.fillRect(obstacle.x, obstacle.y, obstacle.width, obstacle.height);
  } else {
    ctx.drawImage(cactusImg, obstacle.x, obstacle.y, obstacle.width, obstacle.height);
  }
}

document.addEventListener("keydown", function (e) {
  if (e.code === "Space" && !dino.isJumping && !gameOver) {
    dino.isJumping = true;
    dino.vy = -10;
    popSound.currentTime = 0;
    popSound.play();
    e.preventDefault();
  }
});

document.getElementById("restartBtn").addEventListener("click", function () {
  gameOver = false;
  score = 0;
  dino.y = canvas.height - dino.height;
  dino.isJumping = false;
  dino.vy = 0;
  obstacle.x = canvas.width;
  gameSpeed = 5;
  this.style.display = "none";
  gameLoop();
});

window.onload = function () {
  gameLoop();
};
