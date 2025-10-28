<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #db7c45;
            color: white;
            text-align: center;
            padding: 1.5em;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2 {
            color: #333;
        }

        .intro-text, .mission, .team {
            margin-bottom: 40px;
        }

        .intro-text p, .mission p, .team p {
            line-height: 1.6;
            font-size: 1.1em;
            color: #555;
        }

        .team-members {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .team-member {
            width: 30%;
            text-align: center;
            margin-bottom: 20px;
        }

        .team-member img {
            width: 100%;
            height: auto;
            border-radius: 50%;
            max-width: 150px;
        }

        .team-member h3 {
            font-size: 1.2em;
            color: #333;
        }

        .team-member p {
            font-size: 1em;
            color: #777;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1em;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        a {
            color: #db7c45;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <header>
        <h1>About Us</h1>
        <p>Learn more about who we are and what we do.</p>
    </header>

    <div class="container">
        <section class="intro-text">
            <h2>Welcome to Our Company</h2>
            <p>Our online store provides a seamless shopping experience, bringing Zara’s global collections directly to your door. With our easy-to-navigate website and fast delivery options, you can stay ahead of the trends no matter where you are..</p>
        </section>

        <section class="mission">
            <h2>Our Mission</h2>
            <p>Our mission is to make fashion accessible and inspiring for everyone. We are committed to offering our customers the latest trends and high-quality clothing, all while staying true to our values of innovation, and customer service.</p>
        </section>

        <section class="team">
            <h2>Meet Our Team</h2>
            <div class="team-members">
                <div class="team-member">
                    <img src="img/aboutus.jpg" alt="Team Member 1">
                    <h3>John Doe</h3>
                    <p>CEO & Founder</p>
                    <p>John has over 15 years of experience in the industry and leads <br>
                    our company with a vision of growth and success.</p>
                </div>
                <div class="team-member">
                    <img src="img/aboutus1.jpg" alt="Team Member 2">
                    <h3>Jane Smith</h3>
                    <p>Manager</p>
                    <p>Jane is responsible for ensuring that the store operates efficiently, and the customers are satisfied.</p>
                </div>
            </div>
        </section>
    </div>

    <br>
    <br>

    <footer>
        <p>&copy; 2024 Your Company Name. All rights reserved.</p>
        <p>Visit our <a href="/privacy-policy">Privacy Policy</a> for more information.</p>
    </footer>

    

</body>
</html>