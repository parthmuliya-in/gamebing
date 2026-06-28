/* ================= CURSOR ANIMATION ================= */
const cursor = document.querySelector(".cursor");
const ring = document.querySelector(".cursor-ring");

let mouseX = 0,
  mouseY = 0,
  posX = 0,
  posY = 0;

document.addEventListener("mousemove", (e) => {
  mouseX = e.clientX;
  mouseY = e.clientY;

  cursor.style.left = mouseX + "px";
  cursor.style.top = mouseY + "px";
});

function animate() {
  posX += (mouseX - posX) * 0.12;
  posY += (mouseY - posY) * 0.12;

  ring.style.left = posX + "px";
  ring.style.top = posY + "px";

  requestAnimationFrame(animate);
}
animate();

// ********************************************************************

const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("nav-links");

if (hamburger && navLinks) {
  hamburger.addEventListener("click", () => {
    navLinks.classList.toggle("show");
    hamburger.classList.toggle("active");
  });
}

// ********************************************************************

/* TEXT ANIMATION */
const heading = document.querySelector(".about-heading");

new IntersectionObserver(
  (entries) => {
    if (entries[0].isIntersecting) {
      heading.classList.add("active");
    }
  },
  { threshold: 0.5 },
).observe(heading);

/* ===== EMOJI GENERATOR ===== */
const emojiContainer = document.querySelector(".emoji-container");

const emojis = ["🎮", "🔥", "⚔️", "🎯", "👾", "💣", "🚀"];

for (let i = 0; i < 12; i++) {
  let emoji = document.createElement("div");
  emoji.className = "emoji";
  emoji.innerHTML = emojis[Math.floor(Math.random() * emojis.length)];

  emoji.style.left = Math.random() * 100 + "%";
  emoji.style.animationDuration = 5 + Math.random() * 5 + "s";
  emoji.style.animationDelay = Math.random() * 5 + "s";

  emojiContainer.appendChild(emoji);
}

/* ===== PARTICLES GENERATOR ===== */
const banner = document.querySelector(".banner");

for (let i = 0; i < 25; i++) {
  let p = document.createElement("div");
  p.className = "particle";

  p.style.left = Math.random() * 100 + "%";
  p.style.bottom = "-10px";
  p.style.animationDuration = 3 + Math.random() * 4 + "s";
  p.style.animationDelay = Math.random() * 5 + "s";

  banner.appendChild(p);
}

// ********************************************************************

/* ===== COUNTER ===== */
const counters = document.querySelectorAll(".counter h3");
const counterSection = document.querySelector("#gamingSection");

if (counterSection && counters.length > 0) {
  const counterObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          counters.forEach((counter) => {
            const targetText = counter.getAttribute("data-target"); // e.g., "1500+"
            const numberMatch = targetText.match(/\d+/); // extract numeric part
            const suffix = targetText.replace(numberMatch[0], ""); // get suffix like + or /7
            const target = numberMatch ? parseInt(numberMatch[0]) : 0;

            let count = 0;

            const update = () => {
              const increment = target / 100; // adjust speed

              if (count < target) {
                count += increment;
                counter.innerText = Math.ceil(count) + suffix;
                requestAnimationFrame(update);
              } else {
                counter.innerText = target + suffix;
              }
            };

            update();
          });

          counterObserver.disconnect();
        }
      });
    },
    { threshold: 0.5 },
  );

  counterObserver.observe(counterSection);
}

/* ===== SECTION SCROLL EFFECT ===== */
const gamingSection = document.querySelector("#gamingSection");

if (gamingSection) {
  const sectionObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          gamingSection.style.opacity = 1;
          gamingSection.style.transform = "translateY(0)";
        }
      });
    },
    { threshold: 0.3 },
  );

  sectionObserver.observe(gamingSection);
}

// ********************************************************************

/* SECTION ANIMATION */
const section = document.getElementById("featureSection");
const boxes = document.querySelectorAll(".feature-box");

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        section.classList.add("show");

        boxes.forEach((box) => {
          box.classList.add("show");
        });
      }
    });
  },
  { threshold: 0.3 },
);

observer.observe(section);

// ********************************************************************

/* TEXT ANIMATION */
const content = document.querySelector(".content");

if (content) {
  const obs = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting) {
        content.classList.add("show");
      }
    },
    { threshold: 0.5 },
  );

  obs.observe(content);
}

/* 3D HOVER */
const card = document.getElementById("card");

if (card && window.innerWidth > 768) {
  card.addEventListener("mousemove", (e) => {
    const rect = card.getBoundingClientRect();

    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    const moveX = (x - rect.width / 2) / 25;
    const moveY = (y - rect.height / 2) / 25;

    card.style.transform = `rotateY(${moveX}deg) rotateX(${-moveY}deg)`;
  });

  card.addEventListener("mouseleave", () => {
    card.style.transform = "rotateY(0) rotateX(0)";
  });
}

// ********************************************************************

const track = document.getElementById("track");
let slides = Array.from(track.children);

let visibleSlides = 5; // default desktop
let slideWidth = 0;
let index = 0;

// Determine visible slides based on screen width
function updateVisibleSlides() {
  const width = window.innerWidth;
  if (width < 600) {
    visibleSlides = 3;
  } else if (width < 992) {
    visibleSlides = 4;
  } else {
    visibleSlides = 5;
  }
  slideWidth = track.offsetWidth / visibleSlides;
  slides.forEach((slide) => (slide.style.flex = `0 0 ${100 / visibleSlides}%`));
}

// Clone slides for infinite loop
function cloneSlides() {
  const currentSlides = Array.from(track.children);
  for (let i = 0; i < visibleSlides; i++) {
    const clone = currentSlides[i].cloneNode(true);
    track.appendChild(clone);
  }
  slides = Array.from(track.children);
}

updateVisibleSlides();
cloneSlides();

// Sliding function
function slideNext() {
  index++;
  track.style.transition = "transform 0.8s ease-in-out";
  track.style.transform = `translateX(-${index * slideWidth}px)`;

  if (index >= slides.length - visibleSlides) {
    setTimeout(() => {
      track.style.transition = "none";
      index = 0;
      track.style.transform = `translateX(0px)`;
    }, 900);
  }
}

// Start sliding with slight pause
let slideInterval = setInterval(slideNext, 2500);

// Update on resize
window.addEventListener("resize", () => {
  track.style.transition = "none";
  updateVisibleSlides();
  track.style.transform = `translateX(-${index * slideWidth}px)`;
});
