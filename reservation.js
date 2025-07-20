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

  const name = document.getElementById("res-name").value;
  const phone = document.getElementById("res-phone").value;
  const table_type = zoneSelect.value;
  const guest_count = parseInt(guestInput.value);

  if (!table_type || isNaN(guest_count)) {
    alert("Please select a zone and number of guests.");
    return;
  }

  fetch("submit_reservation.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      name,
      phone,
      table_type,
      guest_count,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        resConfirm.innerHTML = `
          ✅ Thank you, ${name}!<br>
          Your reservation for <strong>${guest_count} guests</strong> and table type (${table_type}) is confirmed.<br>
        `;
        resConfirm.style.display = "block";
        resForm.style.display = "none";
      } else {
        alert("❌ Error: " + data.error);
      }
    })
    .catch((err) => {
      console.error("Error submitting reservation:", err);
      alert("❌ Failed to submit your reservation. Please try again later.");
    });

  // if (zone === "private") {
  //   if (guests < 8 || guests > 12) {
  //     alert("Private rooms allow 8 to 12 guests only.");
  //     return;
  //   }
  //   if (tables.private.total <= 0) {
  //     alert("No private rooms available.");
  //     return;
  //   }
  //   tables.private.total -= 1;
  // } else {
  //   const neededTables = Math.ceil(guests / tables[zone].seatsPerTable);
  //   if (neededTables > tables[zone].total) {
  //     alert(
  //       `Not enough ${zone} tables available. Only ${tables[zone].total} left.`
  //     );
  //     return;
  //   }
  //   tables[zone].total -= neededTables;
  // }

  // updateAvailabilityMessage();

  // resConfirm.innerHTML = `
  //   ✅ Table reserved for ${guests} guests in <strong>${zone}</strong> area.`;
  // resConfirm.style.display = "block";
  // resForm.style.display = "none";
});
