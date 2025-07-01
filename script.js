function checkGuess() {
  const guess = document.getElementById("guessInput").value.trim();
  if (!guess) return;

  fetch("check_guess.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "guess=" + encodeURIComponent(guess),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.error) {
        document.getElementById("feedback").innerText = data.error;
        return;
      }

      const tableBody = document.querySelector("#attemptsTable tbody");
      const row = document.createElement("tr");

      ["name", "campanha", "tipo", "especie", "funcao", "idade"].forEach((key) => {
        const cell = document.createElement("td");
        cell.textContent = data.guess[key];

        if (data.comparison[key] === "correct") cell.className = "correct";
        else if (data.comparison[key] === "partial") cell.className = "partial";
        else cell.className = "wrong";

        row.appendChild(cell);
      });

      tableBody.appendChild(row);

      if (data.comparison.name === "correct") {
        document.getElementById("feedback").innerText = "Parabéns! Você acertou!";
      }
    });
}
