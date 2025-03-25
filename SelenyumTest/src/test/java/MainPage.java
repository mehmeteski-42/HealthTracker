import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class MainPage {
    WebDriver driver;

    // WebElement'leri fonksiyon dışında tanımlıyoruz
    WebElement registerLink;
    WebElement loginLink;

    public MainPage(WebDriver driver) {
        this.driver = driver;
        registerLink = driver.findElement(By.xpath("//a[text()='Register']"));
        loginLink = driver.findElement(By.xpath("//a[text()='Login']"));
    }

    public void goToRegisterPage() {
        registerLink.click();
    }

    public void goToLoginPage() {
        loginLink.click();
    }
}
