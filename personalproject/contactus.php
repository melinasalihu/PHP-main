<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
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

        .contact-info, .contact-form {
            margin-bottom: 40px;
        }

        .contact-info p, .contact-form p {
            line-height: 1.6;
            font-size: 1.1em;
            color: #555;
        }

        .contact-form label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .contact-form button {
            padding: 10px 20px;
            background-color: #db7c45;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        .contact-form button:hover {
            background-color: #db7c45;
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
        <h1>Contact Us</h1>
        <p>We would love to hear from you! Please fill out the form below.</p>
    </header>

    <div class="container">
        <section class="contact-info">
            <h2>Our Contact Information</h2>
            <p>If you have any questions feel free to use the contact form below.</p>
            <ul>
                <li><strong>Email:</strong> zara@gmail.com</li>
                <li><strong>Phone:</strong> +1 (800) 123-4567</li>
            </ul>
        </section>

        <section class="contact-form">
            <h2>Send Us a Message</h2>
            <form action="#" method="POST">
                <p>
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" required placeholder="Enter your full name">
                </p>
                <p>
                    <label for="email">Your Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email address">
                </p>
                <p>
                    <label for="message">Your Message:</label>
                    <textarea id="message" name="message" rows="5" required placeholder="Write your message here"></textarea>
                </p>
                <p>
                    <button type="submit">Send Message</button>
                </p>
            </form>
        </section>
    </div>

   
    <footer>
        <p>&copy; 2024 Your Company Name. All rights reserved.</p>
        <p>Visit our <a href="/contact">Contact Page</a> for inquiries or feedback.</p>
    </footer>
</body>
</html>