import "../css/playerForm.css";
import { useState } from "react";

const PlayerForm = ({ onSubmit }) => {
  const [player1, setPlayer1] = useState("");
  const [level1, setLevel1] = useState(1);
  const [player2, setPlayer2] = useState("");
  const [level2, setLevel2] = useState(1);

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit({ player1, level1, player2, level2 });
  };

  return (
    <form className="form-container dark-mode" onSubmit={handleSubmit}>
      <p>NOM</p>
      <input
        type="text"
        placeholder="Nom Joueur 1"
        value={player1}
        onChange={(e) => setPlayer1(e.target.value)}
        required
      />
      <p>NIVEAU</p>
      <input
        type="number"
        placeholder="Niveau 1-10"
        min="1"
        max="10"
        value={level1}
        onChange={(e) => setLevel1(parseInt(e.target.value))}
        required
      />
      <p>NOM</p>
      <input
        type="text"
        placeholder="Nom Joueur 2"
        value={player2}
        onChange={(e) => setPlayer2(e.target.value)}
        required
      />
      <p>NIVEAU</p>
      <input
        type="number"
        placeholder="Niveau 1-10"
        min="1"
        max="10"
        value={level2}
        onChange={(e) => setLevel2(parseInt(e.target.value))}
        required
      />
      <button type="submit">Lancer la Simulation</button>
    </form>
  );
};

export default PlayerForm;
