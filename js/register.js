document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".select-button");
  let lastFocusedButton = null;

  const defaultButton = document.querySelector(
    ".select-button[value='student']"
  );
  defaultButton.classList.add("focused");
  lastFocusedButton = defaultButton;

  const content = {
    student: `
        <div class="input-group">
            <input class="input-form" type="text" id="name" name="name" placeholder="Nome" autocomplete="off" required />
            <input class="input-form" type="text" id="surName" name="surName" placeholder="SobreNome" autocomplete="off" required />
        </div>
        <div class="input-group">
            <input class="input-form" type="email" id="email" name="email" placeholder="E-mail" autocomplete="off" required />
            <input class="input-form" type="tel" id="number" name="number" placeholder="Número" autocomplete="off" maxlength="15" required />
        </div>
        <div class="input-group">
            <input class="input-form" type="text" id="teacherKey" name="teacherKey" placeholder="Chave do Professor" autocomplete="off" maxlength="9" required />
            <input class="input-form" type="text" id="institutionKey" name="institutionKey" placeholder="Chave da Instituição" autocomplete="off" maxlength="9" required />
        </div>
        <div class="input-group">
            <input class="input-form" type="password" id="password" name="password" placeholder="Senha" autocomplete="off" required />
            <input class="input-form" type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmar Senha" autocomplete="off" required />
        </div>
    `,
    teacher: `
        <div class="input-group">
            <input class="input-form" type="text" id="name" name="name" placeholder="Nome" autocomplete="off" required />
            <input class="input-form" type="text" id="surName" name="surName" placeholder="SobreNome" autocomplete="off" required />
        </div>
        <div class="input-group">
            <input class="input-form" type="email" id="email" name="email" placeholder="E-mail" autocomplete="off" required />
            <input class="input-form" type="tel" id="number" name="number" placeholder="Número" autocomplete="off" maxlength="15" required />
        </div>
        <div class="input-group">
            <input class="input-form" type="text" id="CPF" name="CPF" placeholder="CPF" autocomplete="off" maxlength="14" required />
            <input class="input-form" type="text" id="institutionKey" name="institutionKey" placeholder="Chave da Instituição" autocomplete="off" required />
        </div>
        <div class="input-group">
            <input class="input-form" type="password" id="password" name="password" placeholder="Senha" autocomplete="off" required />
            <input class="input-form" type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmar Senha" autocomplete="off" required />
        </div>
    `,
    institution: `
        <div class="input-group">
            <input class="input-form" type="text" id="institutionName" name="institutionName" placeholder="Nome da Instituição" autocomplete="off" required />
            <input class="input-form" type="text" id="CNPJ" name="CNPJ" placeholder="CNPJ" autocomplete="off" maxlength="18" required />
        </div>
        <div class="input-group">
            <input class="input-form" type="email" id="email" name="email" placeholder="E-mail" autocomplete="off" required />
            <input class="input-form" type="tel" id="number" name="number" placeholder="Número" autocomplete="off" required />
        </div>
        <div class="input-group">
            <input class="input-form" type="number" id="state" name="state" placeholder="Estado" autocomplete="off" required />
            <input class="input-form" type="number" id="city" name="city" placeholder="Cidade" autocomplete="off" required />
        </div>
        <div class="input-group">
            <input class="input-form" type="password" id="password" name="password" placeholder="Senha" autocomplete="off" required />
            <input class="input-form" type="password" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmar Senha" autocomplete="off" required />
        </div>
    `,
  };

  buttons.forEach(function (button) {
    button.addEventListener("click", function () {
      buttons.forEach(function (btn) {
        btn.classList.remove("focused");
      });
      button.classList.add("focused");
      lastFocusedButton = button;
      const selectedOption = button.value || "student";
      const formContent = document.getElementById("formContent");
      formContent.innerHTML = content[selectedOption];

      if (selectedOption === "student") {
        formatNumber();
        formatInstitutionKey();
        formatTeacherKey();
        formatName();
        formatSurName();
      }
      if (selectedOption === "teacher") {
        formatCPF();
        formatNumber();
        formatName();
        formatSurName();
        formatInstitutionKey();
      }
      if (selectedOption === "institution") {
        formatNumber();
        formatCNPJ();
      }
    });
  });

  document.getElementById("criar").addEventListener("click", function (event) {
    event.preventDefault();

    const formInputs = document.querySelectorAll(".input-form");
    let allFilled = true;

    formInputs.forEach((input) => {
      if (input.value.trim() === "") {
        allFilled = false;
      }
    });

    const password = document.getElementById("password");
    const passwordConfirm = document.getElementById("passwordConfirm");

    if (password.value !== passwordConfirm.value) {
      if (password.value.trim() === "" || passwordConfirm.value.trim() === "") {
        alert("Campos de senhas são obrigatórios.");
        return false;
      }
      passwordConfirm.setCustomValidity("Senhas diferentes!");
      alert("Senhas diferentes!");
      return false;
    } else {
      passwordConfirm.setCustomValidity("");
    }

    if (!allFilled) {
      alert("Por favor, preencha todos os campos obrigatórios.");
      return false;
    }

    var formData = {};
    formData["selectOption"] = lastFocusedButton.value || "student";

    formInputs.forEach(function (input) {
      formData[input.name] = input.value;
    });

    var jsonString = JSON.stringify(formData);

    fetch("../php/register.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: jsonString,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === "success") {
          alert("Cadastro realizado com sucesso!");
          window.location.href = "http://localhost/GameCode/view/login.html";
        } else {
          alert("Ocorreu um erro: " + data.message);
        }
      })
      .catch((error) => {
        alert(`Ocorreu um erro: ${error}`);
      });
  });

  document.addEventListener("click", function (event) {
    if (!event.target.classList.contains("select-button")) {
      if (lastFocusedButton !== null) {
        lastFocusedButton.classList.add("focused");
      }
    }
  });

  showContent(content["student"]);
  formatNumber();
  formatTeacherKey();
  formatName();
  formatSurName();
  formatInstitutionKey();
});

