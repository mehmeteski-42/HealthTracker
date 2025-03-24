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
    @include('navbar')
    
    <div class="container text-center mt-5">
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
        
        <!-- Kalori Hesaplayıcı -->
        <div class="container mt-5">
            <h2>Kalori İhtiyacı Hesaplayıcı</h2>
            <div class="card" style="width: 100%; max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <h4>Günlük Kalori İhtiyacı</h4>
                <p>Cinsiyet, boy, kilo, yaş ve aktivite seviyenizi girerek günlük kalori ihtiyacınızı hesaplayın.</p>
                <form id="calorieCalculatorForm">
                    <div class="form-group">
                        <label for="genderCalorie">Cinsiyet</label>
                        <select id="genderCalorie" class="form-control" required>
                            <option value="male">Erkek</option>
                            <option value="female">Kadın</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="weightCalorie">Kilo (kg)</label>
                        <input type="number" id="weightCalorie" class="form-control" placeholder="Kilonuzu girin" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="heightCalorie">Boy (cm)</label>
                        <input type="number" id="heightCalorie" class="form-control" placeholder="Boyunuzu girin" min="50" required>
                    </div>
                    <div class="form-group">
                        <label for="ageCalorie">Yaş</label>
                        <input type="number" id="ageCalorie" class="form-control" placeholder="Yaşınızı girin" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="activityLevelCalorie">Aktivite Seviyesi</label>
                        <select id="activityLevelCalorie" class="form-control" required>
                            <option value="sedentary">Hareketsiz</option>
                            <option value="light">Hafif Aktif</option>
                            <option value="moderate">Orta Aktif</option>
                            <option value="very_active">Çok Aktif</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <button type="button" id="calculateCalories" class="btn btn-primary">Hesapla</button>
                    </div>
                </form>
                <div id="calorieResult" class="mt-3" style="display: none;">
                    <h5>Sonuç:</h5>
                    <p id="calorieAmount"></p>
                </div>
            </div>
        </div>
        
        <div class="container mt-5">
            <h2>Vücut Kitle İndeksi (BMI) Hesaplayıcı</h2>
            <div class="card" style="width: 100%; max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <form id="bmiCalculatorForm">
                    <div class="form-group">
                        <label for="bmiWeight">Kilo (kg)</label>
                        <input type="number" id="bmiWeight" class="form-control" placeholder="Kilonuzu girin" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="bmiHeight">Boy (cm)</label>
                        <input type="number" id="bmiHeight" class="form-control" placeholder="Boyunuzu girin" min="50" required>
                    </div>
                    <div class="form-group mt-3">
                        <button type="button" id="calculateBMI" class="btn btn-primary">Hesapla</button>
                    </div>
                </form>
                <div id="bmiResult" class="mt-3" style="display: none;">
                    <h5>Sonuç:</h5>
                    <p id="bmiAmount"></p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
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
            document.getElementById("calculateCalories").addEventListener("click", function () {
                const gender = document.getElementById("genderCalorie").value;
                const weight = parseFloat(document.getElementById("weightCalorie").value); // Sayıya dönüştür
                const height = parseFloat(document.getElementById("heightCalorie").value); // Sayıya dönüştür
                const age = parseInt(document.getElementById("ageCalorie").value); // Sayıya dönüştür
                const activityLevel = document.getElementById("activityLevelCalorie").value;

                // Boş veya geçersiz değer kontrolü
                if (isNaN(weight) || weight <= 0 || isNaN(height) || height <= 0 || isNaN(age) || age <= 0) {
                    alert("Lütfen geçerli değerler girin.");
                    return;
                }

                // BMR hesaplama (Harris-Benedict denklemi)
                let bmr;
                if (gender === "male") {
                    bmr = 88.36 + (13.4 * weight) + (4.8 * height) - (5.7 * age);
                } else {
                    bmr = 447.6 + (9.2 * weight) + (3.1 * height) - (4.3 * age);
                }

                // Aktivite seviyesine göre çarpan
                let activityMultiplier;
                switch (activityLevel) {
                    case "sedentary":
                        activityMultiplier = 1.2;
                        break;
                    case "light":
                        activityMultiplier = 1.375;
                        break;
                    case "moderate":
                        activityMultiplier = 1.55;
                        break;
                    case "very_active":
                        activityMultiplier = 1.725;
                        break;
                    default:
                        activityMultiplier = 1.2;
                }

                // Günlük kalori ihtiyacı
                const dailyCalories = (bmr * activityMultiplier).toFixed(2);

                // Sonucu göster
                document.getElementById("calorieAmount").textContent = `Günlük önerilen kalori ihtiyacınız: ${dailyCalories} kalori.`;
                document.getElementById("calorieResult").style.display = "block";
            });
            document.getElementById("calculateBMI").addEventListener("click", function () {
                const weight = parseFloat(document.getElementById("bmiWeight").value);
                const height = parseFloat(document.getElementById("bmiHeight").value) / 100; // cm'yi metreye çevir

                if (isNaN(weight) || weight <= 0 || isNaN(height) || height <= 0) {
                    alert("Lütfen geçerli değerler girin.");
                    return;
                }

                const bmi = (weight / (height * height)).toFixed(2);

                let category;
                if (bmi < 18.5) {
                    category = "Zayıf";
                } else if (bmi >= 18.5 && bmi < 24.9) {
                    category = "Normal";
                } else if (bmi >= 25 && bmi < 29.9) {
                    category = "Fazla Kilolu";
                } else {
                    category = "Obez";
                }

                document.getElementById("bmiAmount").textContent = `BMI: ${bmi} (${category})`;
                document.getElementById("bmiResult").style.display = "block";
            });
        });
    </script>
</body>
</html>