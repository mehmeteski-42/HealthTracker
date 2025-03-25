import React, { useState } from 'react';
import axios from 'axios';  // Axios'u import ettik
import { useNavigate } from 'react-router-dom'; 
import './RegisterPage.css';

const RegisterPage = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [error, setError] = useState('');
  const [successMessage, setSuccessMessage] = useState('');
  const navigate = useNavigate(); 
  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    // Frontend tarafında şifre eşleşmesi kontrolü yapalım
    if (password !== confirmPassword) {
      setError('Passwords do not match');
      return;
    }

    try {
      // Backend'e kullanıcı kaydını göndermek için POST isteği
      const response = await axios.post('http://localhost:8000/api/registerAccount', {
        name: username,  // username'i 'name' olarak backend'e gönderiyoruz
        password: password,
        password_confirmation: confirmPassword,  // confirmation şifresini de ekledik
      });

      if (response.data.success) {
        setSuccessMessage('Registration successful! Please log in.');
        // Kayıt başarılı olduktan sonra giriş sayfasına yönlendirme yapıyoruz
        navigate('/login'); 
      } else {
        setError(response.data.message || 'Registration failed');
      }
    } catch (err) {
      console.error(err);

      // Eğer backend hata dönerse, o hatayı yakalayalım
      if (err.response && err.response.data && err.response.data.errors) {
        const errorMessages = err.response.data.errors;
        // password confirmation hatasını yakala ve kullanıcıya göster
        if (errorMessages.password) {
          setError(errorMessages.password[0]);
        } else {
          setError('An error occurred while registering');
        }
      } else {
        setError('An error occurred while registering');
      }
    }
  };

  return (
    <div className="register-page">
      <h2>Register</h2>
      {error && <p className="error">{error}</p>}
      {successMessage && <p className="success">{successMessage}</p>}
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          placeholder="Username"
          value={username}
          onChange={(e) => setUsername(e.target.value)}
          required
        />
        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />
        <input
          type="password"
          placeholder="Confirm Password"
          value={confirmPassword}
          onChange={(e) => setConfirmPassword(e.target.value)}
          required
        />
        <button type="submit">Register</button>
      </form>
    </div>
  );
};

export default RegisterPage;
