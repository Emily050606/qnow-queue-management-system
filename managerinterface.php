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

        .metrics-container {
            display: flex;
            justify-content: center;
            gap: 40px; 
            margin: 40px auto 50px auto; 
            flex-wrap: wrap; 
        }

        .metric-box {
            background-color: white;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            text-align: center;
            min-width: 200px;
        }

        .metric-box h3 {
            margin: 0 0 15px 0;
            color: #333;
            font-weight: 600;
        }

        .metric-box p {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: #FF8A00;
        }

        .customer-form-container {
            background-color: white;
            max-width: 800px;
            margin: 40px auto 100px auto;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            text-align: center;
        }

        .customer-form-container h2 {
            margin-bottom: 25px;
            font-weight: 700;
            color: #333;
        }

        .customer-form-container input {
            width: 70%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .customer-form-container button {
            padding: 12px 25px;
            background-color: #FF8A00;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .customer-form-container button:hover {
            background-color: #e67300;
        }

        .customer-details {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }

        .customer-actions {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .customer-actions button {
            flex: 1; 
            padding: 12px 0; 
            border-radius: 8px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .customer-actions button:first-child {
            background-color: #e74c3c; 
            color: white;
        }

        .customer-actions button:first-child:hover {
            background-color: #c0392b;
        }

        .customer-actions button:last-child {
            background-color: #27ae60; 
            color: white;
        }

        .customer-actions button:last-child:hover {
            background-color: #1e8449;
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
            <div class="metrics-container">
                <div class="metric-box">
                    <h3>Now Serving</h3>
                    <p id="now-serving"></p>
                </div>
                <div class="metric-box">
                    <h3>Total Queue</h3>
                    <p id="total-queue"></p>
                </div>
                <div class="metric-box">
                    <h3>Average Waiting Time</h3>
                    <p id="avg-wait"></p>
                </div>
            </div>
            <div class="customer-form-container">
                <h2>Check Customer Details</h2>
                <input type="text" id="customer-phone" placeholder="Enter customer phone number">
                <button onclick="checkCustomer()">Check</button>

                <div class="customer-details" id="customer-details">
                    <!-- Customer info will be displayed here -->
                </div>
                <div class="customer-actions" id="customer-actions" style="display: none;">
                    <button onclick="cancelReservation()">Cancel Reservation</button>
                    <button onclick="checkInCustomer()">Check In</button>
                </div>
            </div>
        </div>
    </body>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getFirestore, collection, query, where, orderBy, onSnapshot, getDocs, doc, deleteDoc, updateDoc, serverTimestamp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-firestore.js";

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
        let selectedCustomerId = null;

        // format queue number 
        function fmtQueueNumber(n) {
            return n;
        }

        // real time dashboard updates and update branch data 
        const queueRef = collection(db, "queues");
        const branchRef = doc(db, "restaurants", "shin_zushi", "branches", branchId);

        onSnapshot(queueRef, async (snapshot) => {
            const docs = snapshot.docs.map(d => ({ id: d.id, ...d.data() }));

            const today = new Date();
            today.setHours(0,0,0,0); // start of today

            // Filter only waiting customers for this branch and today, excluding checked-in and cancelled
            const branchWaiting = docs
                .filter(d => 
                    d.branchId === branchId &&
                    d.status !== "checked_in" &&
                    d.status !== "cancelled" &&
                    d.timestamp && 
                    (new Date(d.timestamp.seconds*1000)).setHours(0,0,0,0) === today.getTime()
                )
                .sort((a, b) => a.queueNumber.localeCompare(b.queueNumber, undefined, {numeric: true}));

            // Now Serving
            const waitingOnly = branchWaiting.filter(c => c.status === "waiting");
            const nowServing = waitingOnly.length > 0 ? fmtQueueNumber(waitingOnly[0].queueNumber) : "—";

            // Total queue
            const totalQueue = branchWaiting.length;

            // Estimated wait time
            const estWait = waitingOnly.length <= 1 ? 0 : (waitingOnly.length - 1) * 5;

            // Update Dashboard UI
            document.getElementById("now-serving").textContent = nowServing;
            document.getElementById("total-queue").textContent = totalQueue;
            document.getElementById("avg-wait").textContent = estWait + " min";

            // UPDATE Firestore (currentServing + ttlQueue)
            try {
                await updateDoc(branchRef, {
                    currentServing: nowServing === "—" ? null : nowServing,
                    ttlQueue: totalQueue
                });
            } catch (err) {
                console.error("Failed to update branch dashboard data:", err);
            }
        });

        // check customer
        window.checkCustomer = async function() {
            const phone = document.getElementById("customer-phone").value.trim();
            const detailsDiv = document.getElementById("customer-details");
            const actionsDiv = document.getElementById("customer-actions");
            detailsDiv.innerHTML = "";
            actionsDiv.style.display = "none";
            selectedCustomerId = null;

            if (!phone) { alert("Please enter a phone number!"); return; }

            const q = query(
                collection(db, "queues"),
                where("phone","==",phone),
                where("branchId","==",branchId)
            );

            const snap = await getDocs(q);
            if (snap.empty) {
                detailsDiv.innerHTML = `<p>No customer found for <strong>${phone}</strong></p>`;
                return;
            }

            const today = new Date();
            today.setHours(0,0,0,0);

            // Filter for today only
            const todayDocs = snap.docs.filter(docSnap => {
                const data = docSnap.data();
                return data.timestamp && (new Date(data.timestamp.seconds*1000)).setHours(0,0,0,0) === today.getTime();
            });

            if (todayDocs.length === 0) {
                detailsDiv.innerHTML = `<p>No queue today for <strong>${phone}</strong></p>`;
                return;
            }

            const docSnap = todayDocs[0];
            const data = docSnap.data();
            selectedCustomerId = docSnap.id;

            detailsDiv.innerHTML = `
                <div style="display: flex; flex-direction: column; gap: 10px; text-align: center; font-weight: 500;">
                    <div style="display: flex; justify-content: center; gap: 20px;">
                        <span style="flex: 1; text-align: right;">Name</span>
                        <span style="margin: 0 10px;">;</span>
                        <span style="flex: 1; text-align: left;">${data.name || "-"}</span>
                    </div>
                    <div style="display: flex; justify-content: center; gap: 20px;">
                        <span style="flex: 1; text-align: right;">Phone</span>
                        <span style="margin: 0 10px;">;</span>
                        <span style="flex: 1; text-align: left;">${data.phone || "-"}</span>
                    </div>
                    <div style="display: flex; justify-content: center; gap: 20px;">
                        <span style="flex: 1; text-align: right;">Queue Number</span>
                        <span style="margin: 0 10px;">;</span>
                        <span style="flex: 1; text-align: left;">${fmtQueueNumber(data.queueNumber)}</span>
                    </div>
                    <div style="display: flex; justify-content: center; gap: 20px;">
                        <span style="flex: 1; text-align: right;">Status</span>
                        <span style="margin: 0 10px;">;</span>
                        <span style="flex: 1; text-align: left;">${data.status || "waiting"}</span>
                    </div>
                    <div style="display: flex; justify-content: center; gap: 20px;">
                        <span style="flex: 1; text-align: right;">Pax</span>
                        <span style="margin: 0 10px;">;</span>
                        <span style="flex: 1; text-align: left;">${data.pax || "-"}</span>
                    </div>
                    <div style="display: flex; justify-content: center; gap: 20px;">
                        <span style="flex: 1; text-align: right;">Added</span>
                        <span style="margin: 0 10px;">;</span>
                        <span style="flex: 1; text-align: left;">${data.timestamp ? (new Date(data.timestamp.seconds*1000)).toLocaleString() : "—"}</span>
                    </div>
                </div>
            `;
            actionsDiv.style.display = "flex";
        }


        // cancel reservation
        window.cancelReservation = async function() {
            if (!selectedCustomerId) { 
                alert("No customer selected."); 
                return; 
            }
            if (!confirm("Cancel this queue?")) return;

            // Update the status to "cancelled" instead of deleting
            await updateDoc(doc(db, "queues", selectedCustomerId), {
                status: "cancelled",
                cancelledAt: serverTimestamp()
            });

            document.getElementById("customer-details").innerHTML = "<p>Queue cancelled.</p>";
            document.getElementById("customer-actions").style.display = "none";
            selectedCustomerId = null;
        }

        // check in customer
        window.checkInCustomer = async function() {
            if (!selectedCustomerId) { alert("No customer selected."); return; }

             // Get current waiting queue for today
            const queueSnap = await getDocs(collection(db, "queues"));
            const today = new Date();
            today.setHours(0,0,0,0);

            const branchWaiting = queueSnap.docs
                .map(d => ({ id: d.id, ...d.data() }))
                .filter(d => 
                    d.branchId === branchId &&
                    d.status !== "checked_in" &&
                    d.status !== "cancelled" &&
                    d.timestamp &&
                    (new Date(d.timestamp.seconds*1000)).setHours(0,0,0,0) === today.getTime()
                )
                .sort((a,b) => a.queueNumber - b.queueNumber);

            // Check if selected customer is now serving
            if (branchWaiting.length > 0 && selectedCustomerId !== branchWaiting[0].id) {
                alert(`Customer ${fmtQueueNumber(branchWaiting.find(c => c.id === selectedCustomerId)?.queueNumber)} is not now serving. Please check the now serving customer.`);
                return;
            }


            await updateDoc(doc(db,"queues",selectedCustomerId), {
                status: "checked_in",
                checkedInAt: serverTimestamp()
            });

            document.getElementById("customer-details").innerHTML = "<p>Customer checked in.</p>";
            document.getElementById("customer-actions").style.display = "none";
            selectedCustomerId = null;
        }
    </script>

</html>
