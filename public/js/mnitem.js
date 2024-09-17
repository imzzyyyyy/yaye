// Get the modal and button elements
var modal = document.getElementById("myModal");
var btn = document.getElementById("addButton");
var span = document.getElementsByClassName("close")[0];
var cancelBtn = document.querySelector(".button.cancel .button-text"); // Get the Cancel button

// Show the modal when the button is clicked
btn.onclick = function() {
  modal.style.display = "block";
}

// Hide the modal when the close icon is clicked
span.onclick = function() {
  modal.style.display = "none";
}

// Hide the modal when the cancel button is clicked
cancelBtn.onclick = function() {
  modal.style.display = "none";
}

// Hide the modal when clicking outside the modal content
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
