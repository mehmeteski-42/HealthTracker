<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicaton Manager</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <!-- FRONTEND EKLENİNCE KALDIRILACAK-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')
    
    <div class="container text-center mt-5">
        @if(Auth::check())
            <div class="container mt-5">
                <h2>İlaç Takip</h2>
                
                <!-- Kullanıcıya ait ilaçların listesi -->
                @if($medications->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>İlaç Adı</th>
                                <th>Alınma Zamanı</th>
                                <th>Detaylı Bilgi</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medications as $medication)
                                <tr>
                                    <td>{{ $medication->name }}</td>
                                    <td>{{ $medication->time }}</td>
                                    <td>{{ $medication->additional_notes }}</td>
                                    <td>
                                        <button class="btn btn-primary edit-medication" 
                                                data-id="{{ $medication->id }}" 
                                                data-name="{{ $medication->name }}" 
                                                data-time="{{ $medication->time }}" 
                                                data-notes="{{ $medication->additional_notes }}">
                                            Düzenle
                                        </button>
                                        <button class="btn btn-danger delete-medication" data-id="{{ $medication->id }}">Sil</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Henüz bir ilaç eklenmemiştir.</p>
                @endif

                <!-- İlaç Ekle Butonu -->
                <button id="addMedicationBtn" class="btn btn-primary">İlaç Ekle</button>
            </div>

            <div id="medicationModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span id="closeModal" class="close">&times;</span>
                    <h3>İlaç Oluştur</h3>
                    <form id="medicationForm">
                        <div class="form-group">
                            <label for="medicationName">İlaç Adı</label>
                            <input type="text" id="medicationName" class="form-control" placeholder="İlaç Adı">
                        </div>
                        <div class="form-group">
                            <label for="medicationTime">İlaç Saati</label>
                            <input type="time" id="medicationTime" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="additional_notes">Detaylı Bilgi</label>
                            <input type="text" id="additional_notes" class="form-control" placeholder="Kullanım sıklığı, dozaj vb.">
                        </div>
                        <button type="button" id="submitMedication" class="btn btn-success">Kaydet</button>
                    </form>
                </div>
            </div>

            <div id="editMedicationModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span id="closeEditMedicationModal" class="close">&times;</span>
                    <h3>İlacı Düzenle</h3>
                    <form id="editMedicationForm">
                        <div class="form-group">
                            <label for="editMedicationName">İlaç Adı</label>
                            <input type="text" id="editMedicationName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editMedicationTime">Alınma Zamanı</label>
                            <input type="time" id="editMedicationTime" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editAdditionalNotes">Detaylı Bilgi</label>
                            <input type="text" id="editAdditionalNotes" class="form-control">
                        </div>
                        <button type="button" id="updateMedication" class="btn btn-success">Güncelle</button>
                    </form>
                </div>
            </div>

            @include('partials.reminder')
        @else
            <a href="{{ route('loginAccount') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('registerAccount') }}" class="btn btn-secondary">Register</a>
        @endif
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // İlaç modal'ı
            const medicationModal = document.getElementById("medicationModal");
            const addMedicationBtn = document.getElementById("addMedicationBtn");
            const closeMedicationModal = document.querySelector("#medicationModal .close");

            // İlaç modal'ını aç
            addMedicationBtn.addEventListener("click", function () {
                medicationModal.style.display = "block";
            });

            // İlaç modal'ını kapat
            closeMedicationModal.addEventListener("click", function () {
                medicationModal.style.display = "none";
            });

            // Modal dışında bir yere tıklanırsa kapat
            window.addEventListener("click", function (event) {
                if (event.target === medicationModal) {
                    medicationModal.style.display = "none";
                }
            });

            // İlaç kaydetme işlemi
            document.getElementById("submitMedication").addEventListener("click", function () {
                const medicationName = document.getElementById("medicationName").value;
                const medicationTime = document.getElementById("medicationTime").value;
                const additional_notes = document.getElementById("additional_notes").value;

                fetch("{{ route('medications.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        medicationName: medicationName,
                        medicationTime: medicationTime,
                        additional_notes: additional_notes,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        alert(data.message);
                        medicationModal.style.display = "none"; // Modal'ı kapat
                        location.reload(); // Sayfayı yenileyerek tabloyu güncelle
                    })
                    .catch((error) => {
                        console.error("Hata:", error);
                        //alert("İlaç kaydedilirken bir hata oluştu.");
                    });
            });

            // İlaç silme işlemi
            const deleteMedicationButtons = document.querySelectorAll(".delete-medication");

            deleteMedicationButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    const medicationId = this.getAttribute("data-id");

                    if (confirm("Bu ilacı silmek istediğinize emin misiniz?")) {
                        fetch(`/medications/${medicationId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                        })
                            .then((response) => response.json())
                                .then((data) => {
                                    alert(data.message);
                                    location.reload(); // Sayfayı yenileyerek tabloyu güncelle
                                })
                                .catch((error) => {
                                    console.error("Hata:", error);
                                    alert("İlaç silinirken bir hata oluştu.");
                                });
                    }
                });
            });

            // İlaç güncelleme işlemi
            const editMedicationButtons = document.querySelectorAll(".edit-medication");
            const editMedicationModal = document.getElementById("editMedicationModal");
            const closeEditMedicationModal = document.getElementById("closeEditMedicationModal");

            // Modal'ı aç ve mevcut değerleri doldur
            editMedicationButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    const medicationId = this.getAttribute("data-id");
                    const medicationName = this.getAttribute("data-name");
                    const medicationTime = this.getAttribute("data-time");
                    const additionalNotes = this.getAttribute("data-notes");

                    // Mevcut değerleri modal inputlarına yerleştir
                    document.getElementById("editMedicationName").value = medicationName;
                    document.getElementById("editAdditionalNotes").value = additionalNotes;

                    editMedicationModal.style.display = "block";

                    // Güncelleme işlemi
                    document.getElementById("updateMedication").onclick = function () {
                        const updatedMedicationName = document.getElementById("editMedicationName").value;
                        const updatedMedicationTime = document.getElementById("editMedicationTime").value;
                        const updatedAdditionalNotes = document.getElementById("editAdditionalNotes").value;

                        // Boş alan kontrolü
                        if (!updatedMedicationName || !updatedMedicationTime) {
                            alert("Lütfen tüm alanları doldurun.");
                            return;
                        }

                        // İlk olarak ilacı sil
                        fetch(`/medications/${medicationId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                        })
                            .then((response) => {
                                if (!response.ok) {
                                    alert("Randevu silme işlemi başarısız oldu.");
                                    throw new Error("Randevu silme işlemi başarısız oldu.");
                                }
                                return response.json();
                            })
                            .then(() => {
                                // Yeni verilerle randevu ekle
                                const requestBody = {
                                    medicationName: updatedMedicationName,
                                    medicationTime: updatedMedicationTime,
                                    additional_notes: updatedAdditionalNotes,
                                };

                                fetch("{{ route('medications.store') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    },
                                    body: JSON.stringify(requestBody),
                                })
                                    .then((response) => response.json())
                                    .then((data) => {
                                        if (data != null) {
                                            alert(data.message);
                                            editMedicationModal.style.display = "none";
                                            location.reload(); // Sayfayı yenileyerek tabloyu güncelle
                                        }
                                    })
                                    .then(() => {
                                        editMedicationModal.style.display = "none"; // Modal'ı kapat
                                    })
                                    .catch((error) => {
                                        console.error("Hata1:", error);
                                        alert("Hata1:" + error);
                                    });
                            })
                            .catch((error) => {
                                console.error("Hata2:" + error);
                        });
                    };
                });
            });

            // Modal'ı kapat
            closeEditMedicationModal.addEventListener("click", function () {
                editMedicationModal.style.display = "none";
            });

            window.addEventListener("click", function (event) {
                if (event.target === editMedicationModal) {
                    editMedicationModal.style.display = "none";
                }
            });
        });
    </script>
    <!-- FRONTEND EKLENINCE KALDIRILACAK -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<body>
</html>