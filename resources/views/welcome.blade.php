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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td>{{ $appointment->doctor_name }}</td>
                                    <td>{{ $appointment->time }}</td>
                                    <td>{{ $appointment->departmant }}</td>
                                    <td>{{ $appointment->location }}</td>
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

            <div class="container mt-5">
                <h2>İlaç Takip</h2>
                
                <!-- Kullanıcıya ait ilaçların listesi -->
                @if($medications->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>İlaç Adı</th>
                                <th>Alınma Zamanı</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medications as $medication)
                                <tr>
                                    <td>{{ $medication->name }}</td>
                                    <td>{{ $medication->time }}</td>
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
                        <button type="button" id="submitMedication" class="btn btn-success">Kaydet</button>
                    </form>
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
                        alert("Randevu kaydedilirken bir hata oluştu.");
                    });
            });

            // İlaç kaydetme işlemi
            document.getElementById("submitMedication").addEventListener("click", function () {
                const medicationName = document.getElementById("medicationName").value;
                const medicationTime = document.getElementById("medicationTime").value;

                fetch("{{ route('medications.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        medicationName: medicationName,
                        medicationTime: medicationTime,
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
                        alert("İlaç kaydedilirken bir hata oluştu.");
                    });
            });
        });
    </script>
</body>
</html>