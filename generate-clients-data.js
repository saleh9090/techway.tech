const fs = require("fs");
const path = require("path");

const clientsDir = path.join(__dirname, "assets", "clients");
const outputFile = path.join(clientsDir, "clients-data.js");
const imageExtensions = new Set([".jpg", ".jpeg", ".png", ".webp", ".svg", ".gif"]);

const nameOverrides = {
  abuhilal: "Abu Hilal",
  alamirtanks: "Al Amir Tanks",
  alsamdi: "Al Samdi Water",
  cdegree: "C Degree",
  ghernatah: "Ghernatah",
  ibda2: "Ibda2",
  karakamsalim: "Karak Am Salim",
  manba: "Manba",
  safari: "Safari",
  "toten-logo": "Toten",
};

const toDisplayName = (filename) => {
  const basename = path.basename(filename, path.extname(filename));

  if (nameOverrides[basename]) {
    return nameOverrides[basename];
  }

  return basename
    .replace(/[-_]+/g, " ")
    .replace(/\blogo\b/gi, "")
    .trim()
    .replace(/\b\w/g, (letter) => letter.toUpperCase());
};

const clients = fs
  .readdirSync(clientsDir, { withFileTypes: true })
  .filter((entry) => entry.isFile())
  .map((entry) => entry.name)
  .filter((filename) => imageExtensions.has(path.extname(filename).toLowerCase()))
  .sort((a, b) => a.localeCompare(b, "en"))
  .map((filename) => ({
    name: toDisplayName(filename),
    src: `assets/clients/${filename}`,
  }));

const output = `window.TECHWAY_CLIENTS = ${JSON.stringify(clients, null, 2)};\n`;

fs.writeFileSync(outputFile, output);
console.log(`Generated ${path.relative(__dirname, outputFile)} with ${clients.length} clients.`);
