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
            
                <form id="branch-form">
                    <label>Branch Name</label>
                    <input type="text" id="bName">

                    <label>Address</label>
                    <textarea id="address" rows="3"></textarea>

                    <label>Phone Number</label>
                    <input type="text" id="bPhone">

                    <button type="submit">Save Changes</button>
                </form>
            </div>
        </div>
    </body>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.5.0/firebase-app.js";
        import { getFirestore, doc, getDoc, updateDoc } from "https://www.gstatic.com/firebasejs/12.5.0/firebase-firestore.js";

        
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

        // branch config
        const restaurantId = "shin_zushi"; 
        const branchId = "2DwadYDoUqR99JCL3THe"; // Branch 1 Document ID

        const form = document.getElementById("branch-form");

        // load branch data
        async function loadBranch() {
            const branchRef = doc(db, "restaurants", restaurantId, "branches", branchId);
            const snap = await getDoc(branchRef);

            if (!snap.exists()) {
                console.log("Branch not found");
                return;
            }

            const data = snap.data();

            document.getElementById("bName").value = data.bName || "";
            document.getElementById("address").value = data.address || "";
            document.getElementById("bPhone").value = data.bPhone || "";
        }

        loadBranch();

        // save data into firebase
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const updatedBranch = {
                bName: document.getElementById("bName").value,
                address: document.getElementById("address").value,
                bPhone: document.getElementById("bPhone").value
            };

            const branchRef = doc(db, "restaurants", restaurantId, "branches", branchId);
            await updateDoc(branchRef, updatedBranch);

            alert("Branch details updated successfully!");
        });
    </script>
</html>
