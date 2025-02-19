import React, { useState } from "react";
import "../css/matchSimulation.css";

const MatchSimulation = ({
  player1,
  player2,
  level1,
  level2,
  onScoreUpdate,
}) => {
  const [points, setPoints] = useState([]);

  const generatePoints = () => {
    let newPoints = [];
    for (let i = 0; i < 150; i++) {
      let winner = Math.random() < level1 / (level1 + level2) ? 1 : 2;
      newPoints.push(winner);
    }
    setPoints(newPoints);
    processMatch(newPoints);
  };

  const processMatch = (points) => {
    let player1Games = 0,
      player2Games = 0;
    let player1Sets = 0,
      player2Sets = 0;
    let sets = [];
    let currentGame = [0, 0];

    for (let point of points) {
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

      if (player1Sets === 3 || player2Sets === 3) {
        break;
      }
    }

    const newScore = {
      sets,
      player1Games,
      player2Games,
      currentGame,
      player1Sets,
      player2Sets,
      winner: player1Sets === 3 ? player1 : player2Sets === 3 ? player2 : null,
    };

    onScoreUpdate(newScore);
  };

  return (
    <div className="simulation-container">
      <button onClick={generatePoints}>🎾 Générer les Points</button>
      <ul>
        {points.map((point, index) => (
          <li key={index}>
            Point {index + 1} : remporté par {point === 1 ? player1 : player2}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default MatchSimulation;
