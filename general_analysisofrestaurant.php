<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .chart-container {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: 50px auto;
        }

        .chart-title {
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        #branchSelect {
            padding: 8px 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            outline: none;
            transition: all 0.3s ease;
        }

        #branchSelect:hover {
            border-color: #FF8A00;
        }

        #branchSelect:focus {
            border-color: #FF8A00;
            box-shadow: 0 0 5px rgba(255,138,0,0.5);
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
        <a href="general_profile.php"><img src="profile.png" alt="Profile" class="profile-logo"></a>
    </div>

    <div class="blur-overlay"></div>

<div class="content">
    
     <div style="margin: 40px auto 0px auto; text-align: right; max-width: 1000px;">
        <label for="branchSelect" style="font-weight:600; font-size:16px; margin-right: 10px;">Select Branch:</label>
        <select id="branchSelect">
            <option value="2DwadYDoUqR99JCL3THe">Shin Zushi USJ</option>
            <option value="5CNLtY7SItg9bIvUXUYj">Shin Zushi Kepong</option>
            <option value="6k9lMTBGSGU41beUtlAu">Shin Zushi Bukit Jalil</option>
            <option value="8R8PJirmGBteSOwVLJk9">Shin Zushi SS2</option>
            <option value="MwK8uFOjOlVVV3qP1L1Y">Uo Shin Setapak</option>
        </select>
    </div>
    <!-- Cancelled Orders Chart -->
    <div class="chart-container">
        <div class="chart-title">Cancelled Queue per Month</div>
        <canvas id="cancelledChart"></canvas>
    </div>

    <!-- Peak Usage Chart -->
    <div class="chart-container">
        <div class="chart-title">Peak Usage per Hour</div>
        <canvas id="peakUsageChart"></canvas>
    </div>
</div>

<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
import { getFirestore, collection, getDocs } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-firestore.js";

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

let branchId = "2DwadYDoUqR99JCL3THe";

let cancelledChartInstance;
let peakChartInstance;

async function fetchQueueData(selectedBranch) {
    const snapshot = await getDocs(collection(db, "queues"));
    const docs = snapshot.docs
        .map(d => ({ id: d.id, ...d.data() }))
        .filter(d => d.branchId === selectedBranch && d.timestamp);
    return docs;
}

async function getCancelledOrdersPerMonth(selectedBranch) {
    const data = await fetchQueueData(selectedBranch);
    const cancelled = data.filter(d => d.status === "cancelled");
    const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    const counts = Array(12).fill(0);

    cancelled.forEach(d => {
        const date = new Date(d.timestamp.seconds * 1000);
        counts[date.getMonth()]++;
    });

    return { labels: months, counts };
}

async function getPeakUsagePerHour(selectedBranch) {
    const data = await fetchQueueData(selectedBranch);
    const hours = Array(24).fill(0);

    data.forEach(d => {
        const date = new Date(d.timestamp.seconds * 1000);
        hours[date.getHours()]++;
    });

    const labels = Array.from({length: 24}, (_, i) => `${i}:00`);
    return { labels, counts: hours };
}

async function createCharts(selectedBranch) {
    const cancelledData = await getCancelledOrdersPerMonth(selectedBranch);
    const peakData = await getPeakUsagePerHour(selectedBranch);

    // Destroy previous charts if they exist
    if(cancelledChartInstance) cancelledChartInstance.destroy();
    if(peakChartInstance) peakChartInstance.destroy();

    // Cancelled Orders Chart
    cancelledChartInstance = new Chart(document.getElementById('cancelledChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: cancelledData.labels,
            datasets: [{
                label: 'Cancelled Orders',
                data: cancelledData.counts,
                backgroundColor: 'rgba(255,99,132,0.7)',
                borderColor: '#FF6384',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: { responsive: true }
    });

    // Peak Usage Chart
    peakChartInstance = new Chart(document.getElementById('peakUsageChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: peakData.labels,
            datasets: [{
                label: 'Orders per Hour',
                data: peakData.counts,
                backgroundColor: 'rgba(54,162,235,0.2)',
                borderColor: '#36A2EB',
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#36A2EB',
                pointRadius: 5
            }]
        },
        options: { responsive: true }
    });
}

// Initialize charts for default branch
createCharts(branchId);

// Handle dropdown change
document.getElementById('branchSelect').addEventListener('change', (e) => {
    branchId = e.target.value;
    createCharts(branchId);
});
</script>
</body>
</html>