import com.aventstack.extentreports.ExtentReports;
import com.aventstack.extentreports.ExtentTest;
import com.aventstack.extentreports.reporter.ExtentSparkReporter;
import net.bytebuddy.asm.Advice;
import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import io.github.bonigarcia.wdm.WebDriverManager;
import org.testng.Assert;
import org.testng.annotations.*;

public class SeleniumTest {
    WebDriver driver;
    ExtentReports extent;
    ExtentTest test;

    @BeforeSuite
    public void setupReport() {
        ExtentSparkReporter SparkReporter = new ExtentSparkReporter("test-report.Spark");
        extent = new ExtentReports();
        extent.attachReporter(SparkReporter);
    }

    @BeforeClass
    public void setup() {
        WebDriverManager.chromedriver().setup();
        driver = new ChromeDriver();
        driver.get("http://localhost:8000");
    }

    @Test(priority = 1)
    public void testRegister() throws InterruptedException {
        test = extent.createTest("Kullanıcı Kayıt ve Giriş Testi");
        MainPage mainPage = new MainPage(driver);
        mainPage.goToRegisterPage();

        RegisterPage registerPage = new RegisterPage(driver);
        registerPage.register("esseere", "123456");
        WebElement loginButton = driver.findElement(By.xpath("/html/body/div/div/a[1]"));
        Assert.assertTrue(loginButton.isDisplayed(), "Kayıt başarısız!");
        test.pass("Kayıt başarılı.");
    }

    @Test(priority = 2)
    public void testLogin() throws InterruptedException {
        MainPage mainPage = new MainPage(driver);
        mainPage.goToLoginPage();
        LoginPage loginPage = new LoginPage(driver);
        loginPage.login("esseere", "123456");
        Thread.sleep(3000);
        WebElement exitButton = driver.findElement(By.xpath("/html/body/div/form/button"));
        Assert.assertTrue(exitButton.isDisplayed(), "Giriş başarısız!");
        test.pass("Giriş başarılı.");
    }

    @Test(priority = 3)
    public void testCalculateWater() throws InterruptedException {
        WebElement calculator = driver.findElement(By.xpath("//*[@id=\"navbarNav\"]/ul/li[1]/a"));
        calculator.click();

        WebElement kilo = driver.findElement(By.xpath("//*[@id=\"weight\"]"));
        kilo.sendKeys("45");

        WebElement boy = driver.findElement(By.xpath("//*[@id=\"height\"]"));
        boy.sendKeys("158");

        WebElement yas = driver.findElement(By.xpath("//*[@id=\"age\"]"));
        yas.sendKeys("22");

        WebElement etkinlikSeviyesi = driver.findElement(By.xpath("//*[@id=\"activityLevel\"]"));
        etkinlikSeviyesi.click();

        WebElement etkinlikSeviyesiOption = driver.findElement(By.xpath("//*[@id=\"activityLevel\"]/option[2]"));
        etkinlikSeviyesiOption.click();

        WebElement hesapla = driver.findElement(By.xpath("//*[@id=\"calculateWater\"]"));
        hesapla.click();

        WebElement water = driver.findElement(By.xpath("//*[@id=\"waterAmount\"]"));
        Assert.assertTrue(water.isDisplayed(), "Su hesaplaması başarısız!");
        test.pass("Su hesaplaması başarılı");
    }

