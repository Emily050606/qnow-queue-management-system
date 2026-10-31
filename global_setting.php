<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .content {
            padding: 100px 20px;
            height: auto; 
            background-color: rgb(250, 253, 174);
            transition: filter 0.4s ease;
        }

        .page-title {
            text-align: center;
            font-size: 35px;
            font-weight: 800;
            color: #FF8A00;
            margin-top: 30px;
        }

        .menu-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            padding: 15px 40px;
            z-index: 100;
        }

        .menu-bar .logo {
            height: 70px;
            cursor: pointer;
            margin-left: 100px;
        }

        .menu-bar ul {
            list-style: none;
            display: flex;
            gap: 65px;
            margin: 0;
            padding: 0;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        .menu-bar ul li a {
            text-decoration: none;   
            color: #333;            
            font-weight: 800;
            transition: color 0.3s ease;
        }

        .menu-bar ul li a:hover {
            color: #FF8A00;         
        }

        .menu-bar .profile-logo {
            height: 50px;          
            width: 50px;         
            border-radius: 50%;     
            cursor: pointer;
            margin-left: 1000px;      
        }

        .blur-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(6px);
            background: rgba(0, 0, 0, 0.2);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 50;
        }

        .menu-bar:hover + .blur-overlay {
            opacity: 1;
        }

        .profile-container {
            max-width: 900px;
            margin: 50px auto;
            background-color: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .profile-pic-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }

        input[type="file"] {
            display: none;
        }

        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        form button {
            margin-top: 30px;
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            background-color: #FF8A00;
            color: white;
            transition: background 0.3s ease;
            display: block;      
            margin: 30px auto 0;    
        }

        form button:hover {
            background-color: #e67300;
        }

        .operating-hours table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .operating-hours td {
            padding: 6px 10px;
        }
            </style>
        </head>
    <body>
        <div class="menu-bar">
            <img src="logo.png" alt="Logo" class="logo">
                <ul>
                    <li><a href="generalinterface.php">Customer Check In</a></li>
                    <li><a href="general_managequeue.php">Queue</a></li>
                    <li><a href="general_analysisofrestaurant.php">Analysis</a></li>
                    <li><a href="general_report.php">Report Web Issue</a></li>
                    <li><a href="adminlogout.php">Log Out</a></li>
                </ul>
            <a href="general_profile.php">
                <img src="profile.png" alt="Profile" class="profile-logo">
            </a>
        </div>
        <div class="blur-overlay"></div>
        <div class="content">
            <h1 class="page-title">Restaurant Profile</h1>
            <div class="profile-container">
                
                <form id="restaurant-form">
                    <label>Restaurant Name</label>
                    <input type="text" id="rName" placeholder="Restaurant Name">

                    <label>Category</label>
                    <input type="text" id="category" placeholder="Category">

                    <label>Description</label>
                    <textarea id="description" rows="4" placeholder="Description"></textarea>

                    <div class="operating-hours">
                        <h3>Operating Hours</h3>
                        <table>
                            <tbody id="hours-table">
                                <!-- Filled by JS -->
                            </tbody>
                        </table>
                    </div>

                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>
    </body>
    <script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.5.0/firebase-app.js";
import { getFirestore, doc, getDoc, updateDoc } from "https://www.gstatic.com/firebasejs/12.5.0/firebase-firestore.js";
import { getStorage } from "https://www.gstatic.com/firebasejs/12.5.0/firebase-storage.js";

const firebaseConfig = {
    apiKey: "AIzaSyCUkYhCI2_kcxjfjXsZ4U0MJ7ZarZsTDOo",
    authDomain: "qnow-c36ec.firebaseapp.com",
    projectId: "qnow-c36ec",
    storageBucket: "qnow-c36ec.firebasestorage.app",
    messagingSenderId: "347787165581",
    appId: "1:347787165581:web:ba10df189f51405f3d47c4",
    measurementId: "G-HFLG977D05"
};

const app = initializeApp(firebaseConfig);
const db = getFirestore(app);
const storage = getStorage(app);

const form = document.getElementById("restaurant-form");
const hoursTable = document.getElementById("hours-table");
const restaurantId = "shin_zushi"; 

// ================== FOOD KEYWORDS UI ==================
let currentKeywords = [];

// Create a container for keyword tags inside form
const foodKeywordsInput = document.createElement("div");
foodKeywordsInput.id = "keywordsBox";
foodKeywordsInput.style.display = "flex";
foodKeywordsInput.style.flexWrap = "wrap";
foodKeywordsInput.style.gap = "8px";
foodKeywordsInput.style.border = "1px solid #ccc";
foodKeywordsInput.style.padding = "6px 10px";
foodKeywordsInput.style.borderRadius = "8px";
foodKeywordsInput.style.margin = "10px 0";

