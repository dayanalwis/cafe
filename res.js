let tables = {
  inside: { total: 10, seatsPerTable: 5 },
  outside: { total: 4, seatsPerTable: 5 },
  private: { total: 2, seatsPerRoom: 12 },
};

const openResBtn = document.getElementById("open-reservation");
const resPopup = document.getElementById("reservation-popup");
const closeResBtn = document.getElementById("close-reservation");
const resForm = document.getElementById("reservation-form");
const resConfirm = document.getElementById("res-confirmation");

const zoneSelect = document.getElementById("res-zone");
const guestInput = document.getElementById("res-guests");
const availabilityInfo = document.getElementById("availability-info");

// Show popup
openResBtn.addEventListener("click", (e) => {
  e.preventDefault();
  resPopup.style.display = "flex";
  resForm.style.display = "block";
  resConfirm.style.display = "none";
  updateAvailabilityMessage();
});

// Close popup
closeResBtn.addEventListener("click", () => {
  resPopup.style.display = "none";
  resForm.reset();
});

// Click outside to close
window.addEventListener("click", (e) => {
  if (e.target === resPopup) {
    resPopup.style.display = "none";
    resForm.reset();
  }
});

// Update availability
zoneSelect.addEventListener("change", updateAvailabilityMessage);

function updateAvailabilityMessage() {
  const zone = zoneSelect.value;
  if (zone === "inside" || zone === "outside") {
    availabilityInfo.textContent = `Available: ${tables[zone].total} tables (${tables[zone].seatsPerTable} seats each)`;
  } else if (zone === "private") {
    availabilityInfo.textContent = `Available: ${tables.private.total} rooms (8–12 people per room)`;
  } else {
    availabilityInfo.textContent = "Available:";
  }
}

// Handle form submission
resForm.addEventListener("submit", function (e) {
  e.preventDefault();

  const zone = zoneSelect.value;
  const guests = parseInt(guestInput.value);

  if (!zone || isNaN(guests)) {
    alert("Please select a zone and number of guests.");
    return;
  }

  if (zone === "private") {
    if (guests < 8 || guests > 12) {
      alert("Private rooms allow 8 to 12 guests only.");
      return;
    }
    if (tables.private.total <= 0) {
      alert("No private rooms available.");
      return;
    }
    tables.private.total -= 1;
  } else {
    const neededTables = Math.ceil(guests / tables[zone].seatsPerTable);
    if (neededTables > tables[zone].total) {
      alert(
        `Not enough ${zone} tables available. Only ${tables[zone].total} left.`
      );
      return;
    }
    tables[zone].total -= neededTables;
  }

  updateAvailabilityMessage();

  resConfirm.innerHTML = `
    ✅ Table reserved for ${guests} guests in <strong>${zone}</strong> area.`;
  resConfirm.style.display = "block";
  resForm.style.display = "none";
});
