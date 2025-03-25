import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

public class RegisterPage {
    WebDriver driver;

    WebElement username;
    WebElement password;
    WebElement passwordConfirmation;
    WebElement registerButton;

    public RegisterPage(WebDriver driver) {
        this.driver = driver;
        username = driver.findElement(By.name("name"));
        password = driver.findElement(By.name("password"));
        passwordConfirmation = driver.findElement(By.xpath("//*[@id=\"password_confirmation\"]"));
        registerButton = driver.findElement(By.xpath("//button[@type='submit']"));
    }

    public void register(String name, String pass) {
        username.sendKeys(name);
        password.sendKeys(pass);
        passwordConfirmation.sendKeys(pass);
        registerButton.click();
    }
}
