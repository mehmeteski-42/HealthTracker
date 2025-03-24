<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Tracker</title>
</head>
<body>
    @include('navbar')

    <div class="container mt-5">
        <h1 class="text-center">Fitness Tracker</h1>
        <p class="text-center">Egzersizlerinizi takip edin ve sonuçlarınızı görün.</p>

        <!-- Egzersiz Seçim Kutusu -->
        <div class="mb-4">
            <label for="exerciseSelect" class="form-label">Egzersiz Türü Seçin:</label>
            <select id="exerciseSelect" class="form-select">
                <option value="" selected disabled>Egzersiz Seçin</option>
                <option value="pushup">Şınav</option>
                <option value="squat">Squat</option>
                <option value="swimming">Yüzme</option>
            </select>
        </div>

        <!-- Şınav Formu -->
        <div id="pushupForm" class="mt-4" style="display: none;">
            <h3>Şınav Bilgileri</h3>
            <form id="pushupInputForm">
                <div class="mb-3">
                    <label for="gender" class="form-label">Cinsiyet:</label>
                    <select id="gender" class="form-select" required>
                        <option value="" selected disabled>Cinsiyet Seçin</option>
                        <option value="male">Erkek</option>
                        <option value="female">Kadın</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Kilo (kg):</label>
                    <input type="number" id="weight" class="form-control" placeholder="Kilonuzu girin" required>
                </div>
                <div class="mb-3">
                    <label for="reps" class="form-label">Yapılan Tekrar Sayısı:</label>
                    <input type="number" id="reps" class="form-control" placeholder="Tekrar sayısını girin" required>
                </div>
                <button type="button" id="submitPushup" class="btn btn-primary">Okey</button>
            </form>
        </div>

        <!-- Squat Formu -->
        <div id="squatForm" class="mt-4" style="display: none;">
            <h3>Squat Bilgileri</h3>
            <form id="squatInputForm">
                <div class="mb-3">
                    <label for="squatGender" class="form-label">Cinsiyet:</label>
                    <select id="squatGender" class="form-select" required>
                        <option value="" selected disabled>Cinsiyet Seçin</option>
                        <option value="male">Erkek</option>
                        <option value="female">Kadın</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="squatWeight" class="form-label">Kilo (kg):</label>
                    <input type="number" id="squatWeight" class="form-control" placeholder="Kilonuzu girin" required>
                </div>
                <div class="mb-3">
                    <label for="squatReps" class="form-label">Yapılan Tekrar Sayısı:</label>
                    <input type="number" id="squatReps" class="form-control" placeholder="Tekrar sayısını girin" required>
                </div>
                <button type="button" id="submitSquat" class="btn btn-primary">Okey</button>
            </form>
        </div>

        <!-- Yüzme Formu -->
        <div id="swimmingForm" class="mt-4" style="display: none;">
            <h3>Yüzme Bilgileri</h3>
            <form id="swimmingInputForm">
                <div class="mb-3">
                    <label for="swimGender" class="form-label">Cinsiyet:</label>
                    <select id="swimGender" class="form-select" required>
                        <option value="" selected disabled>Cinsiyet Seçin</option>
                        <option value="male">Erkek</option>
                        <option value="female">Kadın</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="swimWeight" class="form-label">Kilo (kg):</label>
                    <input type="number" id="swimWeight" class="form-control" placeholder="Kilonuzu girin" required>
                </div>
                <div class="mb-3">
                    <label for="swimMeters" class="form-label">Yüzülen Metre Sayısı:</label>
                    <input type="number" id="swimMeters" class="form-control" placeholder="Metre sayısını girin" required>
                </div>
                <button type="button" id="submitSwimming" class="btn btn-primary">Okey</button>
            </form>
        </div>

        <!-- Sonuç Gösterimi -->
        <div id="result" class="mt-4" style="display: none;">
            <h3>Sonuç</h3>
            <p id="resultText"></p>
            <p id="rankText"></p>
        </div>
    </div>
    
    @if(Auth::check())
        @include('partials.reminder')
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const exerciseSelect = document.getElementById("exerciseSelect");
            const pushupForm = document.getElementById("pushupForm");
            const squatForm = document.getElementById("squatForm");
            const swimmingForm = document.getElementById("swimmingForm");
            const resultDiv = document.getElementById("result");
            const resultText = document.getElementById("resultText");
            const rankText = document.getElementById("rankText");

            // Egzersiz seçildiğinde ilgili formu göster
            exerciseSelect.addEventListener("change", function () {
                const selectedExercise = exerciseSelect.value;

                // Tüm formları gizle
                pushupForm.style.display = "none";
                squatForm.style.display = "none";
                swimmingForm.style.display = "none";

                // Seçilen formu göster
                if (selectedExercise === "pushup") {
                    pushupForm.style.display = "block";
                } else if (selectedExercise === "squat") {
                    squatForm.style.display = "block";
                } else if (selectedExercise === "swimming") {
                    swimmingForm.style.display = "block";
                }

                // Sonuçları sıfırla
                resultDiv.style.display = "none";
                resultText.textContent = "";
                rankText.textContent = "";
            });

            // Şınav formu gönderildiğinde sonucu ve ranklamayı göster
            document.getElementById("submitPushup").addEventListener("click", function () {
                const gender = document.getElementById("gender").value;
                const weight = parseFloat(document.getElementById("weight").value);
                const reps = parseInt(document.getElementById("reps").value);

                // Form doğrulama
                if (!gender || isNaN(weight) || isNaN(reps)) {
                    alert("Lütfen tüm alanları doldurun.");
                    return;
                }

                const exerciseMultiplier = 1.2; // Şınav: 1.2, Squat: 1.5
                const genderMultiplier = gender === "male" ? 1.1 : 1.0; // Erkek: 1.1, Kadın: 1.0
                const weightFactor = weight / 70; // 70 kg'ye göre normalize

                let score = Math.pow(reps, 0.8) * exerciseMultiplier * weightFactor * genderMultiplier;

                // Sonuçları ekrana yazdır
                resultText.textContent = `Cinsiyet: ${gender}, Kilo: ${weight} kg, Yapılan Şınav Tekrarı: ${reps}`;
                rankText.textContent = `Puanınız: ${score}/100`;
                resultDiv.style.display = "block";
            });
            document.getElementById("submitSquat").addEventListener("click", function () {
                const gender = document.getElementById("squatGender").value;
                const weight = parseFloat(document.getElementById("squatWeight").value);
                const reps = parseInt(document.getElementById("squatReps").value);

                // Form doğrulama
                if (!gender || isNaN(weight) || isNaN(reps)) {
                    alert("Lütfen tüm alanları doldurun.");
                    return;
                }

                const exerciseMultiplier = 1.5; // Şınav: 1.2, Squat: 1.5
                const genderMultiplier = gender === "male" ? 1.1 : 1.0; // Erkek: 1.1, Kadın: 1.0
                const weightFactor = weight / 70; // 70 kg'ye göre normalize

                let score = Math.pow(reps, 0.8) * exerciseMultiplier * weightFactor * genderMultiplier;


                // Sonuçları ekrana yazdır
                resultText.textContent = `Cinsiyet: ${gender}, Kilo: ${weight} kg, Yapılan Squat Tekrarı: ${reps}`;
                rankText.textContent = `Puanınız: ${score}/100`;
                resultDiv.style.display = "block";
            });
            // Yüzme formu gönderildiğinde sonucu ve ranklamayı göster
            document.getElementById("submitSwimming").addEventListener("click", function () {
                const gender = document.getElementById("swimGender").value;
                const weight = parseFloat(document.getElementById("swimWeight").value);
                const meters = parseInt(document.getElementById("swimMeters").value);

                // Form doğrulama
                if (!gender || isNaN(weight) || isNaN(meters)) {
                    alert("Lütfen tüm alanları doldurun.");
                    return;
                }

                const exerciseMultiplier = 1.8; // Yüzme: 1.8
                const genderMultiplier = gender === "male" ? 1.1 : 1.0; // Erkek: 1.1, Kadın: 1.0
                const weightFactor = weight / 70; // 70 kg'ye göre normalize

                let score = Math.pow(laps, 0.8) * exerciseMultiplier * weightFactor * genderMultiplier;

                // Sonuçları ekrana yazdır
                resultText.textContent = `Cinsiyet: ${gender}, Kilo: ${weight} kg, Yüzülen Tur Sayısı: ${laps}`;
                rankText.textContent = `Puanınız: ${score}/100`;
                resultDiv.style.display = "block";
            });
        });
    </script>
</body>
</html>