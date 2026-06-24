# TechWay Website

Static website for techway.tech.

## Files

- `index.html` - main page
- `styles.css` - site styling and responsive layout
- `script.js` - mobile navigation behavior
- `assets/techway-logo.png` - TechWay logo
- `assets/clients/` - client logo images
- `generate-clients-data.js` - generates the clients list used by `clients.html`

## Updating clients

Add or remove images in `assets/clients/`, then run:

```sh
node generate-clients-data.js
```

The script updates `assets/clients/clients-data.js`, and `clients.html` renders the client logos from that file.

Upload the root files and `assets/` folder to the hosting public directory.
