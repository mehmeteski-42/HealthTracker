<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
</head>
<body>
    
    <div class="container text-center mt-5">
        <h1>Welcome to HealthTracker</h1>
        <p>Your health, our priority.</p>
        @if(Auth::check())
            <p>Hoş geldin, <strong>{{ Auth::user()->name }}</strong>!</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Çıkış Yap</button>
            </form>
            <div class="container mt-4">
                <h2>Doktor Randevuları</h2>
                
                <!-- Kullanıcıya ait randevuların listesi -->
                @if($appointments->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Doktor Adı</th>
                                <th>Randevu Saati</th>
                                <th>Bölüm</th>
                                <th>Lokasyon</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->doctor_name }}</td>
                                    <td>{{ $appointment->time }}</td>
                                    <td>{{ $appointment->departmant }}</td>
                                    <td>{{ $appointment->location }}</td>
                                    <td>
                                        <button class="btn btn-primary edit-appointment" 
                                                data-id="{{ $appointment->id }}" 
                                                data-doctor="{{ $appointment->doctor_name }}" 
                                                data-time="{{ $appointment->time }}" 
                                                data-department="{{ $appointment->departmant }}" 
                                                data-location="{{ $appointment->location }}">
                                            Düzenle
                                        </button>
                                        <button class="btn btn-danger delete-appointment" data-id="{{ $appointment->id }}">Sil</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Henüz bir randevunuz bulunmamaktadır.</p>
                @endif

                <!-- Randevu Ekle Butonu -->
                <button id="addAppointmentBtn" class="btn btn-primary">Randevu Ekle</button>
            </div>

            <!-- Modal -->
            <div id="appointmentModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span id="closeModal" class="close">&times;</span>
                    <h3>Randevu Oluştur</h3>
                    <form id="appointmentForm">
                        <div class="form-group">
                            <label for="doctorName">Doktor Adı</label>
                            <input type="text" id="doctorName" class="form-control" placeholder="Doktor adı">
                        </div>
                        <div class="form-group">
                            <label for="appointmentTime">Randevu Saati</label>
                            <input type="time" id="appointmentTime" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="department">Bölüm</label>
                            <input type="text" id="department" class="form-control" placeholder="Bölüm adı">
                        </div>
                        <div class="form-group">
                            <label for="location">Hastane Lokasyonu</label>
                            <input type="text" id="location" class="form-control" placeholder="Hastane lokasyonu">
                        </div>
                        <button type="button" id="submitAppointment" class="btn btn-success">Kaydet</button>
                    </form>
                </div>
            </div>

            <div id="editAppointmentModal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span id="closeEditModal" class="close">&times;</span>
                    <h3>Randevuyu Düzenle</h3>
                    <form id="editAppointmentForm">
                        <div class="form-group">
                            <label for="editDoctorName">Doktor Adı</label>
                            <input type="text" id="editDoctorName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editAppointmentTime">Randevu Saati</label>
                            <input type="time" id="editAppointmentTime" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editDepartment">Bölüm</label>
                            <input type="text" id="editDepartment" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="editLocation">Hastane Lokasyonu</label>
                            <input type="text" id="editLocation" class="form-control">
                        </div>
                        <button type="button" id="updateAppointment" class="btn btn-success">Güncelle</button>
                    </form>
                </div>
            </div>

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

            <!-- Modal -->
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

            <div class="container mt-5">
                <h2>Su Tüketim Hesaplayıcı</h2>
                <div class="card" style="width: 100%; max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h4>Günlük Su Tüketimi</h4>
                    <p>Boy, kilo, yaş ve aktivite seviyenizi girerek günlük önerilen su miktarını hesaplayın.</p>
                    <form id="waterCalculatorForm">
                        <div class="form-group">
                            <label for="weight">Kilo (kg)</label>
                            <input type="number" id="weight" class="form-control" placeholder="Kilonuzu girin" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="height">Boy (cm)</label>
                            <input type="number" id="height" class="form-control" placeholder="Boyunuzu girin" min="50" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Yaş</label>
                            <input type="number" id="age" class="form-control" placeholder="Yaşınızı girin" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="activityLevel">Aktivite Seviyesi</label>
                            <select id="activityLevel" class="form-control" required>
                                <option value="low">Hafif</option>
                                <option value="moderate">Orta</option>
                                <option value="high">Yoğun</option>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <button type="button" id="calculateWater" class="btn btn-primary">Hesapla</button>
                        </div>
                    </form>
                    <div id="waterResult" class="mt-3" style="display: none;">
                        <h5>Sonuç:</h5>
                        <p id="waterAmount"></p>
                    </div>
                </div>
            </div>
            
        @else
            <a href="{{ route('loginAccount') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('registerAccount') }}" class="btn btn-secondary">Register</a>
        @endif
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Randevu modal'ı
            const appointmentModal = document.getElementById("appointmentModal");
            const addAppointmentBtn = document.getElementById("addAppointmentBtn");
            const closeAppointmentModal = document.querySelector("#appointmentModal .close");

            // İlaç modal'ı
            const medicationModal = document.getElementById("medicationModal");
            const addMedicationBtn = document.getElementById("addMedicationBtn");
            const closeMedicationModal = document.querySelector("#medicationModal .close");

            // Randevu modal'ını aç
            addAppointmentBtn.addEventListener("click", function () {
                appointmentModal.style.display = "block";
            });

            // Randevu modal'ını kapat
            closeAppointmentModal.addEventListener("click", function () {
                appointmentModal.style.display = "none";
            });

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
                if (event.target === appointmentModal) {
                    appointmentModal.style.display = "none";
                }
                if (event.target === medicationModal) {
                    medicationModal.style.display = "none";
                }
            });

            // Randevu kaydetme işlemi
            document.getElementById("submitAppointment").addEventListener("click", function () {
                const doctorName = document.getElementById("doctorName").value;
                const appointmentTime = document.getElementById("appointmentTime").value;
                const department = document.getElementById("department").value;
                const location = document.getElementById("location").value;

                fetch("{{ route('appointments.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        doctorName: doctorName,
                        appointmentTime: appointmentTime,
                        department: department,
                        location: location,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        alert(data.message);
                        appointmentModal.style.display = "none"; // Modal'ı kapat
                        location.reload(); // Sayfayı yenileyerek tabloyu güncelle
                    })
                    .catch((error) => {
                        console.error("Hata:", error);
                        //alert("Randevu kaydedilirken bir hata oluştu.");
                    });
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

            const calculateWaterBtn = document.getElementById("calculateWater");
            const waterResultDiv = document.getElementById("waterResult");
            const waterAmountText = document.getElementById("waterAmount");

            calculateWaterBtn.addEventListener("click", function () {
                const weight = document.getElementById("weight").value;
                const height = document.getElementById("height").value;
                const age = document.getElementById("age").value;
                const activityLevel = document.getElementById("activityLevel").value;

                if (!weight || weight <= 0 || !height || height <= 0 || !age || age <= 0) {
                    alert("Lütfen geçerli değerler girin.");
                    return;
                }

                // Günlük su tüketimi hesaplama (kg başına 0.033 litre)
                let waterIntake = (weight * 0.033).toFixed(2);

                // Aktivite seviyesine göre su tüketimi artırma
                if (activityLevel === "moderate") {
                    waterIntake = (waterIntake * 1.2).toFixed(2);
                } else if (activityLevel === "high") {
                    waterIntake = (waterIntake * 1.5).toFixed(2);
                }

                // Sonucu göster
                waterAmountText.textContent = `Günlük önerilen su tüketimi: ${waterIntake} litre.`;
                waterResultDiv.style.display = "block";
            });

            // Randevu silme işlemi
            const deleteAppointmentButtons = document.querySelectorAll(".delete-appointment");

            deleteAppointmentButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    const appointmentId = this.getAttribute("data-id");

                    if (confirm("Bu randevuyu silmek istediğinize emin misiniz?")) {
                        fetch(`/appointment/${appointmentId}`, {
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
                                alert("Randevu silinirken bir hata oluştu.");
                            });
                    }
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
            // Randevu güncelleme işlemi
            const editButtons = document.querySelectorAll(".edit-appointment");
            const editModal = document.getElementById("editAppointmentModal");
            const closeEditModal = document.getElementById("closeEditModal");

            // Modal'ı aç ve mevcut değerleri doldur
            editButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    const appointmentId = this.getAttribute("data-id");
                    const doctorName = this.getAttribute("data-doctor");
                    const appointmentTime = this.getAttribute("data-time");
                    const department = this.getAttribute("data-department");
                    const location = this.getAttribute("data-location");

                    // Mevcut değerleri modal inputlarına yerleştir
                    document.getElementById("editDoctorName").value = doctorName;
                    document.getElementById("editAppointmentTime").value = appointmentTime;
                    document.getElementById("editDepartment").value = department;
                    document.getElementById("editLocation").value = location;

                    editModal.style.display = "block";

                    // Güncelleme işlemi
                    document.getElementById("updateAppointment").onclick = function () {

                        // İlk olarak randevuyu sil
                        fetch(`/appointment/${appointmentId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                        })
                            .then((response) => {
                                if (!response.ok) {
                                    throw new Error("Randevu silme işlemi başarısız oldu.");
                                }
                                return response.json();
                            })
                            .then(() => {
                                // Yeni verilerle randevu ekle
                                const doctorName = document.getElementById("editDoctorName").value;
                                const appointmentTime = document.getElementById("editAppointmentTime").value;
                                const department = document.getElementById("editDepartment").value;
                                const location = document.getElementById("editLocation").value;

                                return fetch("{{ route('appointments.store') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    },
                                    body: JSON.stringify({
                                        doctorName: doctorName,
                                        appointmentTime: appointmentTime,
                                        department: department,
                                        location: location,
                                    }),
                                });
                            })
                            // Yeni randevu ekleme işlemi başarılı olursa
                            .then((response) => response.json())
                            // Başarılı olursa sayfayı yenile
                            .then((data) => {
                                alert(data.message);
                                location.reload(); // Sayfayı yenileyerek tabloyu güncelle
                            })
                            .catch((error) => {
                                console.error("Hata:", error);
                                alert("Randevu güncellenirken bir hata oluştu.");
                            });
                    };
                });
            });

            // Modal'ı kapat
            closeEditModal.addEventListener("click", function () {
                editModal.style.display = "none";
            });

            window.addEventListener("click", function (event) {
                if (event.target === editModal) {
                    editModal.style.display = "none";
                }
            });
        });
    </script>
</body>
</html>