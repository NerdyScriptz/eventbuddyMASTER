const express = require("express");
const { join } = require("path");
const app = express();

// Serve static assets from the /www folder
app.use(express.static(join(__dirname, "www")));

// Endpoint to serve the configuration file
app.get("/auth_config.json", (req, res) => {
  res.sendFile(join(__dirname, "www", "auth-config.json"));
});

// Serve the index page for all other requests
app.get("/*", (_, res) => {
  res.sendFile(join(__dirname, "www", "index.html"));
});

// Listen on port 3000
app.listen(3000, () => console.log("Application running on port 3000"));
