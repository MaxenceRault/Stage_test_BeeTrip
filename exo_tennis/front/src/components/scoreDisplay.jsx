import React from "react";
import "../css/scoreDisplay.css";

const ScoreDisplay = ({ score, player1, player2 }) => {
  if (!score) return null;

  return (
    <div className="score-container">
      <h3>
        {score.winner
          ? `🏆 Vainqueur : ${score.winner}`
          : "🎾 Résultat : Jeu en cours, pas de vainqueur"}
      </h3>

      <table>
        <thead>
          <tr>
            <th></th>
            {score.sets.map((_, index) => (
              <th key={index}>Set {index + 1}</th>
            ))}
            <th>Current Game</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{player1}</td>
            {score.sets.map((set, index) => (
              <td key={index}>{set[0]}</td>
            ))}
            <td>{score.currentGame[0] > score.currentGame[1] ? "AV" : "-"}</td>
          </tr>
          <tr>
            <td>{player2}</td>
            {score.sets.map((set, index) => (
              <td key={index}>{set[1]}</td>
            ))}
            <td>{score.currentGame[1] > score.currentGame[0] ? "AV" : "-"}</td>
          </tr>
        </tbody>
      </table>
    </div>
  );
};

export default ScoreDisplay;
