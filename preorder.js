const preorderPopup = document.getElementById("preorder-popup");
const openPreorderBtn = document.getElementById("preorder-link");
const closePreorderBtn = document.getElementById("close-preorder-btn");
const preorderForm = document.getElementById("preorder-form");
const preorderConfirm = document.getElementById("preorder-confirmation");

const foodCategory = document.getElementById("food-category");
const foodItem = document.getElementById("food-item");

// const subItems = {
//   SriLankan: [
//     "Chicken Fried Rice",
//     "Egg Fried Rice",
//     "Mix Fried Rice",
//     "Seafood Fried Rice",
//     "Vegetable Fried Rice",
//   ],
//   Chinese: [
//     "Chili Chicken",
//     "Sweet and Sour Pork",
//     "Beef with Broccoli",
//     "Spring Rolls",
//     "Vegetable Noodles",
//   ],
//   Italian: [
//     "Spaghetti Bolognese",
//     "Lasagna",
//     "Fettuccine Alfredo",
//     "Margherita Pizza",
//     "Pasta Carbonara",
//   ],
// };

// 🔄 Fetch categories on load
function loadCategories() {
  fetch("get_meal_data.php")
    .then((res) => res.json())
    .then((data) => {
      foodCategory.innerHTML = `<option value="">-- Select Category --</option>`;
      data.categories.forEach((cat) => {
        const opt = document.createElement("option");
        opt.value = cat;
        opt.textContent = cat;
        foodCategory.appendChild(opt);
      });
    })
    .catch((err) => console.error("Error loading categories:", err));
}

// // Populate dish options based on category
// foodCategory.addEventListener("change", function () {
//   const selected = this.value;
//   foodItem.innerHTML = `<option value="">-- Select Dish --</option>`;
//   if (subItems[selected]) {
//     subItems[selected].forEach((dish) => {
//       const option = document.createElement("option");
//       option.value = dish;
//       option.textContent = dish;
//       foodItem.appendChild(option);
//     });
//   }
// });

// 🔄 Fetch meals for selected category
foodCategory.addEventListener("change", function () {
  const selected = this.value;
  foodItem.innerHTML = `<option value="">-- Select Dish --</option>`;

  if (!selected) return;

  fetch(`get_meal_data.php?category=${encodeURIComponent(selected)}`)
    .then((res) => res.json())
    .then((data) => {
      data.meals.forEach((meal) => {
        const opt = document.createElement("option");
        opt.value = meal;
        opt.textContent = meal;
        foodItem.appendChild(opt);
      });
    })
    .catch((err) => console.error("Error loading meals:", err));
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

  fetch("submit_preorder.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      name,
      phone,
      category,
      dish,
      quantity,
      arrival_time: time,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        preorderConfirm.innerHTML = `
          ✅ Thank you, ${name}!<br>
          Your order for <strong>${quantity} x ${dish}</strong> (${category}) is confirmed.<br>
          Arrival time: <strong>${time}</strong>
        `;
        preorderConfirm.style.display = "block";
        preorderForm.style.display = "none";
      } else {
        alert("❌ Error: " + data.error);
      }
    })
    .catch((err) => {
      console.error("Error submitting preorder:", err);
      alert("❌ Failed to submit your order. Please try again later.");
    });
});
