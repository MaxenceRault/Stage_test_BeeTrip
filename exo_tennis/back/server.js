const express = require("express");
const cors = require("cors");

const app = express();
app.use(express.json());
app.use(cors());

app.post("/calculate-score", (req, res) => {
  const points = req.body.points;

  if (!points || !Array.isArray(points)) {
    return res.status(400).json({ error: "Invalid data" });
  }

  const result = calculateScore(points);
  res.json(result);
});

function calculateScore(points) {
  let player1Games = 0,
    player2Games = 0;
  let player1Sets = 0,
    player2Sets = 0;
  let currentGame = [0, 0];
  let sets = [];

  points.forEach((point) => {
    if (point === 1) currentGame[0]++;
    else currentGame[1]++;

    if (currentGame[0] >= 4 && currentGame[0] - currentGame[1] >= 2) {
      player1Games++;
      currentGame = [0, 0];
    } else if (currentGame[1] >= 4 && currentGame[1] - currentGame[0] >= 2) {
      player2Games++;
      currentGame = [0, 0];
    }

    if (player1Games >= 6 && player1Games - player2Games >= 2) {
      sets.push([player1Games, player2Games]);
      player1Sets++;
      player1Games = 0;
      player2Games = 0;
    } else if (player2Games >= 6 && player2Games - player1Games >= 2) {
      sets.push([player1Games, player2Games]);
      player2Sets++;
      player1Games = 0;
      player2Games = 0;
    }
  });

  let winner = null;
  if (player1Sets === 3) winner = "Joueur 1";
  else if (player2Sets === 3) winner = "Joueur 2";

  return {
    winner,
    sets,
    player1Games,
    player2Games,
    currentGame,
  };
}

const PORT = 3000;
app.listen(PORT, () => console.log(`✅ Server running on port ${PORT}`));
