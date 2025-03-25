<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Manager</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
    <!-- FRONTEND EKLENİNCE KALDIRILACAK-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('navbar')

    <div class="container text-center mt-5">
        @if(Auth::check())
            <div class="container mt-4">
                <h2>Doktor Randevuları</h2>
                
                <!-- Kullanıcıya ait randevuların listesi -->
                @if($appointments->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Doktor Adı</th>
                                <th>Randevu Tarihi</th>
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
                                    <td>{{ $appointment->date }}</td>
                                    <td>{{ $appointment->time }}</td>
                                    <td>{{ $appointment->department }}</td>
                                    <td>{{ $appointment->location }}</td>
                                    <td>
                                        <button class="btn btn-primary edit-appointment" 
                                                data-id="{{ $appointment->id }}" 
                                                data-doctor="{{ $appointment->doctor_name }}" 
                                                data-date="{{ $appointment->date }}" 
                                                data-time="{{ $appointment->time }}" 
                                                data-department="{{ $appointment->department }}" 
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
                            <label for="appointmentDate">Randevu Tarihi</label>
                            <input type="text" id="appointmentDate" class="form-control" placeholder="YYYY-MM-DD">
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
                            <label for="editAppointmentDate">Randevu Tarihi</label>
                            <input type="text" id="editAppointmentDate" class="form-control">
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

            @include('partials.reminder')
        @else
            <a href="{{ route('loginAccount') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('registerAccount') }}" class="btn btn-secondary">Register</a>
        @endif
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Randevu ekleme işlemleri için URL
            const storeAppointmentURL = "{{ route('appointments.store') }}";
            // Randevu modal'ı
            const appointmentModal = document.getElementById("appointmentModal");
            const addAppointmentBtn = document.getElementById("addAppointmentBtn");
            const closeAppointmentModal = document.querySelector("#appointmentModal .close");

            // Randevu silme işlemi
            const deleteAppointmentButtons = document.querySelectorAll(".delete-appointment");
            
            // Randevu güncelleme işlemi
            const editAppointmentButtons = document.querySelectorAll(".edit-appointment");
            const editModal = document.getElementById("editAppointmentModal");
            const closeEditModal = document.getElementById("closeEditModal");
            
            // Randevu modal'ını aç
            addAppointmentBtn.addEventListener("click", function () {
                appointmentModal.style.display = "block";
            });

            // Randevu modal'ını kapat
            closeAppointmentModal.addEventListener("click", function () {
                appointmentModal.style.display = "none";
            });

            // Modal dışında bir yere tıklanırsa kapat
            window.addEventListener("click", function (event) {
                if (event.target === appointmentModal) {
                    appointmentModal.style.display = "none";
                }
                if (event.target === editModal) {
                    editModal.style.display = "none";
                }
            });

            // Esc tuşuna basıldığında modal'ı kapat
            window.addEventListener("keydown", function (event) {
                if (event.key === "Escape") {
                    appointmentModal.style.display = "none";
                    editModal.style.display = "none";
                }
            });

            // Randevu kaydetme işlemi
            document.getElementById("submitAppointment").addEventListener("click", function () {
                const doctorName = document.getElementById("doctorName").value;
                const date = document.getElementById("appointmentDate").value;
                const appointmentTime = document.getElementById("appointmentTime").value;
                const department = document.getElementById("department").value;
                const locationVal = document.getElementById("location").value;

                const requestBody = {
                    doctorName: doctorName,
                    appointmentTime: appointmentTime,
                    date: date,
                    department: department,
                    location: locationVal,
                };

                fetch(storeAppointmentURL, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify(requestBody),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        //alert(data.message);
                        appointmentModal.style.display = "none"; // Modal'ı kapat
                        location.reload(); // Sayfayı yenileyerek tabloyu güncelle
                    })
                    .catch((error) => {
                        console.error("Hata:", error);
                        //alert("Randevu kaydedilirken bir hata oluştu.");
                    });
            });

            // Randevu silme işlemi
            deleteAppointmentButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    const appointmentId = this.getAttribute("data-id");
                        fetch(`/appointment/${appointmentId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                        })
                            .then((response) => response.json())
                            .then((data) => {
                                //alert(data.message);
                                location.reload(); // Sayfayı yenileyerek tabloyu güncelle
                            })
                            .catch((error) => {
                                console.error("Hata:", error);
                                //alert("Randevu silinirken bir hata oluştu.");
                            });
                });
            });

            // Randevu güncelleme işlemi
            editAppointmentButtons.forEach((button) => {
                button.addEventListener("click", function () {
                    const appointmentId = this.getAttribute("data-id");
                    const doctorName = this.getAttribute("data-doctor");
                    const appointmentDate = this.getAttribute("data-date");
                    const appointmentTime = this.getAttribute("data-time");
                    const department = this.getAttribute("data-department");
                    const location = this.getAttribute("data-location");

                    // Mevcut değerleri modal inputlarına yerleştir
                    document.getElementById("editDoctorName").value = doctorName;
                    document.getElementById("editDepartment").value = department;
                    document.getElementById("editLocation").value = location;

                    editModal.style.display = "block";

                    // Güncelleme işlemi
                    document.getElementById("updateAppointment").onclick = function () {
                        const doctorName = document.getElementById("editDoctorName").value;
                        const appointmentDate = document.getElementById("editAppointmentDate").value;
                        const appointmentTime = document.getElementById("editAppointmentTime").value;
                        const department = document.getElementById("editDepartment").value;
                        const location = document.getElementById("editLocation").value;

                        // Boş alan kontrolü
                        if (!doctorName || !appointmentTime || !department || !location || !appointmentDate) {
                            //alert("Lütfen tüm alanları doldurun.");
                            return;
                        }

                        // İlk olarak randevuyu sil
                        fetch(`/appointment/${appointmentId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                        })
                            .then((response) => {
                                if (!response.ok) {
                                    //alert("Randevu silme işlemi başarısız oldu.");
                                    throw new Error("Randevu silme işlemi başarısız oldu.");
                                }
                                return response.json();
                            })
                            .then(() => {
                                // Yeni verilerle randevu ekle
                                const requestBody = {
                                    doctorName: doctorName,
                                    date: appointmentDate,
                                    appointmentTime: appointmentTime,
                                    department: department,
                                    location: location,
                                };

                                fetch("{{ route('appointments.store') }}", {
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
                                            //alert(data.message);
                                            appointmentModal.style.display = "none"; // Modal'ı kapat
                                        }
                                    })
                                    .then(() => {
                                        editModal.style.display = "none"; // Modal'ı kapat
                                    })
                                    .catch((error) => {
                                        console.error("Hata1:", error);
                                        //alert("Hata1:" + error);
                                    });
                            })
                            .catch((error) => {
                                console.error("Hata2:" + error);
                            });
                    };
                });
            });
            // Modal'ı kapat
            closeEditModal.addEventListener("click", function () {
                editMedicationModal.style.display = "none";
            });
        });
    </script>
    <!-- FRONTEND EKLENINCE KALDIRILACAK -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>