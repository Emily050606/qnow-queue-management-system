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
            gap: 100px;
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

        .info-card {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 15px;
            background: #fff8e1;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .info-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .info-icon {
            width: 30px;
            height: 30px;
            margin-right: 15px;
            color: #FF8A00;
            flex-shrink: 0;
        }

        .info-text {
            display: flex;
            justify-content: space-between;
            width: 100%;
            font-size: 18px;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .info-value {
            font-weight: 500;
            color: #333;
            text-align: right;
        }

        @media (max-width: 600px) {
            .info-text {
                flex-direction: column;
                text-align: left;
            }

            .info-value {
                margin-top: 5px;
            }
        }

        .page-title {
            text-align: center;     
            color: #FF8A00;         
            font-size: 35px;
            font-weight: 800;
            margin-top: 30px;
        }

        .profile-container {
            max-width: 900px;
            background: white;
            margin: 30px auto 50px auto;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .profile-container h3 {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }

        </style>
    </head>

    <body>
        <div class="menu-bar">
            <img src="logo.png" alt="Logo" class="logo">
                <ul>
                    <li><a href="staffinterface.php">Customer Check In</a></li>
                    <li><a href="managequeue.php">Queue</a></li>
                    <li><a href="report.php">Report Web Issue</a></li>
                    <li><a href="adminlogout.php">Log Out</a></li>
                </ul>
            <a href="profile.php">
                <img src="profile.png" alt="Profile" class="profile-logo">
            </a>
        </div>

        <div class="blur-overlay"></div>

        <div class="content">
            <h1 class="page-title">Restaurant Profile</h1>
            <div class="profile-container">
                <h3>Branch Information</h3>
                <div id="branchData"></div>
            </div>
        </div>
    </body>

<script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-app.js";
        import { getFirestore, doc, getDoc } from "https://www.gstatic.com/firebasejs/10.12.0/firebase-firestore.js";

        const firebaseConfig = {
            apiKey: "AIzaSyCUkYhCI2_kcxjfjXsZ4U0MJ7ZarZsTDOo",
            authDomain: "qnow-c36ec.firebaseapp.com",
            projectId: "qnow-c36ec",
        };

        const app = initializeApp(firebaseConfig);
        const db = getFirestore(app);

        async function loadBranchProfile() {
            const branchRef = doc(db, "restaurants", "shin_zushi", "branches", "2DwadYDoUqR99JCL3THe");
            const snap = await getDoc(branchRef);

            if (!snap.exists()) {
                document.getElementById("branchData").innerHTML = `<p style="text-align:center;">No data found</p>`;
                return;
            }

            const data = snap.data();

            document.getElementById("branchData").innerHTML = `
                <div class="info-card">
                    <span class="info-icon">🏷️\</span>
                    <div class="info-text">
                        <span class="info-label">Branch Name</span>
                        <span class="info-value">${data.bName || "-"}</span>
                    </div>
                </div>

                <div class="info-card">
                    <span class="info-icon">📍</span>
                    <div class="info-text">
                        <span class="info-label">Address</span>
                        <span class="info-value">${data.address || "-"}</span>
                    </div>
                </div>

                <div class="info-card">
                    <span class="info-icon">⭐</span>
                    <div class="info-text">
                        <span class="info-label">Avg Rating</span>
                        <span class="info-value">${data.bAvgRating || "-"}</span>
                    </div>
                </div>

                <div class="info-card">
                    <span class="info-icon">📝</span>
                    <div class="info-text">
                        <span class="info-label">Total Ratings</span>
                        <span class="info-value">${data.bTtlRating || "-"}</span>
                    </div>
                </div>

                <div class="info-card">
                    <span class="info-icon">📞</span>
                    <div class="info-text">
                        <span class="info-label">Phone</span>
                        <span class="info-value">${data.bPhone || "-"}</span>
                    </div>
                </div>
            `;
        }

        loadBranchProfile();
    </script>

</html>
