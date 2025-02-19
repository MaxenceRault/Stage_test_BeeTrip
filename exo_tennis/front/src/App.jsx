import React, { useState } from "react";
import PlayerForm from "./components/playerForm";
import MatchSimulation from "./components/matchSimulation";
import ScoreDisplay from "./components/scoreDisplay";

const App = () => {
    const [player1, setPlayer1] = useState("");
    const [level1, setLevel1] = useState(1);
    const [player2, setPlayer2] = useState("");
    const [level2, setLevel2] = useState(1);
    const [score, setScore] = useState(null);
    const [matchStarted, setMatchStarted] = useState(false);

    const handleFormSubmit = ({ player1, level1, player2, level2 }) => {
        setPlayer1(player1);
        setLevel1(level1);
        setPlayer2(player2);
        setLevel2(level2);
        setMatchStarted(true);  // Activer le match après soumission du formulaire
    };

    const handleScoreUpdate = (newScore) => {
        setScore(newScore);
    };

    return (  
        <div>
            <PlayerForm onSubmit={handleFormSubmit} />
            {matchStarted && (
                <MatchSimulation
                    player1={player1}
                    player2={player2}
                    level1={level1}
                    level2={level2}
                    onScoreUpdate={handleScoreUpdate}
                />
            )}
            <ScoreDisplay score={score} player1={player1} player2={player2} />
        </div>
    );
};

export default App;
