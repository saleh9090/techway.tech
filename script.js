const toggle = document.querySelector("[data-nav-toggle]");
const nav = document.querySelector("[data-nav]");
const header = document.querySelector("[data-header]");
const clientLogoGrid = document.querySelector("[data-client-logo-grid]");

if (toggle && nav) {
  toggle.addEventListener("click", () => {
    const isOpen = nav.classList.toggle("is-open");
    toggle.setAttribute("aria-expanded", String(isOpen));
  });

  nav.addEventListener("click", (event) => {
    if (event.target instanceof HTMLAnchorElement) {
      nav.classList.remove("is-open");
      toggle.setAttribute("aria-expanded", "false");
    }
  });
}

if (header) {
  const updateHeader = () => {
    header.classList.toggle("is-scrolled", window.scrollY > 12);
  };

  updateHeader();
  window.addEventListener("scroll", updateHeader, { passive: true });
}

if (clientLogoGrid && Array.isArray(window.TECHWAY_CLIENTS)) {
  const fragment = document.createDocumentFragment();

  window.TECHWAY_CLIENTS.forEach((client) => {
    const frame = document.createElement("div");
    const image = document.createElement("img");

    frame.className = "client-logo-frame";
    image.src = client.src;
    image.alt = `${client.name} logo`;

    frame.append(image);
    fragment.append(frame);
  });

  clientLogoGrid.append(fragment);
}