    @Test(priority = 4)
    public void testCalculateCalori() throws InterruptedException {
        WebElement cinsiyet = driver.findElement(By.xpath("//*[@id=\"genderCalorie\"]"));
        cinsiyet.click();

        WebElement cinsOption = driver.findElement(By.xpath("//*[@id=\"genderCalorie\"]/option[2]"));
        cinsOption.click();

        WebElement kilo = driver.findElement(By.xpath("/html/body/div/div[2]/div/form/div[2]/input"));
        kilo.sendKeys("45");

        WebElement boy = driver.findElement(By.xpath("//*[@id=\"heightCalorie\"]"));
        boy.sendKeys("158");

        WebElement yas = driver.findElement(By.xpath("//*[@id=\"ageCalorie\"]"));
        yas.sendKeys("22");

        WebElement etkinlikSeviyesi = driver.findElement(By.xpath("//*[@id=\"activityLevelCalorie\"]"));
        etkinlikSeviyesi.click();

        WebElement etkinlikSeviyesiOption = driver.findElement(By.xpath("//*[@id=\"activityLevelCalorie\"]/option[2]"));
        etkinlikSeviyesiOption.click();

        WebElement hesapla = driver.findElement(By.xpath("//*[@id=\"calculateCalories\"]"));
        hesapla.click();

        WebElement kalori = driver.findElement(By.xpath("//*[@id=\"waterAmount\"]"));
        Assert.assertTrue(kalori.isDisplayed(), "Kalori hesaplaması başarısız!");
        test.pass("Kalori hesaplaması başarılı");
    }
    @Test(priority = 5)
    public void testCalculateBMI() throws InterruptedException {
        WebElement kilo = driver.findElement(By.xpath("//*[@id=\"bmiWeight\"]"));
        kilo.sendKeys("45");

        WebElement boy = driver.findElement(By.xpath("//*[@id=\"bmiHeight\"]"));
        boy.sendKeys("158");

        WebElement hesapla = driver.findElement(By.xpath("//*[@id=\"calculateBMI\"]"));
        hesapla.click();

        WebElement bmi = driver.findElement(By.xpath("//*[@id=\"bmiAmount\"]"));
        Assert.assertTrue(bmi.isDisplayed(), "BMI hesaplaması başarısız!");
        test.pass("BMI hesaplaması başarılı");
    }
    @Test(priority = 6)
    public void testFitnessSinav() throws InterruptedException {
        WebElement fitnessButton = driver.findElement(By.xpath("//*[@id=\"navbarNav\"]/ul/li[2]/a"));
        fitnessButton.click();

        WebElement antremanTuru = driver.findElement(By.xpath("//*[@id=\"exerciseSelect\"]"));
        antremanTuru.click();

        WebElement pushUp = driver.findElement(By.xpath("//*[@id=\"exerciseSelect\"]/option[2]"));
        pushUp.click();

        WebElement cins = driver.findElement(By.xpath("//*[@id=\"gender\"]"));
        cins.click();

        WebElement erkek = driver.findElement(By.xpath("//*[@id=\"gender\"]/option[3]"));
        erkek.click();

        WebElement kilo = driver.findElement(By.xpath("//*[@id=\"weight\"]"));
        kilo.sendKeys("65");

        WebElement reps = driver.findElement(By.xpath("//*[@id=\"reps\"]"));
        reps.sendKeys("10");

        WebElement submit = driver.findElement(By.xpath("//*[@id=\"submitPushup\"]"));
        submit.click();

        WebElement sonuc = driver.findElement(By.xpath("//*[@id=\"rankText\"]"));
        Assert.assertTrue(sonuc.isDisplayed(), "Sınav hesaplaması başarısız!");
        test.pass("Sınav hesaplaması başarılı");
    }

    @Test(priority = 7)
    public void testFitnessSquat() throws InterruptedException {
        WebElement antremanTuru = driver.findElement(By.xpath("//*[@id=\"exerciseSelect\"]"));
        antremanTuru.click();

        WebElement pushUp = driver.findElement(By.xpath("//*[@id=\"exerciseSelect\"]/option[3]"));
        pushUp.click();

        WebElement cins = driver.findElement(By.xpath("//*[@id=\"squatGender\"]"));
        cins.click();

        WebElement erkek = driver.findElement(By.xpath("//*[@id=\"squatGender\"]/option[2]"));
        erkek.click();

        WebElement kilo = driver.findElement(By.xpath("//*[@id=\"squatWeight\"]"));
        kilo.sendKeys("65");

        WebElement reps = driver.findElement(By.xpath("//*[@id=\"squatReps\"]"));
        reps.sendKeys("10");

        WebElement submit = driver.findElement(By.xpath("//*[@id=\"submitSquat\"]"));
        submit.click();

        WebElement sonuc = driver.findElement(By.xpath("//*[@id=\"rankText\"]"));
        Assert.assertTrue(sonuc.isDisplayed(), "Squat hesaplaması başarısız!");
        test.pass("Squat hesaplaması başarılı");
    }

