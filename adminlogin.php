<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            position: relative;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;  
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(1px);
            z-index: 0;
        }

        body {
            background: linear-gradient(8deg,rgba(255, 192, 77, 1) 0%, rgba(255, 226, 173, 1) 0%, rgba(255, 255, 255, 1) 39%, rgba(255, 255, 255, 1) 68%, rgba(248, 241, 186, 1) 100%, rgba(237, 221, 83, 1) 100%);
            z-index: -1;
        }

        .white-box {
            width: 85%;
            max-width: 1150px;
            height: 85%;
            background: #fc9654;
            border-radius: 35px;
            display: flex;
            overflow: hidden;
            position: relative;
            z-index: 10;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
        }

        .image-side {
            flex: 1;
            width: 100%;
            background-image: url('login_img.jpg');
            background-size: cover;
            background-position: center;
            border-top-right-radius: 35px;
            border-bottom-right-radius: 35px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
        }

        .form-side {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-side h2 {
            font-size: 36px;
            margin-bottom: 25px;
            font-weight: 600;
            color: #2D2B29;
            text-align: center;
        }

        .form-side input {
            width: match_parent;
            margin-bottom: 18px;
            padding: 15px;
            border-radius: 12px;
            border: none;
            background: #fff;
            box-shadow: 0 3px 6px rgba(0,0,0,0.08);
            font-size: 15px;
        }

        .form-side button {
            padding: 12px;
            background-color: black;
            color: #fff3e3;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-side button:hover {
            background-color: #fff3e3;
            color: #2D2B29;
        }

        .form-side .forgot-password {
            display: block;
            font-size: 14px;
            color: #fff3e3;
            text-decoration: none;
            cursor: pointer;
            transition: color 0.3s ease;
            text-align: right;
            margin-top: -10px;
            margin-bottom: 15px;
        }

        .form-side .forgot-password:hover {
            color: #2D2B29;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: none; 
            justify-content: center;
            align-items: center;
            z-index: 200;
        }

        .popup-content {
            background: white;
            padding: 30px 20px;
            border-radius: 15px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            position: relative;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            animation: popupShow 0.3s ease;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }

        .close-btn:hover {
            color: #FF8A00;
        }

        @keyframes popupShow {
            from { transform: scale(0.7); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="white-box">
        <div class="image-side"></div>
        <div class="form-side">
            <h2>Admin Login</h2>
            <input type="text" id="email" placeholder="Username">
            <input type="password" id="password" placeholder="Password">
            <a href="#" class="forgot-password" onclick="showForgotPopup()">Forgot Password?</a>
            <button onclick="login()">Login</button>
        </div>
    </div>
        <div id="forgot-popup" class="popup-overlay">
            <div class="popup-content">
                <span class="close-btn" onclick="closeForgotPopup()">&times;</span>
                <h3>Password Reset</h3>
                <p>Please call HQ at <strong>011-1622-0448</strong> to reset your password.</p>
            </div>
        </div>


<script type="module">
    // Import Firebase
    import { initializeApp } from "https://www.gstatic.com/firebasejs/12.5.0/firebase-app.js";
    import { getFirestore, doc, getDoc } from "https://www.gstatic.com/firebasejs/12.5.0/firebase-firestore.js";

    const firebaseConfig = {
        apiKey: "AIzaSyCUkYhCI2_kcxjfjXsZ4U0MJ7ZarZsTDOo",
        authDomain: "qnow-c36ec.firebaseapp.com",
        projectId: "qnow-c36ec",
        storageBucket: "qnow-c36ec.firebasestorage.app",
        messagingSenderId: "347787165581",
        appId: "1:347787165581:web:ba10df189f51405f3d47c4",
        measurementId: "G-HFLG977D05"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const db = getFirestore(app);

    // Login function
    window.login = async function() {
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value.trim();

        if (email === "" || password === "") {
            alert("Please enter both email and password!");
            return;
        }

        const docRef = doc(db, "admin", email);
        try {
            const docSnap = await getDoc(docRef);
            if (docSnap.exists()) {
                const data = docSnap.data();
                if (password === data.password) {
                    alert("Login successful! Role: " + data.role);

                    // Redirect based on role
                    if (data.role === "staff") {
                        window.location.href = "staffinterface.php";
                    } else if (data.role === "manager") {
                        window.location.href = "managerinterface.php";
                    } else if (data.role === "general_manager") {
                        window.location.href = "generalinterface.php";
                    } else {
                        alert("Unknown role!");
                    }
                } else {
                    alert("Incorrect password!");
                }
            } else {
                alert("Admin not found!");
            }
        } catch (error) {
            console.error("Error fetching document:", error);
            alert("Login failed. Please try again.");
        }
    };

    // Forgot password popup 
    window.showForgotPopup = function() {
        document.getElementById("forgot-popup").style.display = "flex";
    }

    window.closeForgotPopup = function() {
        document.getElementById("forgot-popup").style.display = "none";
    }

</script>
</body>
</html>
