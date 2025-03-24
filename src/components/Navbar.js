import React from 'react';
import { Link } from 'react-router-dom';
import './Navbar.css';  // Styling için ayrı bir CSS dosyası

const Navbar = () => {
  return (
    <nav className="navbar">
      <div className="navbar-logo">
        <Link to="/">Health Tracker</Link>
      </div>
      <div className="navbar-links">
        <Link to="/login">Login</Link>
        <Link to="/register">Register</Link>
      </div>
    </nav>
  );
};

export default Navbar;
