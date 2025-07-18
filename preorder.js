const preorderPopup = document.getElementById("preorder-popup");
const openPreorderBtn = document.getElementById("preorder-link");
const closePreorderBtn = document.getElementById("close-preorder-btn");
const preorderForm = document.getElementById("preorder-form");
const preorderConfirm = document.getElementById("preorder-confirmation");

const foodCategory = document.getElementById("food-category");
const foodItem = document.getElementById("food-item");

const subItems = {
  SriLankan: [
    "Chicken Fried Rice",
    "Egg Fried Rice",
    "Mix Fried Rice",
    "Seafood Fried Rice",
    "Vegetable Fried Rice",
  ],
  Chinese: [
    "Chili Chicken",
    "Sweet and Sour Pork",
    "Beef with Broccoli",
    "Spring Rolls",
    "Vegetable Noodles",
  ],
  Italian: [
    "Spaghetti Bolognese",
    "Lasagna",
    "Fettuccine Alfredo",
    "Margherita Pizza",
    "Pasta Carbonara",
  ],
};

// Populate dish options based on category
foodCategory.addEventListener("change", function () {
  const selected = this.value;
  foodItem.innerHTML = `<option value="">-- Select Dish --</option>`;
  if (subItems[selected]) {
    subItems[selected].forEach((dish) => {
      const option = document.createElement("option");
      option.value = dish;
      option.textContent = dish;
      foodItem.appendChild(option);
    });
  }
});

// Open popup
if (openPreorderBtn) {
  openPreorderBtn.addEventListener("click", () => {
    preorderPopup.style.display = "flex";
    preorderForm.style.display = "block";
    preorderConfirm.style.display = "none";
  });
}

// Close popup
closePreorderBtn.addEventListener("click", () => {
  preorderPopup.style.display = "none";
  preorderForm.reset();
  foodItem.innerHTML = `<option value="">-- Select Dish --</option>`;
});

// Click outside to close
window.addEventListener("click", (e) => {
  if (e.target === preorderPopup) {
    preorderPopup.style.display = "none";
    preorderForm.reset();
    foodItem.innerHTML = `<option value="">-- Select Dish --</option>`;
  }
});

// Handle form submit
preorderForm.addEventListener("submit", function (e) {
  e.preventDefault();

  const name = document.getElementById("preorder-name").value;
  const phone = document.getElementById("preorder-phone").value;
  const category = foodCategory.value;
  const dish = foodItem.value;
  const time = document.getElementById("preorder-time").value;
  const quantity = document.getElementById("quantity").value;

  if (!name || !phone || !category || !dish || !time || !quantity) {
    alert("Please fill in all fields.");
    return;
  }

  preorderConfirm.innerHTML = `
    ✅ Thank you, ${name}!<br>
    Your order for <strong>${quantity} x ${dish}</strong> (${category}) is confirmed.<br>
    Arrival time: <strong>${time}</strong>
  `;
  preorderConfirm.style.display = "block";
  preorderForm.style.display = "none";
});
