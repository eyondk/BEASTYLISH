const express = require("express");
const cors = require("cors");
const axios = require("axios");

const app = express();
const PORT = 3000;

// Enable CORS for all routes
app.use(cors());
app.use(express.json()); // To parse JSON bodies

// Handle OPTIONS preflight requests
app.options("/api/proxy", (req, res) => {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Methods", "POST");
  res.header("Access-Control-Allow-Headers", "Content-Type, Authorization");
  res.send();
});

app.post("/api/proxy", async (req, res) => {
  try {
    const response = await axios.post(
      "https://api.paymongo.com/v1/links",
      {
        data: {
          attributes: req.body.attributes,
        },
      },
      {
        headers: {
          Authorization: "Basic c2tfdGVzdF9NYVVlQzRKTXg1Y3RZZ3Y3S2tnSFpaWmU6", // Replace with your actual API key
          "Content-Type": "application/json",
        },
      }
    );

    // Set CORS headers in response
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Methods", "POST");
    res.header("Access-Control-Allow-Headers", "Content-Type, Authorization");
    res.json(response.data);
  } catch (error) {
    console.error(
      "Proxy Error:",
      error.response ? error.response.data : error.message
    );
    res.status(500).send({
      error: error.response ? error.response.data : error.message,
    });
  }
});

app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});

// const express = require("express");
// const cors = require("cors");
// const axios = require("axios");

// const app = express();
// const PORT = 3000;

// // Enable CORS for all routes
// app.use(cors());
// app.use(express.json()); // To parse JSON bodies

// app.options("/api/proxy", (req, res) => {
//   res.header("Access-Control-Allow-Origin", "*");
//   res.header("Access-Control-Allow-Methods", "POST");
//   res.header("Access-Control-Allow-Headers", "Content-Type, Authorization");
//   res.send();
// });

// app.post("/api/proxy", async (req, res) => {
//   try {
//     const { order_total, order_id } = req.body;

//     // Prepare the request payload for PayMongo
//     const payload = {
//       data: {
//         attributes: {
//           amount: order_total * 100, // Amount in cents
//           description: "Order payment",
//           remarks: `Payment for order ID: ${order_id}`,
//           redirect: {
//             success: "http://localhost/BEASTYLISH/public/success",
//             failed: "http://localhost/BEASTYLISH/public/failed",
//           },
//         },
//       },
//     };

//     const response = await axios.post(
//       "https://api.paymongo.com/v1/links",
//       payload,
//       {
//         headers: {
//           Authorization: "Basic c2tfdGVzdF9NYVVlQzRKTXg1Y3RZZ3Y3S2tnSFpaWmU6", // Replace with your actual API key
//           "Content-Type": "application/json",
//         },
//       }
//     );

//     // Set CORS headers in response
//     res.header("Access-Control-Allow-Origin", "*");
//     res.header("Access-Control-Allow-Methods", "POST");
//     res.header("Access-Control-Allow-Headers", "Content-Type, Authorization");
//     res.json(response.data);
//   } catch (error) {
//     console.error(
//       "Proxy Error:",
//       error.response ? error.response.data : error.message
//     );
//     res.status(500).send({
//       error: error.response ? error.response.data : error.message,
//     });
//   }
// });

// app.listen(PORT, () => {
//   console.log(`Server running on http://localhost:${PORT}`);
// });
