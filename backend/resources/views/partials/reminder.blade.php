<script>
    function checkReminder() {

        // Eğer randevu varsa
        @if($appointments->isNotEmpty())
            let upcomingAppointments = @json($appointments);

            // Şu anki zamanı al
            let now = new Date();

            // Randevuları kontrol et
            let nextAppointment = upcomingAppointments.find(appointment => {
                let appointmentDateTime = new Date(`${appointment.date}T${appointment.time}`);
                let timeDifference = (appointmentDateTime - now) / (1000 * 60); // Dakika cinsinden fark
                return timeDifference > 0 && timeDifference <= 60; // 1 saat içinde olan randevular
            });

            if (nextAppointment) {
                let reminderMessage = `1 saat içinde bir randevunuz var:\n\n`;
                reminderMessage += `Doktor: ${nextAppointment.doctor_name}\n`;
                reminderMessage += `Tarih: ${nextAppointment.date}\n`;
                reminderMessage += `Saat: ${nextAppointment.time}\n`;
                reminderMessage += `Bölüm: ${nextAppointment.department}\n`;
                reminderMessage += `Lokasyon: ${nextAppointment.location}\n`;

                //alert(reminderMessage);
            }
        @endif
        // Eğer ilaç varsa
        @if($medications->isNotEmpty())
            let upcomingMedications = @json($medications);

            // İlaçları kontrol et  
            let nextMedication = upcomingMedications.find(medication => {
                let medicationTime = new Date();
                let [hours, minutes] = medication.time.split(':');
                medicationTime.setHours(hours, minutes, 0, 0);
                let timeDifference = (medicationTime - now) / (1000 * 60);
                return timeDifference > 0 && timeDifference <= 60;
            });

            if (nextMedication) {
                let reminderMessage = `1 saat içinde bir ilacınızı almanız gerekmektedir:\n\n`;
                reminderMessage += `İlaç Adı: ${nextMedication.name}\n`;
                reminderMessage += `Alınma Zamanı: ${nextMedication.time}\n`;

                if (nextMedication.additional_notes) {
                    reminderMessage += `Detaylı Bilgi: ${nextMedication.additional_notes}\n`;
                }

                //alert(reminderMessage);
            }
        @endif
        
    }
    function waterReminder(){
        let waterReminderMessage = "Su içmeyi unutmayın! Sağlıklı bir yaşam için düzenli su tüketimi önemlidir.";
        //alert(waterReminderMessage);
    }

    // Sayfa yüklendiğinde hemen kontrol et
    document.addEventListener('DOMContentLoaded', function () {
        checkReminder();
        waterReminder();

        // 5000 ms = 5 saniye
        // 1 dakika = 60000 ms
        setInterval(checkReminder, 300000); // 60000 ms = 1 dakika
        setInterval(waterReminder, 3600000); // 3600000 ms = 1 saat
    });
</script>