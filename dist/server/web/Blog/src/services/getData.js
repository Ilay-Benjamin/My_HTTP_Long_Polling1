"use strict";
function longPolling() {
    // Make a request to the long-polling.php script
    fetch('http://localhost:8010/app.php')
        .then(response => response.json())
        .then(data => {
        // Handle the received data (e.g., update the UI)
        if (data.data) {
            console.log(data.data);
        }
        // Make the next long-polling request
        longPolling();
    });
}
// Start the long-polling process
document.getElementById("long_polling_btn").addEventListener("click", () => {
    longPolling();
});
console.log("getData.ts loaded");
