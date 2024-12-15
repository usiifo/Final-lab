import logo from './logo.svg';
import './App.css';
import React from "react";
import ReactDOM from "react-dom";
import Bookmark from './component/bookmarks';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import Login from './component/Login';

function App() {
  return (
    <BrowserRouter>
    <Routes>
      <Route path="/" element={<Login />} />
      <Route path="/bookmarks" element={<Bookmark />} />
    </Routes>
    </BrowserRouter>      
  );
}

export default App;
