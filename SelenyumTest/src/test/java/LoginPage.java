import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class LoginPage {
    WebDriver driver;

    WebElement username;
    WebElement password;
    WebElement loginButton;

    public LoginPage(WebDriver driver) {
        this.driver = driver;
        username = driver.findElement(By.name("name"));
        password = driver.findElement(By.name("password"));
        loginButton = driver.findElement(By.xpath("//button[@type='submit']"));
    }

    public void login(String userEmail, String userPassword) {
        username.sendKeys(userEmail);
        password.sendKeys(userPassword);
        loginButton.click();
    }
}
