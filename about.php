<!DOCTYPE html>
<html>
<?php 
include('header.php');
?>

    <head>
        <meta charset="UTF-8">
        <title>About US | The Cap Conner</title>



<style>

    html{
       background-color:#fff5f2 ;
    }
    
body {
    font-family: 'Arial', sans-serif;
    background-color: #fff5f2;
}

.about-us-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 20px;
       line-height: 1.6;
}

h1, h2 {
    color: black;
    border-bottom: 2px solid lightsalmon;
    padding-bottom: 0.5rem;
    color: lightsalmon;
    border-bottom: 3px solid lightsalmon;
}

h1 {
    font-size: 2.5rem;
    text-align: center;
    margin: 2rem 0;
    color: lightsalmon;
}

.about-section {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin: 2rem 0;
}

ul {
    list-style: none;
    padding-left: 0;
}

ul li {
    padding: 0.8rem;
    margin: 0.5rem 0;
    background: rgba(255, 160, 122, 0.1);
}


/* Responsive Design */
@media (max-width: 768px) {
    .about-us-container {
        padding: 0 10px;
    }
    
    h1 {
        font-size: 2rem;
    }
}
</style>
    </head>
    
    <body>
<div class="about-us-container">



<div class="about-us-container">
    <h1>About The Cap Conner</h1>
    
    <section class="about-section">
        <h2>Our Story</h2>
        <p>
            Founded in 2025, <strong>The Cap Conner</strong> started with a simple mission: 
            to help graduates celebrate their achievements in style. As former students ourselves, 
            we know how important this milestone is—and we’re here to make it unforgettable.
        </p>
    </section>
    
    <section class="about-section">
        <h2>Why Choose Us?</h2>
        <ul>
            <li>🎓 <strong>Premium Quality:</strong> From diploma frames to custom stoles, every item is crafted with care.</li>
            <li>🚀 <strong>Fast Shipping:</strong> Get your grad gear in time for the big day.</li>
            <li>💙 <strong>School Spirit:</strong> We offer colors and designs for 100+ universities.</li>
            <li>✨ <strong>Celebration-Worthy:</strong> Because you’ve earned it!</li>
        </ul>
    </section>
    
    <section class="about-section">
        <h2>Our Promise</h2>
        <p>
            Whether you're a graduate, parent, or friend, we’re here to help you find the perfect keepsake. 
            Your success is our inspiration!
        </p>
        <p>
            <em>Thank you for celebrating with us.</em>
        </p>
    </section>
</div>

</div>
        
        </body>
        
        <footer><?php include('footer.php'); ?></footer>

        </html>