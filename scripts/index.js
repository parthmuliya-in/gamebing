

// ************************************** SECTION 1 **********************************************
const slides = document.querySelector(".slides");
const slideElements = document.querySelectorAll(".slide");
const prev = document.querySelector(".prev");
const next = document.querySelector(".next");
const dotsContainer = document.querySelector(".dots");

let index = 0;
const totalSlides = slideElements.length;

// Splitting text for Eldritch Animation on slide 1
function applyEldritchText() {
  document.querySelectorAll(".slide1 h1").forEach((h1) => {
    if (h1.dataset.processed) return;
    const text = h1.innerText;
    h1.innerHTML = "";
    h1.dataset.processed = "true";

    text.split("").forEach((letter, i) => {
      const span = document.createElement("span");
      if (letter === " ") {
        span.innerHTML = "&nbsp;";
        span.style.margin = "0 10px";
      } else {
        span.innerText = letter;
      }
      span.style.animationDelay = `${i * 0.1}s`;
      h1.appendChild(span);
    });
  });
}

// Creating Dots
slideElements.forEach((_, i) => {
  const dot = document.createElement("span");
  dot.addEventListener("click", () => {
    resetAutoSlide();
    showSlide(i);
  });
  dotsContainer.appendChild(dot);
});
const dots = document.querySelectorAll(".dots span");

function handleSlideAnimations(currentIndex) {
  // Slide 1 text reset and replay
  if (currentIndex === 0) {
    const spans = document.querySelectorAll(".slide1 h1 span");
    spans.forEach((span) => {
      span.style.animation = "none";
      span.offsetHeight; // trigger reflow
      span.style.animation = null;
    });
  }

  // Slide 2 Text animation
  const slide2Text = document.querySelector(".slide2 .text-content");
  if (currentIndex === 1) {
    setTimeout(() => {
      if (slide2Text) slide2Text.classList.add("animate-in");
    }, 100);
  } else {
    if (slide2Text) slide2Text.classList.remove("animate-in");
  }

  // Slide 3 Image & Text animation
  const slide3Text = document.querySelector(".slide3 .text-content");

  if (slide3Text) {
    if (currentIndex === 2) {
      slide3Text.classList.add("animate-in");
    } else {
      slide3Text.classList.remove("animate-in");
    }
  }
}

function showSlide(i) {
  if (i >= totalSlides) index = 0;
  else if (i < 0) index = totalSlides - 1;
  else index = i;

  slides.style.transform = `translateX(-${index * 100}%)`;

  dots.forEach((dot) => dot.classList.remove("active"));
  dots[index].classList.add("active");

  handleSlideAnimations(index);
}

next.addEventListener("click", () => {
  resetAutoSlide();
  showSlide(index + 1);
});

prev.addEventListener("click", () => {
  resetAutoSlide();
  showSlide(index - 1);
});

let slideInterval = setInterval(() => showSlide(index + 1), 5000);

function resetAutoSlide() {
  clearInterval(slideInterval);
  slideInterval = setInterval(() => showSlide(index + 1), 5000);
}

applyEldritchText();
showSlide(0);

//  ************************************** SECTION 3 **********************************************

const gbSlider = document.getElementById("gbSlider");
const gbFill = document.getElementById("gbFill");

const GB_SLIDE_DURATION = 1200;

let gbCardShift = 0;
let gbLogicalIndex = 1; // center is 2nd card at start
let gbAutoTimer;
let gbIsAnimating = false;

function gbGetCards() {
  return gbSlider.querySelectorAll(".gb-card");
}

function gbUpdateCardShift() {
  const cards = gbGetCards();
  if (cards.length < 2) {
    gbCardShift = cards[0] ? cards[0].getBoundingClientRect().width : 0;
    return;
  }

  const r0 = cards[0].getBoundingClientRect();
  const r1 = cards[1].getBoundingClientRect();

  // distance between start of card1 and card0 (includes margin/gap automatically)
  gbCardShift = Math.round(r1.left - r0.left);
}

function gbSetActive() {
  const cards = gbGetCards();
  cards.forEach((c) => c.classList.remove("gb-active"));
  if (cards[1]) cards[1].classList.add("gb-active");
}

function gbUpdateIndicator() {
  const totalSlides = gbGetCards().length; // 6
  const step = ((gbLogicalIndex + 1) / totalSlides) * 100;
  gbFill.style.width = step + "%";
}

function gbGoNext() {
  if (gbIsAnimating) return;
  gbIsAnimating = true;

  gbGetCards().forEach((c) => c.classList.remove("gb-active"));
  gbUpdateCardShift();

  gbSlider.style.transition = `transform ${GB_SLIDE_DURATION}ms cubic-bezier(0.25, 0.8, 0.25, 1)`;
  gbSlider.style.transform = `translateX(-${gbCardShift}px)`;

  const onEnd = (event) => {
    if (event.target !== gbSlider || event.propertyName !== "transform") return;
    gbSlider.removeEventListener("transitionend", onEnd);

    gbSlider.style.transition = "none";
    gbSlider.appendChild(gbSlider.firstElementChild);
    gbSlider.style.transform = "translateX(0)";

    void gbSlider.offsetHeight;

    gbLogicalIndex = (gbLogicalIndex + 1) % gbGetCards().length;
    gbSetActive();
    gbUpdateIndicator();

    gbIsAnimating = false;
  };

  gbSlider.addEventListener("transitionend", onEnd);
}

