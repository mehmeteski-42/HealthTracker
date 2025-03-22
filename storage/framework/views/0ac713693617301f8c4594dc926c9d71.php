<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/modal.css')); ?>">
</head>
<body>
    
    <div class="container text-center mt-5">
        <h1>Welcome to HealthTracker</h1>
        <p>Your health, our priority.</p>
        <?php if(Auth::check()): ?>
            <p>Hoş geldin, <strong><?php echo e(Auth::user()->name); ?></strong>!</p>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-danger">Çıkış Yap</button>
            </form>
            <div class="container mt-4">
                <h2>Doktor Randevuları</h2>
                
                <!-- Kullanıcıya ait randevuların listesi -->
                <?php if($appointments->isNotEmpty()): ?>
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
                            <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($appointment->doctor_name); ?></td>
                                    <td><?php echo e($appointment->time); ?></td>
                                    <td><?php echo e($appointment->departmant); ?></td>
                                    <td><?php echo e($appointment->location); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Henüz bir randevunuz bulunmamaktadır.</p>
                <?php endif; ?>

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
        <?php else: ?>
            <a href="<?php echo e(route('loginAccount')); ?>" class="btn btn-primary">Login</a>
            <a href="<?php echo e(route('registerAccount')); ?>" class="btn btn-secondary">Register</a>
        <?php endif; ?>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("appointmentModal");
            const addAppointmentBtn = document.getElementById("addAppointmentBtn");
            const closeModal = document.getElementById("closeModal");

            // Modal'ı aç
            addAppointmentBtn.addEventListener("click", function () {
                modal.style.display = "block";
            });

            // Modal'ı kapat
            closeModal.addEventListener("click", function () {
                modal.style.display = "none";
            });

            // Modal dışında bir yere tıklanırsa kapat
            window.addEventListener("click", function (event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
        document.getElementById("submitAppointment").addEventListener("click", function () {
            const doctorName = document.getElementById("doctorName").value;
            const appointmentTime = document.getElementById("appointmentTime").value;
            const department = document.getElementById("department").value;
            const location = document.getElementById("location").value;

            fetch("<?php echo e(route('appointments.store')); ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
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
                    location.reload(); // Sayfayı yenileyerek tabloyu güncelle
                })
                .catch((error) => {
                    console.error("Hata:", error);
                    //alert("Randevu kaydedilirken bir hata oluştu."); //TODO
        });
    });
    </script>
</body>
</html><?php /**PATH C:\laragon\www\HealthTracker\resources\views/welcome.blade.php ENDPATH**/ ?>