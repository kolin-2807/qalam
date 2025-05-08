const express = require('express');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: {
        origin: "http://localhost",
        methods: ["GET", "POST"]
    }
});

const mysql = require('mysql2');

server.listen(3000, () => {
    console.log("✅ Socket сервер іске қосылды: http://localhost:3000");
});

// 🔁 Қайта қосылатын MySQL
function createConnection() {
    const conn = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: '',
        database: 'qalam'
    });

    conn.connect((err) => {
        if (err) {
            console.error('❌ MySQL қосылмады. Қайта қосуға тырысады...', err.code);
            setTimeout(createConnection, 2000);
        } else {
            console.log('✅ MySQL байланыс орнады!');
        }
    });

    conn.on('error', function(err) {
        console.error('❌ MySQL қатесі:', err.code);
        if (err.code === 'PROTOCOL_CONNECTION_LOST' || err.code === 'ECONNRESET') {
            createConnection();
        } else {
            throw err;
        }
    });

    return conn;
}

const conn = createConnection();

function getUserIdByName(name, callback) {
    conn.query("SELECT id FROM users WHERE name = ?", [name], (err, results) => {
        if (err || results.length === 0) return callback(null);
        callback(results[0].id);
    });
}

io.on('connection', (socket) => {
    console.log("🔌 Байланыс орнатылды");

    socket.on('send mess', (data) => {
        console.log(`💬 ${data.name} ➤ ${data.receiver}: ${data.mess}`);

        getUserIdByName(data.name, (sender_id) => {
            if (!sender_id) return console.log("❌ Sender табылмады");

            getUserIdByName(data.receiver, (receiver_id) => {
                if (!receiver_id) return console.log("❌ Receiver табылмады");

                conn.query(
                    "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)",
                    [sender_id, receiver_id, data.mess],
                    (err) => {
                        if (err) return console.log("❌ База қатесі:", err);
                        console.log("✅ Хабарлама базаға жазылды!");
                        io.emit('add mess', data);
                    }
                );
            });
        });
    });

    socket.on('disconnect', () => {
        console.log("🔌 Ажыратылды");
    });
});