function gbGoPrev() {
  if (gbIsAnimating) return;
  gbIsAnimating = true;

  gbGetCards().forEach((c) => c.classList.remove("gb-active"));
  gbUpdateCardShift();

  gbSlider.style.transition = "none";
  gbSlider.insertBefore(gbSlider.lastElementChild, gbSlider.firstElementChild);
  gbSlider.style.transform = `translateX(-${gbCardShift}px)`;

  void gbSlider.offsetHeight;

  gbSlider.style.transition = `transform ${GB_SLIDE_DURATION}ms cubic-bezier(0.25, 0.8, 0.25, 1)`;
  gbSlider.style.transform = "translateX(0)";

  const onEnd = (event) => {
    if (event.target !== gbSlider || event.propertyName !== "transform") return;
    gbSlider.removeEventListener("transitionend", onEnd);

    gbLogicalIndex =
      (gbLogicalIndex - 1 + gbGetCards().length) % gbGetCards().length;
    gbSetActive();
    gbUpdateIndicator();

    gbIsAnimating = false;
  };

  gbSlider.addEventListener("transitionend", onEnd);
}

function gbStartAuto() {
  clearInterval(gbAutoTimer);
  gbAutoTimer = setInterval(gbGoNext, 2500);
}

document.getElementById("gbNextBtn").addEventListener("click", () => {
  gbGoNext();
  gbStartAuto();
});

document.getElementById("gbPrevBtn").addEventListener("click", () => {
  gbGoPrev();
  gbStartAuto();
});

// init
gbSlider.style.transform = "translateX(0)";
gbSetActive();
gbUpdateIndicator();
gbStartAuto();

window.addEventListener("resize", () => {
  gbSetActive();
  gbUpdateIndicator();
});

// ************************************** SECTION 4 **********************************************

document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".gs-card");
  const paginationContainer = document.querySelector(".gs-pagination");
  const totalCards = cards.length;

  let currentIndex = 0;
  let autoSlideInterval;
  const slideDuration = 3500; // Gives every image 3.5 seconds

  // Create Pagination Dots
  cards.forEach((card, index) => {
    const dot = document.createElement("div");
    dot.classList.add("gs-dot");
    if (index === 0) dot.classList.add("gs-active");

    // Click on dot to jump to that slide
    dot.addEventListener("click", () => {
      currentIndex = index;
      updateSlider();
      resetAutoSlide();
    });

    paginationContainer.appendChild(dot);

    // Click on an inactive card in the stack to bring it to front
    card.addEventListener("click", () => {
      if (currentIndex !== index) {
        currentIndex = index;
        updateSlider();
        resetAutoSlide();
      }
    });
  });

  const dots = document.querySelectorAll(".gs-dot");

  // Main function to update classes for the stacked effect
  function updateSlider() {
    // Reset all dots
    dots.forEach((dot) => dot.classList.remove("gs-active"));
    dots[currentIndex].classList.add("gs-active");

    // Remove all positioning classes from cards
    cards.forEach((card) => {
      card.classList.remove(
        "gs-active",
        "gs-next-1",
        "gs-next-2",
        "gs-next-3",
        "gs-next-4",
        "gs-prev",
        "gs-hidden",
      );
    });

    // Assign new classes based on relative position to currentIndex
    cards.forEach((card, i) => {
      // Calculate position relative to currentIndex (accounting for loop)
      let offset = (i - currentIndex + totalCards) % totalCards;

      if (offset === 0) {
        card.classList.add("gs-active"); // The main card
      } else if (offset === 1) {
        card.classList.add("gs-next-1"); // 1st behind
      } else if (offset === 2) {
        card.classList.add("gs-next-2"); // 2nd behind
      } else if (offset === 3) {
        card.classList.add("gs-next-3"); // 3rd behind
      } else if (offset === 4) {
        card.classList.add("gs-next-4"); // 4th behind
      } else if (offset === totalCards - 1) {
        card.classList.add("gs-prev"); // The one sliding out to the left
      } else {
        card.classList.add("gs-hidden"); // Any extra cards hidden on right
      }
    });
  }

  // Move to the next slide
  function nextSlide() {
    currentIndex = (currentIndex + 1) % totalCards;
    updateSlider();
  }

  // Auto loop timer
  function startAutoSlide() {
    autoSlideInterval = setInterval(nextSlide, slideDuration);
  }

  function resetAutoSlide() {
    clearInterval(autoSlideInterval);
    startAutoSlide();
  }

  // Initialize first state
  updateSlider();
  startAutoSlide();
});
