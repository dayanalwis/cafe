const openBtn = document.getElementById("register-btn");
const popup = document.getElementById("register-popup");
const closeBtn = document.getElementById("close-popup");

openBtn.addEventListener("click", () => {
  popup.style.display = "flex";
});

closeBtn.addEventListener("click", () => {
  popup.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === popup) {
    popup.style.display = "none";
  }
});

const lankaBtn = document.getElementById("breakfast-btn");
const lankapopup = document.getElementById("srilankan-menu-popup");
const lankacloseBtn = document.getElementById("close-lanka-menu-btn");

// lankaBtn.addEventListener("click", () => {
//   lankapopup.style.display = "flex";
// });

lankaBtn.addEventListener("click", () => {
  fetch("get_srilankan_meals.php")
    .then((response) => response.json())
    .then((meals) => {
      const container = document.getElementById("srilankan-meals-list");
      container.innerHTML = ""; // Clear existing

      if (meals.length === 0) {
        container.innerHTML = "<p>No Sri Lankan meals found.</p>";
        return;
      }

      meals.forEach((meal) => {
        const mealDiv = document.createElement("div");
        mealDiv.classList.add("meal-item");
        mealDiv.innerHTML = `
          <h3>${meal.name}</h3>
          <p>Price: Rs. ${meal.price}</p>
          <p>${meal.description || ""}</p>
          <hr/>
        `;
        container.appendChild(mealDiv);
      });

      lankapopup.style.display = "flex";
    })
    .catch((error) => {
      console.error("Error fetching meals:", error);
    });
});

lankacloseBtn.addEventListener("click", () => {
  lankapopup.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === lankapopup) {
    lankapopup.style.display = "none";
  }
});

const chineseBtn = document.getElementById("lunch-btn");
const chinesepopup = document.getElementById("chinese-menu-popup");
const chinesecloseBtn = document.getElementById("close-chinese-menu-btn");

chineseBtn.addEventListener("click", () => {
  chinesepopup.style.display = "flex";
});

chinesecloseBtn.addEventListener("click", () => {
  chinesepopup.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === chinesepopup) {
    chinesepopup.style.display = "none";
  }
});

const italyBtn = document.getElementById("dinner-btn");
const italypopup = document.getElementById("italy-menu-popup");
const italycloseBtn = document.getElementById("close-italy-menu-btn");

italyBtn.addEventListener("click", () => {
  italypopup.style.display = "flex";
});

italycloseBtn.addEventListener("click", () => {
  italypopup.style.display = "none";
});

window.addEventListener("click", (e) => {
  if (e.target === italypopup) {
    italypopup.style.display = "none";
  }
});

const specialBtn = document.getElementById("special");
const specialpopup = document.getElementById("special-menu-popup");
const specialcloseBtn = document.getElementById("close-special-menu-btn");
const foodVideo = document.getElementById("food-menu");
const drinkVideo = document.getElementById("drink-menu");
const nextBtn = document.getElementById("next-drink-btn");

specialBtn.addEventListener("click", () => {
  specialpopup.style.display = "flex";
  foodVideo.style.display = "block";
  drinkVideo.style.display = "none";
});

specialcloseBtn.addEventListener("click", () => {
  specialpopup.style.display = "none";
});

nextBtn.addEventListener("click", () => {
  foodVideo.style.display = "none";
  drinkVideo.style.display = "block ";
});

window.addEventListener("click", (e) => {
  if (e.target === specialpopup) {
    specialpopup.style.display = "none";
  }
});