    @Test(priority = 8)
    public void testFitnessYuzme() throws InterruptedException {
        WebElement fitnessButton = driver.findElement(By.xpath("//*[@id=\"navbarNav\"]/ul/li[2]/a"));
        fitnessButton.click();

        WebElement antremanTuru = driver.findElement(By.xpath("//*[@id=\"exerciseSelect\"]"));
        antremanTuru.click();
        WebElement pushUp = driver.findElement(By.xpath("//*[@id=\"exerciseSelect\"]/option[4]"));
        pushUp.click();

        WebElement cins = driver.findElement(By.xpath("//*[@id=\"swimGender\"]"));
        cins.click();

        WebElement erkek = driver.findElement(By.xpath("//*[@id=\"swimGender\"]/option[2]"));
        erkek.click();

        WebElement kilo = driver.findElement(By.xpath("//*[@id=\"swimWeight\"]"));
        kilo.sendKeys("65");

        WebElement reps = driver.findElement(By.xpath("//*[@id=\"swimMeters\"]"));
        reps.sendKeys("10");

        WebElement submit = driver.findElement(By.xpath("//*[@id=\"submitSwimming\"]"));
        submit.click();

        WebElement sonuc = driver.findElement(By.xpath("//*[@id=\"rankText\"]"));
        Assert.assertTrue(sonuc.isDisplayed(), "Yüzme hesaplaması başarısız!");
        test.pass("Yüzme hesaplaması başarılı");
    }

    @Test(priority = 9)
    public void testAppointments() throws InterruptedException {
        WebElement appointmentsButton = driver.findElement(By.xpath("//*[@id=\"navbarNav\"]/ul/li[3]/a"));
        appointmentsButton.click();

        WebElement randevu = driver.findElement(By.xpath("//*[@id=\"addAppointmentBtn\"]"));
        randevu.click();

        WebElement doctorName = driver.findElement(By.xpath("//*[@id=\"doctorName\"]"));
        doctorName.sendKeys("Ugurcan");

        WebElement saat = driver.findElement(By.xpath("//*[@id=\"appointmentTime\"]"));
        saat.sendKeys("1232");

        WebElement tarih = driver.findElement(By.xpath("//*[@id=\"appointmentDate\"]"));
        tarih.sendKeys("2025-03-30");

        WebElement department = driver.findElement(By.xpath("//*[@id=\"department\"]"));
        department.sendKeys("Kulak Burun Bogaz");

        WebElement konum = driver.findElement(By.xpath("//*[@id=\"location\"]"));
        konum.sendKeys("Ankara");

        WebElement submit = driver.findElement(By.xpath("//*[@id=\"submitAppointment\"]"));
        submit.click();

        Thread.sleep(3000);

        WebElement sonuc = driver.findElement(By.xpath("/html/body/div/div[1]/table/tbody/tr/td[6]/button[2]"));
        Assert.assertTrue(sonuc.isDisplayed(), "Appointment oluşturma başarısız!");
        test.pass("Appointment oluşturma başarılı");
    }

    @Test(priority = 10)
    public void testDeleteAppointments() throws InterruptedException {
        WebElement sil = driver.findElement(By.xpath("/html/body/div/div[1]/table/tbody/tr/td[6]/button[2]"));
        sil.click();

        Assert.assertTrue(sil.isDisplayed(), "Appointment silme başarısız!");
        test.pass("Appointment silme başarılı");
    }

    @Test(priority = 11)
    public void testMedications() throws InterruptedException {
        Thread.sleep(3000);
        WebElement medicationsButton = driver.findElement(By.xpath("//*[@id=\"navbarNav\"]/ul/li[4]/a"));
        medicationsButton.click();

        WebElement randevu = driver.findElement(By.xpath("//*[@id=\"addMedicationBtn\"]"));
        randevu.click();

        WebElement ilacName = driver.findElement(By.xpath("//*[@id=\"medicationName\"]"));
        ilacName.sendKeys("Arveles");

        WebElement saat = driver.findElement(By.xpath("//*[@id=\"medicationTime\"]"));
        saat.sendKeys("1232");

        WebElement bilgi = driver.findElement(By.xpath("//*[@id=\"additional_notes\"]"));
        bilgi.sendKeys("Günde 1 kez");

        WebElement submit = driver.findElement(By.xpath("//*[@id=\"submitMedication\"]"));
        submit.click();
        Thread.sleep(3000);
        WebElement sonuc = driver.findElement(By.xpath("/html/body/div/div[1]/table/tbody/tr/td[4]/button[2]"));
        Assert.assertTrue(sonuc.isDisplayed(), "Ilac oluşturma başarısız!");
        test.pass("Ilac oluşturma başarılı");
    }

    @Test(priority = 12)
    public void testDeleteMedications() throws InterruptedException {
        WebElement sil = driver.findElement(By.xpath("/html/body/div/div[1]/table/tbody/tr/td[4]/button[2]"));
        sil.click();

        Assert.assertTrue(sil.isDisplayed(), "Ilac silme başarısız!");
        test.pass("Ilac silme başarılı");
    }

    @AfterClass
    public void tearDown() {
        driver.quit();
    }

    @AfterSuite
    public void finishReport() {
        extent.flush();
    }
}
