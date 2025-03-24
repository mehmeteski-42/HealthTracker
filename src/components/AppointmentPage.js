import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import './AppointmentPage.css';

const AppointmentPage = () => {
  const [doctorName, setDoctorName] = useState('');
  const [appointmentTime, setAppointmentTime] = useState('');
  const [department, setDepartment] = useState('');
  const [location, setLocation] = useState('');
  const [error, setError] = useState('');
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      // Backend'e randevu oluşturma isteği gönderiyoruz
      const response = await axios.post('http://localhost:8000/api/appointment', {
        doctorName,
        appointmentTime,
        department,
        location,
      });

      // Eğer randevu başarılı bir şekilde kaydedildiyse
      if (response.data.message === "Appointment created successfully") {
        navigate('/'); // Başarılı bir şekilde yönlendirme
      } else {
        setError('Error creating appointment');
      }
    } catch (err) {
      console.error(err);
      setError(err.response?.data?.message || 'An error occurred');
    }
  };

  return (
    <div className="appointment-page">
      <h2>Create Appointment</h2>
      {error && <p className="error">{error}</p>}
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          placeholder="Doctor's Name"
          value={doctorName}
          onChange={(e) => setDoctorName(e.target.value)}
          required
        />
        <input
          type="datetime-local"
          placeholder="Appointment Time"
          value={appointmentTime}
          onChange={(e) => setAppointmentTime(e.target.value)}
          required
        />
        <input
          type="text"
          placeholder="Department"
          value={department}
          onChange={(e) => setDepartment(e.target.value)}
          required
        />
        <input
          type="text"
          placeholder="Location"
          value={location}
          onChange={(e) => setLocation(e.target.value)}
          required
        />
        <button type="submit">Create Appointment</button>
      </form>
    </div>
  );
};

export default AppointmentPage;
