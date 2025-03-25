import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';  // useHistory yerine useNavigate
import axios from 'axios';  // Axios'u import ettik
import './LoginPage.css';

const LoginPage = () => {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const navigate = useNavigate();  // useHistory yerine useNavigate
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      // Backend'e giriş isteği gönderiyoruz
      const response = await axios.post('http://localhost:8000/api/loginAccount', {
        name: username,
        password: password,
      });

      // Eğer giriş başarılıysa, backend'den gelen yanıtı kontrol et
      if (response.data.message === 'Login successful') {
        // Başarılı giriş, token'ı sakla (localStorage veya sessionStorage)
        localStorage.setItem('authToken', response.data.token);
        // Yönlendirme işlemi
        navigate('/');  // Örneğin bir dashboard sayfasına yönlendir
      } else {
        // Başarısız giriş
        setError('Invalid username or password');
      }
    } catch (err) {
      console.error(err);
      setError(err.response?.data?.message || 'An error occurred'); // Hata mesajını göster
    }
  };

  return (
    <div className="login-page">
      <h2>Login</h2>
      {error && <p className="error">{error}</p>}
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
        <button type="submit">Login</button>
      </form>
    </div>
  );
};

export default LoginPage;
