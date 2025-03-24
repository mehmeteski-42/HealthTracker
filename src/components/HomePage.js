import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Calendar from 'react-calendar';
import 'react-calendar/dist/Calendar.css';  // Import the calendar styles
import './HomePage.css';

const HomePage = () => {
  const [appointments, setAppointments] = useState([]);
  const [medications, setMedications] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [date, setDate] = useState(new Date()); // Current selected date for the calendar
  const [isLoggedIn, setIsLoggedIn] = useState(false);  // State to track login status

  const token = localStorage.getItem('authToken');  // Get token from localStorage
  
  useEffect(() => {
    const fetchAppointmentsAndMedications = async () => {
      if (!token) return; // If no token, don't make the request

      try {
        setLoading(true);  // Set loading state to true before making API calls
        
        // Use Promise.all to fetch both appointments and medications concurrently
        const [appointmentsResponse, medicationsResponse] = await Promise.all([
          axios.get('http://localhost:8000/api/appointments', {
            headers: { Authorization: `Bearer ${token}` },
          }),
          axios.get('http://localhost:8000/api/medications', {
            headers: { Authorization: `Bearer ${token}` },
          }),
        ]);
        
        setAppointments(appointmentsResponse.data);  // Store appointments in state
        setMedications(medicationsResponse.data);  // Store medications in state
        setIsLoggedIn(true);  // Set login status to true if API requests are successful
      } catch (error) {
        console.error(error);
        setError('An error occurred while fetching data.');  // Set error state
        setIsLoggedIn(false);  // Set login status to false if there was an error
      } finally {
        setLoading(false);  // Set loading state to false after fetching
      }
    };

    if (token) {
      fetchAppointmentsAndMedications(); // Only fetch if user is logged in
    } else {
      setLoading(false);  // If no token, stop loading and display the welcome message
    }
  }, [token]);  // This effect depends on the token

  // Handle the loading state
  if (loading) {
    return <div>Loading...</div>;  // You can replace this with a spinner or some indicator
  }

  // Handle error state
  if (error) {
    return <div>{error}</div>;  // Display error message
  }

  // Mark the dates with appointments and medications
  const getTileClassName = ({ date, view }) => {
    const appointmentDates = appointments.map((appointment) =>
      new Date(appointment.date).toDateString()
    );
    const medicationDates = medications.map((medication) =>
      new Date(medication.date).toDateString()
    );

    const dateString = date.toDateString();

    if (appointmentDates.includes(dateString)) {
      return 'highlight-appointment';  // Class to highlight appointment dates
    } else if (medicationDates.includes(dateString)) {
      return 'highlight-medication';  // Class to highlight medication dates
    }

    return '';  // Return empty class if no event on this date
  };

  return (
    <div className="home-page">
      {isLoggedIn ? (
        // Only display calendar and events if the user is logged in
        <>
          <section className="hero-section">
            <h1>Welcome to Health Tracker</h1>
            <p>Your health management system</p>
          </section>

          <div className="calendar-container">
            <Calendar
              onChange={setDate}
              value={date}
              tileClassName={getTileClassName}  // Add custom tile class name
            />
          </div>

          <div className="appointments-list">
            <h3>Your Appointments</h3>
            <ul>
              {appointments?.length > 0 ? (
                appointments.map((appointment) => (
                  <li key={appointment.id}>
                    {appointment.doctor_name} at {appointment.time}
                  </li>
                ))
              ) : (
                <p>No appointments available</p>
              )}
            </ul>
          </div>

          <div className="medications-list">
            <h3>Your Medications</h3>
            <ul>
              {medications?.length > 0 ? (
                medications.map((medication) => (
                  <li key={medication.id}>
                    {medication.name} at {medication.time}
                  </li>
                ))
              ) : (
                <p>No medications available</p>
              )}
            </ul>
          </div>
        </>
      ) : (
        // If the user is not logged in, show the welcome message
        <section className="hero-section">
          <h1>Welcome to Health Tracker</h1>
          <p>Please log in to view your appointments and medications.</p>
        </section>
      )}
    </div>
  );
};

export default HomePage;
