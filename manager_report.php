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
            padding: 60px 20px;
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
            gap: 60px;
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

         h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .report-form {
            background-color: white;
            padding: 30px 50px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .report-form label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #333;
        }

        .report-form input, .report-form textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .report-form textarea {
            resize: vertical;
        }

        .report-form button {
            display: block;
            margin: 25px auto 0;
            padding: 12px 25px;
            border-radius: 8px;
            border: none;
            background-color: #FF8A00;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .report-form button:hover {
            background-color: #e67300;
        }

            </style>
        </head>
    <body>
        <div class="menu-bar">
            <img src="logo.png" alt="Logo" class="logo">
                <ul>
                    <li><a href="managerinterface.php">Customer Check In</a></li>
                    <li><a href="manager_managequeue.php">Queue</a></li>
                    <li><a href="manager_analysisofrestaurant.php">Analysis</a></li>
                    <li><a href="manager_report.php">Report Web Issue</a></li>
                    <li><a href="adminlogout.php">Log Out</a></li>
                </ul>
            <a href="manager_profile.php">
                <img src="profile.png" alt="Profile" class="profile-logo">
            </a>
        </div>
        <div class="blur-overlay"></div>
        <div class="content">
            <div class="content">
        <h1>Report an Issue</h1>
        <div class="report-form">
            <form id="reportForm">
                <label for="issueTitle">Issue Title</label>
                <input type="text" id="issueTitle" placeholder="Enter the title of the issue" required>

                <label for="issueDesc">Description</label>
                <textarea id="issueDesc" rows="6" placeholder="Describe the problem in detail" required></textarea>

                <label for="contact">Your Contact (optional)</label>
                <input type="text" id="contact" placeholder="Phone or email">

                <button type="submit">Submit Report</button>
            </form>
        </div>
    </div>
        </div>
    </body>
  <script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getFirestore, collection, addDoc, serverTimestamp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-firestore.js";

    const firebaseConfig = {
      apiKey: "AIzaSyCUkYhCI2_kcxjfjXsZ4U0MJ7ZarZsTDOo",
      authDomain: "qnow-c36ec.firebaseapp.com",
      projectId: "qnow-c36ec",
      storageBucket: "qnow-c36ec.appspot.com",
      messagingSenderId: "347787165581",
      appId: "1:347787165581:web:ba10df189f51405f3d47c4",
      measurementId: "G-HFLG977D05"
    };

    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    const form = document.getElementById('reportForm');

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const title = document.getElementById('issueTitle').value;
      const description = document.getElementById('issueDesc').value;
      const contact = document.getElementById('contact').value;

      try {
        await addDoc(collection(db, "WebIssues"), {
          title,
          description,
          contact: contact || "Not provided",
          timestamp: serverTimestamp()
        });

        alert(" Report submitted successfully!");
        form.reset();
      } catch (error) {
        console.error("Error adding document: ", error);
        alert(" Failed to submit report. Please check console for details.");
      }
    });
  </script>
    </html>
