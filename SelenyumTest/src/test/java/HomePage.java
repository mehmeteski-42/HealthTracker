import org.openqa.selenium.WebDriver;

public class HomePage {
    WebDriver driver;

    public HomePage(WebDriver driver) {
        this.driver = driver;
    }

    public boolean isAt() {
        return driver.getCurrentUrl().equals("http://localhost:8000/dashboard");
    }
}
