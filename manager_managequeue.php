<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Queue</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100%;
            background-color: rgb(250, 253, 174); 
        }

        .content {
            padding: 120px 40px 40px 40px;
            max-width: 1200px;
            margin: 0 auto;
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
        /* Page Content */
        .content {
            padding: 120px 40px 40px 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        /* Queue Table */
        .queue-table-container {
            background-color: white;
            border-radius: 20px;
            padding: 20px 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        thead {
            background-color: #FF8A00;
            color: white;
            border-radius: 20px;
        }

        thead th {
            padding: 12px 10px;
            text-align: left;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
            transition: background 0.3s ease;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: rgba(255, 138, 0, 0.1);
        }

        tbody td {
            padding: 12px 10px;
        }

        /* Status badges */
        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            color: white;
            display: inline-block;
        }

        .waiting {
            background-color: #f1c40f;
        }

        .checked-in {
            background-color: #27ae60;
        }

        .cancelled {
            background-color: #e74c3c;
        }

        #status-filter {
            padding: 8px 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            outline: none;
            transition: all 0.3s ease;
        }

        #status-filter:hover {
            border-color: #FF8A00;
        }

        #status-filter:focus {
            border-color: #FF8A00;
            box-shadow: 0 0 5px rgba(255,138,0,0.5);
        }

        .filter-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        #date-filter {
            padding: 8px 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            outline: none;
            transition: all 0.3s ease;
        }

        #date-filter:hover {
            border-color: #FF8A00;
        }

        #date-filter:focus {
            border-color: #FF8A00;
            box-shadow: 0 0 5px rgba(255,138,0,0.5);
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
            <li><a href="manager_reportissue.php">Report Web Issue</a></li>
            <li><a href="adminlogout.php">Log Out</a></li>
        </ul>
        <a href="manager_profile.php">
            <img src="profile.png" alt="Profile" class="profile-logo">
        </a>
    </div>

    <div class="blur-overlay"></div>

    <div class="content">
        <h1>Current Queue</h1>

        <div class="filter-row">
            
            <!-- LEFT: Date Filter -->
            <div>
                <label for="date-filter">Select date: </label>
                <input type="date" id="date-filter">
            </div>

            <!-- RIGHT: Status Filter -->
            <div>
                <label for="status-filter">Filter by status: </label>
                <select id="status-filter">
                    <option value="all">All</option>
                    <option value="waiting">Waiting</option>
                    <option value="checked_in">Checked In</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

        </div>
        <div class="queue-table-container">
            <table>
                <thead>
                    <tr>
                        <th>Queue</th>
                        <th>Customer</th>
                        <th>Phone Number</th>
                        <th>Party</th>
                        <th>Time Added</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>John Doe</td>
                        <td>012-3456789</td>
                        <td>3</td>
                        <td>11:15 AM</td>
                        <td><span class="status waiting">Waiting</span></td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>Jane Smith</td>
                        <td>019-8765432</td>
                        <td>2</td>
                        <td>11:20 AM</td>
                        <td><span class="status checked-in">Checked In</span></td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>Michael Lee</td>
                        <td>014-9876543</td>
                        <td>4</td>
                        <td>11:25 AM</td>
                        <td><span class="status cancelled">Cancelled</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
import { getFirestore, collection, onSnapshot } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-firestore.js";

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
const branchId = "2DwadYDoUqR99JCL3THe";

const filterSelect = document.getElementById("status-filter");
const dateFilter = document.getElementById("date-filter");

// Set default date = today
const today = new Date();
dateFilter.value = today.toISOString().split("T")[0];

// Format queue number
function fmtQueueNumber(n) {
    return n;
}

function updateTable() {
    const tbody = document.querySelector("tbody");
    tbody.innerHTML = "";

    const selectedStatus = filterSelect.value;
    const selectedDate = new Date(dateFilter.value);
    selectedDate.setHours(0,0,0,0);

    const selectedDateTS = selectedDate.getTime();

    onSnapshot(collection(db, "queues"), (snapshot) => {
        const rows = snapshot.docs
            .map(d => ({ id: d.id, ...d.data() }))
            .filter(d => {
                if (!d.timestamp || !d.branchId) return false;

                const ts = new Date(d.timestamp.seconds * 1000);
                ts.setHours(0,0,0,0);

                return (
                    d.branchId === branchId &&
                    ts.getTime() === selectedDateTS &&
                    (selectedStatus === "all" || d.status === selectedStatus)
                );
            })
            .sort((a, b) => {
                const numA = parseInt(a.queueNumber.replace(/\D/g, ""));
                const numB = parseInt(b.queueNumber.replace(/\D/g, ""));
                return numA - numB;
            });

        rows.forEach(row => {
            const tr = document.createElement("tr");

            let statusClass = "waiting";
            let statusText = "Waiting";
            if (row.status === "checked_in") { statusClass = "checked-in"; statusText = "Checked In"; }
            if (row.status === "cancelled") { statusClass = "cancelled"; statusText = "Cancelled"; }

            tr.innerHTML = `
                <td>${fmtQueueNumber(row.queueNumber)}</td>
                <td>${row.name || "-"}</td>
                <td>${row.phone || "-"}</td>
                <td>${row.pax || "-"}</td>
                <td>${row.timestamp ? new Date(row.timestamp.seconds*1000).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'}) : "-"}</td>
                <td><span class="status ${statusClass}">${statusText}</span></td>
            `;
            tbody.appendChild(tr);
        });
    });
}

// Load table
updateTable();

// Change status filter
filterSelect.addEventListener("change", updateTable);

// Change date filter
dateFilter.addEventListener("change", updateTable);
</script>
</html>
