<?php
    $filename = "aboutme.txt";
    $success = false;
    $error = "";
    $currentText = "";

    if (file_exists($filename)) {
        $file = fopen($filename, "r");
        $currentText = fread($file, filesize($filename));
        fclose($file);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") { //check if form is submitted
        $newText = trim($_POST["abouttext"] ?? "");

        if ($newText === "") {
            $error = "Please enter some text before saving.";
        } else {
            $file = fopen($filename, "w");
            fwrite($file, $newText);
            fclose($file);

            //redirect to clear textarea and prevent resubmission
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
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
    <title>About Me</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #f4f4f9;
            margin: 0;
            padding: 2rem;
        }

        .notice {
            padding: .6rem 1rem;
            margin-bottom: 1rem;
            border-radius: 6px;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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

        .about-card {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 2rem;
            padding: 2rem;
            margin: 2rem auto;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            max-width: 1100px;
        }

        .about-photo {
            width: 320px;
            height: auto;
            border-radius: 12px;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .about-info {
            flex: 1;
        }

        .about-info h2 {
            color: #3366cc;
            margin-bottom: 1rem;
        }

        .about-info p {
            margin: 0.35rem 0;
            line-height: 1.5;
            font-size: 1rem;
        }

        .about-display {
            width: 100%;
            box-sizing: border-box;
            padding: 1.5rem;
            background: linear-gradient(145deg, #ffffff, #f0f0f5);
            border-radius: 12px;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .about-display:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }

        textarea {
            width: 100%;
            box-sizing: border-box;
            height: 150px;
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid #ccc;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            resize: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        textarea:focus {
            outline: none;
            border-color: #6387ffff;
            box-shadow: 0 0 6px rgba(108, 99, 255, 0.3);
        }

        button {
            display: inline-block;
            padding: 0.7rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #6387ffff, #9bbefeff);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        button:active {
            transform: translateY(1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        form {
            max-width: 1250px;
            margin: 0 auto;
            text-align: center;
        }

        @media (max-width: 700px) {
            .about-card {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .about-photo {
                width: 260px;
            }

            .about-info {
                text-align: left;
            }
        }

    </style>
</head>
<body>
    <div class="about-card">
        <img src="zedimage.jpeg" alt="A Photo of Zed" class="about-photo">

        <div class="about-info">
            <h2>Personal Information</h2>

            <p><strong>Name:</strong> Zedekiah Heteroza</p>
            <p><strong>Age:</strong> 19 years old</p>
            <p><strong>Birthday:</strong> September 18, 2006</p>
            <p><strong>Sex:</strong> Male</p>
            <br>
            <p><strong>Hobbies:</strong> Surfing the Internet, Playing Mobile Games, Coding, Learning</p>
            <p><strong>Interests:</strong> Technology, Programming, Web & App Development</p>
            <p><strong>Goals:</strong> To become a proficient, professional, and successful developer in the tech industry.</p>
            <br>
            <p><strong>Favorite Quote:</strong> “Everything will be okay in the end. If it's not okay, it's not the end.” — John Lennon</p>
            <br>
            <p><strong>Fun Fact:</strong> I never attended Kindergarten, so I'm actually, technically, a year behind my peers.</p>
        </div>
    </div>

    <section class="about" id="about">
        <h2>About Me</h2>

        <?php
            if ($success && empty($error)) {
                echo '<div class="notice success">About Me section updated successfully!</div>';
            }
        ?>

        <?php
            if (!empty($error)) {
                echo '<div class="notice error">' . htmlspecialchars($error) . '</div>';
            }
        ?>

        <div class="about-display">
            <?php
                echo nl2br(htmlspecialchars($currentText));
            ?>
        </div>

        <form method="POST" action="">
            <textarea name="abouttext" placeholder="Write something About Me..." required></textarea>
            <br><br>
            <button type="submit">Save</button>
        </form>
    </section>
</body>
</html>