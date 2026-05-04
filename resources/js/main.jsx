import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App.jsx";

// Mount React vào element có id là #root
const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
    <React.StrictMode>
        <App />
    </React.StrictMode>,
);
