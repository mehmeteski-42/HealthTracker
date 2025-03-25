import axios from 'axios';

// API instance'ını oluşturuyoruz
const api = axios.create({
  baseURL: 'http://localhost:8000/api',  // Laravel API URL'iniz
  timeout: 10000,  // 10 saniye timeout
  headers: {
    'Content-Type': 'application/json',  // JSON formatında veri gönderimi
  },
});

// API instance'ını default olarak export ediyoruz
export default api;
