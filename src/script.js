const modalBackdrop = document.getElementById("modalBackdrop");
const modal = document.getElementById("modal");
const openModalBtn = document.getElementById("openModalBtn");
const closeModalBtn = document.querySelectorAll(".closeModalBtn");

openModalBtn.addEventListener("click", () => {
  document.getElementById("formAction").value = "add";
  document.getElementById("idAbsensi").value = "";
  document.querySelector("form").reset();
  modal.classList.remove("hidden");
  modalBackdrop.classList.remove("hidden");

  setTimeout(() => {
    modal.classList.remove("scale-95", "opacity-0");
    modal.classList.add("scale-100", "opacity-100");
  }, 10);
});

closeModalBtn.forEach((btn) => {
  btn.addEventListener("click", () => {
    modal.classList.add("scale-95", "opacity-0");
    modal.classList.remove("scale-100", "opacity-100");

    setTimeout(() => {
      modal.classList.add("hidden");
      modalBackdrop.classList.add("hidden");
    }, 300);
  });
});

document.querySelectorAll(".editBtn").forEach(btn => {
  btn.addEventListener("click", () => {
    document.getElementById("formAction").value = "edit";
    document.getElementById("idAbsensi").value = btn.dataset.id;
    document.querySelector("[name='id_siswa']").value = btn.dataset.siswa;
    document.querySelector("[name='tanggal']").value = btn.dataset.tanggal;
    document.querySelector(`[name="status"][value="${btn.dataset.status}"]`).checked = true;

    modal.classList.remove("hidden");
    modalBackdrop.classList.remove("hidden");
    setTimeout(() => {
      modal.classList.remove("scale-95", "opacity-0");
      modal.classList.add("scale-100", "opacity-100");
    }, 10);
  });
});
