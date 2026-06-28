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


// ****************************** HAMBURGER MENU TOGGLE ******************************
 
 const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('nav-links');

    if (hamburger && navLinks) {
      hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('show');
        hamburger.classList.toggle('active');
      });
    }