// Hidden input to store actual value for Firestore
const foodKeywordsHidden = document.createElement("input");
foodKeywordsHidden.type = "hidden";
foodKeywordsHidden.id = "foodKeywords";
form.insertBefore(foodKeywordsInput, form.querySelector("button"));

// Create input inside the box
const keywordInput = document.createElement("input");
keywordInput.type = "text";
keywordInput.placeholder = "Type a keyword & press Enter";
keywordInput.style.border = "none";
keywordInput.style.outline = "none";
keywordInput.style.flex = "1";
keywordInput.style.minWidth = "120px";
keywordInput.style.fontSize = "16px";
foodKeywordsInput.appendChild(keywordInput);

// Load keyword tags to UI
function loadKeywordsToUI(keywordArray) {
    currentKeywords = keywordArray || [];
    // Remove existing tags
    foodKeywordsInput.querySelectorAll(".keyword-tag").forEach(t => t.remove());
    currentKeywords.forEach(tag => addKeywordTag(tag));
}

// Add a tag visually
function addKeywordTag(text) {
    const tag = document.createElement("div");
    tag.classList.add("keyword-tag");
    tag.style.backgroundColor = "#FF8A00";
    tag.style.color = "#000";
    tag.style.padding = "4px 10px";
    tag.style.borderRadius = "12px";
    tag.style.fontSize = "14px";
    tag.style.display = "flex";
    tag.style.alignItems = "center";
    tag.style.gap = "4px";
    tag.innerHTML = `${text} <span style="cursor:pointer;font-weight:bold;" onclick="removeKeyword('${text}')">×</span>`;
    foodKeywordsInput.insertBefore(tag, keywordInput);
}

// Remove keyword
window.removeKeyword = function(text) {
    currentKeywords = currentKeywords.filter(k => k !== text);
    loadKeywordsToUI(currentKeywords);
    foodKeywordsHidden.value = currentKeywords.join(", ");
};

// Input: Press Enter to add keyword
keywordInput.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        let newKeyword = keywordInput.value.trim().toLowerCase();
        if (newKeyword !== "" && !currentKeywords.includes(newKeyword)) {
            currentKeywords.push(newKeyword);
            addKeywordTag(newKeyword);
            foodKeywordsHidden.value = currentKeywords.join(", ");
        }
        keywordInput.value = "";
    }
});

// ========================================================

// Load restaurant data
async function loadRestaurant() {
    const docRef = doc(db, "restaurants", restaurantId);
    const docSnap = await getDoc(docRef);

    if(!docSnap.exists()) return;

    const data = docSnap.data();

    // Basic info
    document.getElementById("rName").value = data.rName || "";
    document.getElementById("category").value = data.category || "";
    document.getElementById("description").value = data.description || "";

    // Operating hours
    const days = ["monday","tuesday","wednesday","thursday","friday","saturday","sunday"];
    hoursTable.innerHTML = "";
    days.forEach(day => {
        const open = data.operatingHours?.[day]?.open || "";
        const close = data.operatingHours?.[day]?.close || "";
        hoursTable.innerHTML += `
            <tr>
                <td style="text-transform: capitalize;">${day}</td>
                <td>Open: <input type="time" value="${open}" id="${day}-open"></td>
                <td>Close: <input type="time" value="${close}" id="${day}-close"></td>
            </tr>
        `;
    });

    // Load food keywords
    const keywords = data.foodKeywords || [];
    loadKeywordsToUI(keywords);
    foodKeywordsHidden.value = keywords.join(", ");
}

loadRestaurant();

// Save changes
form.addEventListener("submit", async (e)=>{
    e.preventDefault();

    const updatedData = {
        rName: document.getElementById("rName").value,
        category: document.getElementById("category").value,
        description: document.getElementById("description").value,
        foodKeywords: currentKeywords
    };

    // Operating hours
    const days = ["monday","tuesday","wednesday","thursday","friday","saturday","sunday"];
    updatedData.operatingHours = {};
    days.forEach(day => {
        updatedData.operatingHours[day] = {
            open: document.getElementById(`${day}-open`).value,
            close: document.getElementById(`${day}-close`).value
        };
    });

    const docRef = doc(db, "restaurants", restaurantId);
    await updateDoc(docRef, updatedData);

    alert("Restaurant details updated successfully!");
});
</script>

</html>
