document.addEventListener("DOMContentLoaded", () => {
  const search = document.getElementById("gameSearch");
  const grid = document.getElementById("gameGrid");
  const empty = document.getElementById("emptyState");
  const buttons = document.querySelectorAll("#categoryFilters [data-category]");
  if (!search || !grid) return;

  let category = "Todos";
  function filterGames() {
    const term = search.value.trim().toLocaleLowerCase("pt-BR");
    let visible = 0;
    grid.querySelectorAll(".game-card").forEach(card => {
      const title = card.dataset.title || "";
      const cat = card.dataset.category || "";
      const matches = title.includes(term) && (category === "Todos" || cat === category);
      card.hidden = !matches;
      if (matches) visible++;
    });
    if (empty) empty.hidden = visible !== 0;
  }
  search.addEventListener("input", filterGames);
  buttons.forEach(button => button.addEventListener("click", () => {
    category = button.dataset.category;
    buttons.forEach(b => b.classList.toggle("selected", b === button));
    filterGames();
  }));
});
