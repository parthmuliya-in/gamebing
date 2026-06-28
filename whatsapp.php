<!-- ===== WhatsApp Floating Button START ===== -->

<!-- Font Awesome (include once globally) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
  /* WhatsApp Floating Button */
  .whatsapp-float {
    position: fixed;
    width: 70px;
    height: 70px;
    background: linear-gradient(45deg, #25D366, #128C7E);
    color: #fff;
    bottom: 25px;
    right: 25px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    cursor: pointer;
    z-index: 9999;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    animation: whatsappBounce 1s ease;
  }

  /* Hover Effects */
  .whatsapp-float:hover {
    transform: scale(1.15) rotate(-10deg);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.45);
  }

  /* Pulse animation for extra attention */
  .whatsapp-float::after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: rgba(37, 211, 102, 0.5);
    animation: pulse 2s infinite;
    z-index: -1;
  }

  /* Keyframes for pulse */
  @keyframes pulse {
    0% {
      transform: scale(0.9);
      opacity: 0.7;
    }

    50% {
      transform: scale(1.2);
      opacity: 0.4;
    }

    100% {
      transform: scale(0.9);
      opacity: 0.7;
    }
  }

  /* Bounce on page load */
  @keyframes whatsappBounce {
    0% {
      transform: translateY(50px) scale(0.8);
      opacity: 0;
    }

    60% {
      transform: translateY(-10px) scale(1.1);
      opacity: 1;
    }

    80% {
      transform: translateY(5px) scale(1.05);
    }

    100% {
      transform: translateY(0) scale(1);
    }
  }
</style>

<!-- Button -->
<div class="whatsapp-float" data-phone="919099090677">
  <i class="fa-brands fa-whatsapp"></i>
</div>

<script>
  /* Safe for author / include files */
  document.addEventListener("DOMContentLoaded", function () {

    const btn = document.querySelector(".whatsapp-float");
    if (!btn) return;

    btn.addEventListener("click", function () {

      const phone = btn.getAttribute("data-phone");
      const message = encodeURIComponent("Hello, I want more information.");
      const isMobile = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent);

      const url = isMobile
        ? "https://wa.me/" + phone + "?text=" + message
        : "https://web.whatsapp.com/send?phone=" + phone + "&text=" + message;

      window.open(url, "_blank");
    });

  });
</script>