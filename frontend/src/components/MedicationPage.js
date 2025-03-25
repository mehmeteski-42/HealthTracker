import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import './MedicationPage.css';

const MedicationPage = () => {
  const [medicationName, setMedicationName] = useState('');
  const [medicationTime, setMedicationTime] = useState('');
  const [additionalNotes, setAdditionalNotes] = useState('');
  const [error, setError] = useState('');
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      // Backend'e ilaç ekleme isteği gönderiyoruz
      const response = await axios.post('http://localhost:8000/api/medications', {
        medicationName,
        medicationTime,
        additionalNotes,
      });

      // Eğer ilaç başarıyla kaydedildiyse
      if (response.data.message === "Medication added successfully") {
        navigate('/'); // Başarılı bir şekilde yönlendirme
      } else {
        setError('Error adding medication');
      }
    } catch (err) {
      console.error(err);
      setError(err.response?.data?.message || 'An error occurred');
    }
  };

  return (
    <div className="medication-page">
      <h2>Add Medication</h2>
      {error && <p className="error">{error}</p>}
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          placeholder="Medication Name"
          value={medicationName}
          onChange={(e) => setMedicationName(e.target.value)}
          required
        />
        <input
          type="datetime-local"
          placeholder="Medication Time"
          value={medicationTime}
          onChange={(e) => setMedicationTime(e.target.value)}
          required
        />
        <textarea
          placeholder="Additional Notes"
          value={additionalNotes}
          onChange={(e) => setAdditionalNotes(e.target.value)}
        />
        <button type="submit">Add Medication</button>
      </form>
    </div>
  );
};

export default MedicationPage;
