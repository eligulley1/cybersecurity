const dotenv = require('dotenv');
dotenv.config();

const express = require('express');
const mysql = require('mysql');
const cors = require('cors');

const app = express();
const port = process.env.PORT || 3636;

app.use(express.json()); // Middleware for JSON parsing

// Database pool configuration
const dbConfig = {
  connectionLimit: 10, // Allow up to 10 concurrent connections
  host: process.env.MYSQL_HOST,
  user: process.env.MYSQL_USER,
  password: process.env.MYSQL_PASSWORD,
  database: process.env.MYSQL_USERS_DB, // Connect only to the users database
};

const userDb = mysql.createPool(dbConfig);

// Handles MySQL disconnections
function handleDbError(pool, name) {
  pool.on('error', err => {
    console.error(`MySQL ${name} DB error:`, err);
    if (err.code === 'PROTOCOL_CONNECTION_LOST') {
      console.log(`Reconnecting to ${name} DB...`);
    }
  });
}

handleDbError(userDb, 'user');

// 🔹 Fetch Users API
app.get('/users', (req, res) => {
  userDb.query('SELECT * FROM users', (err, results) => {
    if (err) {
      console.error('Error fetching users:', err);
      return res.status(500).send('Error fetching users');
    }
    res.json(results);
  });
});

// Open API Connection
app.listen(port, () => {
  console.log(`API service is running on port ${port}`);
});