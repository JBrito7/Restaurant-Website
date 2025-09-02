(function () {
  "use strict";

  const forms = document.querySelectorAll(".needs-validation");

  Array.from(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        } else {
          event.preventDefault();
          const successMsg = document.getElementById("successMessage");
          document.getElementById("successMessage").style.display = "block";

          // Mostar a mensagem de reserva efectuada com sucesso e reseta o form após 3.5 segundos
          setTimeout(function () {
            form.reset();
            form.classList.remove("was-validated");
            successMsg.style.display = "none";
          }, 3500);

          form.classList.remove("was-validated");
        }
      },
      false
    );
  });
})();