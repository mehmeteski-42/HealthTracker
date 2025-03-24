import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import './App.css';
import Navbar from './components/Navbar';
import HomePage from './components/HomePage';
import LoginPage from './components/LoginPage';
import RegisterPage from './components/RegisterPage';
import AppointmentPage from './components/AppointmentPage';  // Make sure to import AppointmentPage
import MedicationPage from './components/MedicationPage';  // Make sure to import MedicationPage

const App = () => {
  return (
    <Router>
      <Navbar />
      <div className="App">
        <Routes>
          {/* Route for the homepage */}
          <Route path="/" element={<HomePage />} />

          {/* Route for login page */}
          <Route path="/login" element={<LoginPage />} />

          {/* Route for registration page */}
          <Route path="/register" element={<RegisterPage />} />

          {/* Route for viewing appointments (after login) */}
          <Route path="/appointments" element={<AppointmentPage />} />

          {/* Route for viewing medications (after login) */}
          <Route path="/medications" element={<MedicationPage />} />
        </Routes>
      </div>
    </Router>
  );
};

export default App;
