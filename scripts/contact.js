  const form = document.getElementById("contactForm");
  // const successMsg = document.querySelector(".success");
  // form.addEventListener("submit", function (e) {
  //   e.preventDefault();
  //   successMsg.style.display = "block";
  //   setTimeout(() => {
  //     successMsg.style.display = "none";
  //     form.reset();
  //   }, 2500);
  // });

  // **********************

  document.addEventListener("DOMContentLoaded", function () {
    // About heading ko select karna
    const aboutHeading = document.querySelector(".about-heading");

    // Page load hone ke thodi der baad 'active' class add karna (smooth effect ke liye)
    if (aboutHeading) {
      setTimeout(() => {
        aboutHeading.classList.add("active");
      }, 300); // 300ms ka delay
    }
  });
