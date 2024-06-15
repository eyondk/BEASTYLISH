const express = require('express');
const cors = require('cors');
const axios = require('axios');

const app = express();
const PORT = 3000;

app.use(cors()); // Enable CORS for all routes
app.use(express.json()); // To parse JSON bodies

app.post('/api/proxy', async (req, res) => {
    try {
        const response = await axios.post('https://api.paymongo.com/v1/links', req.body, {
            headers: {
                'Authorization': 'Basic c2tfdGVzdF9NYVVlQzRKTXg1Y3RZZ3Y3S2tnSFpaWmU6', // Replace with your actual API key
                'Content-Type': 'application/json'
            }
        });
        res.json(response.data);
    } catch (error) {
        res.status(500).send(error.toString());
    }
});

app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});