function showContent(content) {
  const formContent = document.getElementById("formContent");
  formContent.innerHTML = content;
}

function formatCPF() {
  const cpfInput = document.getElementById("CPF");

  cpfInput.addEventListener("input", function () {
    let CPF = cpfInput.value.replace(/\D/g, "");

    CPF = CPF.slice(0, 11);

    let formattedCPF = "";
    for (let i = 0; i < CPF.length; i++) {
      if (i === 3 || i === 6) {
        formattedCPF += ".";
      } else if (i === 9) {
        formattedCPF += "-";
      }
      formattedCPF += CPF[i];
    }
    cpfInput.value = formattedCPF;
  });
}

function formatCNPJ() {
  const cnpjInput = document.getElementById("CNPJ");

  cnpjInput.addEventListener("input", function () {
    let CNPJ = cnpjInput.value.replace(/\D/g, "");

    CNPJ = CNPJ.slice(0, 14);

    let formattedCNPJ = "";
    for (let i = 0; i < CNPJ.length; i++) {
      if (i === 2 || i === 5) {
        formattedCNPJ += ".";
      } else if (i === 8) {
        formattedCNPJ += "/";
      } else if (i === 12) {
        formattedCNPJ += "-";
      }
      formattedCNPJ += CNPJ[i];
    }
    cnpjInput.value = formattedCNPJ;
  });
}

function formatNumber() {
  const numberInput = document.getElementById("number");

  numberInput.addEventListener("input", function () {
    let number = numberInput.value.replace(/\D/g, "");

    number = number.slice(0, 11);

    let formattedNumber = "";
    for (let i = 0; i < number.length; i++) {
      if (i === 0) {
        formattedNumber += "(";
      } else if (i === 2) {
        formattedNumber += ") ";
      } else if (i === 7) {
        formattedNumber += "-";
      }
      formattedNumber += number[i];
    }
    numberInput.value = formattedNumber;
  });
}

function formatTeacherKey() {
  const teacherKeyInput = document.getElementById("teacherKey");

  teacherKeyInput.addEventListener("input", function () {
    let teacherKey = teacherKeyInput.value.replace(/\D/g, "");

    teacherKey = teacherKey.slice(0, 6);

    let formattedTeacherKey = "";
    for (let i = 0; i < teacherKey.length; i++) {
      if (i === 3) {
        formattedTeacherKey += "-";
      }
      formattedTeacherKey += teacherKey[i];
    }
    teacherKeyInput.value = formattedTeacherKey;
  });
}

function formatInstitutionKey() {
  const institutionKeyInput = document.getElementById("institutionKey");

  institutionKeyInput.addEventListener("input", function () {
    let institutionKey = institutionKeyInput.value.replace(/\D/g, "");

    institutionKey = institutionKey.slice(0, 6);

    let formattedInstitutionKey = "";
    for (let i = 0; i < institutionKey.length; i++) {
      if (i === 3) {
        formattedInstitutionKey += "-";
      }
      formattedInstitutionKey += institutionKey[i];
    }
    institutionKeyInput.value = formattedInstitutionKey;
  });
}

function formatName() {
  const nameInput = document.getElementById("name");

  nameInput.addEventListener("input", function () {
    let name = nameInput.value.replace(/[^a-zA-ZÀ-ú]/g, "");
    let formattedName =
      name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
    nameInput.value = formattedName;
  });
}

function formatSurName() {
  const surNameInput = document.getElementById("surName");

  surNameInput.addEventListener("input", function () {
    let surName = surNameInput.value.replace(/[^a-zA-ZÀ-ú]/g, "");
    let formattedSurName =
      surName.charAt(0).toUpperCase() + surName.slice(1).toLowerCase();
    surNameInput.value = formattedSurName;
  });
}
