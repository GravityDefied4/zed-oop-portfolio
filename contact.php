<?php
    $filename = "contacts.txt";
    $success = false;
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") { //check if form is submitted
        $name = trim($_POST["name"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $message = trim($_POST["message"] ?? "");

        if ($name === "" || $email === "" || $message === "") {
            $error = "Please fill in all fields.";
        } else {
            //remove returns and newlines
            $safeName = str_replace(["\r", "\n"], "", $name);
            $safeEmail = str_replace(["\r", "\n"], "", $email);
            $safeMessage = str_replace(["\r", "\n"], "", $message);

            $entry =
                "Name: $safeName\n" .
                "Email: $safeEmail\n" .
                "Message: $safeMessage\n" .
                "-----------------------------\n";

            $file = fopen($filename, "a");
            fwrite($file, $entry);
            fclose($file);

            //redirect to clear form and prevent resubmission
            header("Location: ?success=1");
            exit();
        }
    }

    if (!empty($_GET["success"])) { //check for success notification
        $success = true;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="styles.css?v=1" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <style>
        .notice {
            padding: .6rem;
            margin-bottom: 1rem; 
            border-radius: 6px;
        }

        .success {
            background: #e6ffed;
            color: #127a3a;
            border: 1px solid #b7f0c9;
        }

        .error {
            background: #ffe6e6;
            color: #9a1a1a;
            border: 1px solid #f0b7b7;
        }

        .contact-card {
            background: #ffffff;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            max-width: 700px;
            margin: 2rem auto;
        }

        .contact-card h3 {
            margin-top: 0;
            color: #3366cc;
        }

        .contact-card p {
            margin: 0.5rem 0;
            font-size: 1.05rem;
        }

        form {
            background: #ffffff;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            max-width: 700px;
            margin: 2rem auto;
        }

        textarea {
            height: 100px;
            resize: none;
        }
    </style>
</head>

<body>
    <section class="contact" id="contact">
        <h2>Contact Me</h2>

        <?php
            if ($success && empty($error)) {
                echo '<div class="notice success">Thanks for your message!</div>';
            }
        ?>

        <?php
            if (!empty($error)) {
                echo '<div class="notice error">' . htmlspecialchars($error) . '</div>';
            }
        ?>

        <div class="contact-card">
            <p><strong>Address:</strong> Caranglaan, Dagupan City, Pangasinan</p>
            <p><strong>Phone:</strong> 0970 654 0787</p>
            <p><strong>Email:</strong> zedekiahheteroza@gmail.com</p>
        </div>

        <form method="POST" action="">
            <input type="text" name="name" placeholder="Your Name" required />
            <input type="email" name="email" placeholder="Your Email" required />
            <input type="text" name="subject" placeholder="Subject" required />
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </section>
</body>
</html>