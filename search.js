const searchBox = document.getElementById("search-box");

searchBox.addEventListener("input", () => {
  const searchTerm = searchBox.value.toLowerCase().trim();
  const cards = document.querySelectorAll(".meal-card");

  cards.forEach((card) => {
    const title = card.querySelector("h2").textContent.toLowerCase();
    card.style.display = title.includes(searchTerm) ? "flex" : "none";
  });
});

searchBox.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    searchBox.value = "";
    cards.forEach((card) => (card.style.display = "flex"));
  }
});
