<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to EcoSphere</title>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      height: 100%;
      overflow: hidden;
    }
    .background {
    background: url('img2.png') no-repeat center center/cover;
    height: 100%;
    position: relative;
}

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .box {
  background-color: #eee; 
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1); 
  text-align: center;
  border: 2px solid crimson;
  max-width: 500px;
}

.box h1 {
  color: #333; 
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.box p {
  color: #333; 
  font-size: 1.2rem;
  margin-bottom: 2rem;
}

.overlay button {
  background-color: #fbd0d9; 
  color: crimson;
  border: none;
  padding: 1rem 2rem;
  font-size: 1rem;
  border-radius: 5px;
  cursor: pointer;
  text-transform: uppercase;
  font-weight: bold;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.overlay button:hover {
  background-color: crimson;
  color: #fff;
  transform: scale(1.05);
}

    .footer {
      position: absolute;
      bottom: 10px;
      font-size: 0.8rem;
      color: white;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="background">
    <div class="overlay">
      <div class="box">
        <h1>Welcome to EcoSphere</h1>
        <p>Click On The Button Below To Do Your Work.</p>
        
        <a href="login.php">
            <button>Login/Register</button>
          </a>
        <a href="quickaction.php">
            <button>Quick Action</button>
          </a>
    </div>
    <div class="footer">© 2025 EcoSphere Platform. All rights reserved.</div>
  </div>
</body>
</html>
