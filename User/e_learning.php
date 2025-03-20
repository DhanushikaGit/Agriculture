<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture E-Learning Platform</title>
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #8BC34A;
            --accent-color: #FF9800;
            --text-color: #333;
            --light-bg: #f9f9f9;
            --card-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        
        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .container {
            width: 95%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        
        .logo img {
            height: 40px;
            margin-right: 10px;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 1.5rem;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        .nav-links a:hover {
            opacity: 0.8;
        }
        
        .hero {
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/api/placeholder/1200/400');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 2rem;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: #e68a00;
        }
        
        .course-content {
            padding: 3rem 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }
        
        .content-tabs {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid #ddd;
        }
        
        .tab {
            padding: 0.8rem 1.5rem;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .tab.active {
            border-bottom: 3px solid var(--primary-color);
            font-weight: bold;
        }
        
        .tab:hover {
            color: var(--primary-color);
        }
        
        .content-section {
            display: none;
        }
        
        .content-section.active {
            display: block;
        }
        
        .video-grid, .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .video-card, .image-card, .note-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s;
        }
        
        .video-card:hover, .image-card:hover {
            transform: translateY(-5px);
        }
        
        .video-thumbnail, .image-thumbnail {
            position: relative;
            height: 180px;
            overflow: hidden;
        }
        
        .video-thumbnail img, .image-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .play-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0,0,0,0.7);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }
        
        .card-content {
            padding: 1rem;
        }
        
        .card-title {
            margin-top: 0;
            font-size: 1.1rem;
        }
        
        .card-info {
            display: flex;
            justify-content: space-between;
            color: #666;
            font-size: 0.9rem;
        }
        
        .notes-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        .note-card {
            padding: 1.5rem;
        }
        
        .note-title {
            margin-top: 0;
            color: var(--primary-color);
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
        }
        
        .note-content {
            margin-bottom: 1rem;
        }
        
        .note-meta {
            font-size: 0.85rem;
            color: #666;
            text-align: right;
        }
        
        .resource-tools {
            background-color: var(--light-bg);
            padding: 2rem 0;
            margin-top: 2rem;
        }
        
        .tools-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .tool-card {
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            width: 200px;
            text-align: center;
            box-shadow: var(--card-shadow);
        }
        
        .tool-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        footer {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .footer-column {
            flex: 1;
            min-width: 200px;
            margin-bottom: 1rem;
        }
        
        .footer-column h3 {
            margin-top: 0;
            border-bottom: 1px solid rgba(255,255,255,0.3);
            padding-bottom: 0.5rem;
        }
        
        .footer-column ul {
            list-style: none;
            padding: 0;
        }
        
        .footer-column li {
            margin-bottom: 0.5rem;
        }
        
        .footer-column a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        .footer-column a:hover {
            opacity: 0.8;
        }
        
        .copyright {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.3);
        }
        
        @media (max-width: 768px) {
            .video-grid, .image-grid, .notes-list {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .footer-content {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <img src="/api/placeholder/40/40" alt="Agriculture Logo">
                    <span>AgriLearn</span>
                </div>
                <ul class="nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Resources</a></li>
                    <li><a href="#">Community</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <section class="hero">
        <div class="container">
            <h1>Sustainable Farming Techniques</h1>
            <p>Learn modern and sustainable agricultural practices to improve crop yields while preserving the environment for future generations.</p>
            <a href="#" class="btn">Enroll Now</a>
        </div>
    </section>
    
    <section class="course-content container">
        <h2 class="section-title">Course Materials</h2>
        
        <div class="content-tabs">
            <div class="tab active" data-tab="videos">Videos</div>
            <div class="tab" data-tab="images">Images</div>
            <div class="tab" data-tab="notes">Notes</div>
        </div>
        
        <div class="content-section active" id="videos">
            <div class="video-grid">
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Soil Preparation">
                        <div class="play-icon">▶</div>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Soil Preparation Techniques</h3>
                        <div class="card-info">
                            <span>Duration: 12:45</span>
                            <span>Module 1</span>
                        </div>
                    </div>
                </div>
                
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Crop Rotation">
                        <div class="play-icon">▶</div>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Crop Rotation Benefits</h3>
                        <div class="card-info">
                            <span>Duration: 15:20</span>
                            <span>Module 1</span>
                        </div>
                    </div>
                </div>
                
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Irrigation">
                        <div class="play-icon">▶</div>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Modern Irrigation Systems</h3>
                        <div class="card-info">
                            <span>Duration: 18:30</span>
                            <span>Module 2</span>
                        </div>
                    </div>
                </div>
                
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Pest Control">
                        <div class="play-icon">▶</div>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Organic Pest Control</h3>
                        <div class="card-info">
                            <span>Duration: 20:15</span>
                            <span>Module 2</span>
                        </div>
                    </div>
                </div>
                
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Harvesting">
                        <div class="play-icon">▶</div>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Efficient Harvesting Methods</h3>
                        <div class="card-info">
                            <span>Duration: 14:50</span>
                            <span>Module 3</span>
                        </div>
                    </div>
                </div>
                
                <div class="video-card">
                    <div class="video-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Storage">
                        <div class="play-icon">▶</div>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Post-Harvest Storage</h3>
                        <div class="card-info">
                            <span>Duration: 16:40</span>
                            <span>Module 3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content-section" id="images">
            <div class="image-grid">
                <div class="image-card">
                    <div class="image-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Soil Types">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Types of Agricultural Soil</h3>
                        <div class="card-info">
                            <span>Image Gallery</span>
                            <span>Module 1</span>
                        </div>
                    </div>
                </div>
                
                <div class="image-card">
                    <div class="image-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Crop Varieties">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Common Crop Varieties</h3>
                        <div class="card-info">
                            <span>Image Gallery</span>
                            <span>Module 1</span>
                        </div>
                    </div>
                </div>
                
                <div class="image-card">
                    <div class="image-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Irrigation Systems">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Irrigation System Diagrams</h3>
                        <div class="card-info">
                            <span>Image Gallery</span>
                            <span>Module 2</span>
                        </div>
                    </div>
                </div>
                
                <div class="image-card">
                    <div class="image-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Pest Identification">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Common Pest Identification</h3>
                        <div class="card-info">
                            <span>Image Gallery</span>
                            <span>Module 2</span>
                        </div>
                    </div>
                </div>
                
                <div class="image-card">
                    <div class="image-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Harvesting Equipment">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Modern Harvesting Equipment</h3>
                        <div class="card-info">
                            <span>Image Gallery</span>
                            <span>Module 3</span>
                        </div>
                    </div>
                </div>
                
                <div class="image-card">
                    <div class="image-thumbnail">
                        <img src="/api/placeholder/300/180" alt="Storage Facilities">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Storage Facility Designs</h3>
                        <div class="card-info">
                            <span>Image Gallery</span>
                            <span>Module 3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="content-section" id="notes">
            <div class="notes-list">
                <div class="note-card">
                    <h3 class="note-title">Soil Preparation Fundamentals</h3>
                    <div class="note-content">
                        <p>Key aspects of soil preparation include testing soil pH, adding organic matter, and proper tilling techniques. Remember that different crops require different soil conditions.</p>
                    </div>
                    <div class="note-meta">
                        <span>Module 1 • Lecture Notes</span>
                    </div>
                </div>
                
                <div class="note-card">
                    <h3 class="note-title">Crop Rotation Planning</h3>
                    <div class="note-content">
                        <p>Effective crop rotation helps prevent soil depletion and reduces pest problems. Plan your rotation based on plant families and nutrient requirements.</p>
                    </div>
                    <div class="note-meta">
                        <span>Module 1 • Lecture Notes</span>
                    </div>
                </div>
                
                <div class="note-card">
                    <h3 class="note-title">Water Conservation Techniques</h3>
                    <div class="note-content">
                        <p>Drip irrigation and moisture sensors can reduce water usage by up to 60% compared to traditional methods. Consider implementing rainwater harvesting systems for additional sustainability.</p>
                    </div>
                    <div class="note-meta">
                        <span>Module 2 • Lecture Notes</span>
                    </div>
                </div>
                
                <div class="note-card">
                    <h3 class="note-title">Organic Pest Management</h3>
                    <div class="note-content">
                        <p>Integrated Pest Management (IPM) combines biological controls, habitat manipulation, and resistant crop varieties to minimize pesticide use while maintaining crop yields.</p>
                    </div>
                    <div class="note-meta">
                        <span>Module 2 • Lecture Notes</span>
                    </div>
                </div>
                
                <div class="note-card">
                    <h3 class="note-title">Harvesting Best Practices</h3>
                    <div class="note-content">
                        <p>Timing is crucial for optimal harvesting. Consider maturity indicators, weather conditions, and market demands when planning your harvest schedule.</p>
                    </div>
                    <div class="note-meta">
                        <span>Module 3 • Lecture Notes</span>
                    </div>
                </div>
                
                <div class="note-card">
                    <h3 class="note-title">Post-Harvest Handling</h3>
                    <div class="note-content">
                        <p>Proper cooling, cleaning, and storage techniques can extend shelf life and maintain quality. Temperature and humidity control are essential for different crop types.</p>
                    </div>
                    <div class="note-meta">
                        <span>Module 3 • Lecture Notes</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="resource-tools">
        <div class="container">
            <h2 class="section-title">Learning Tools</h2>
            <div class="tools-container">
                <div class="tool-card">
                    <div class="tool-icon">📝</div>
                    <h3>Study Guides</h3>
                    <p>Downloadable PDFs for offline study</p>
                </div>
                
                <div class="tool-card">
                    <div class="tool-icon">🔍</div>
                    <h3>Research Library</h3>
                    <p>Access to agricultural research papers</p>
                </div>
                
                <div class="tool-card">
                    <div class="tool-icon">💬</div>
                    <h3>Discussion Forums</h3>
                    <p>Connect with fellow students</p>
                </div>
                
                <div class="tool-card">
                    <div class="tool-icon">📊</div>
                    <h3>Progress Tracker</h3>
                    <p>Monitor your course completion</p>
                </div>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>About Us</h3>
                    <p>AgriLearn is dedicated to providing quality education on sustainable agricultural practices to farmers worldwide.</p>
                </div>
                
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Courses</a></li>
                        <li><a href="#">Resources</a></li>
                        <li><a href="#">Community</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contact</h3>
                    <ul>
                        <li>Email: info@agrilearn.com</li>
                        <li>Phone: (123) 456-7890</li>
                        <li>Address: 123 Farm Road, Agricity</li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Follow Us</h3>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">YouTube</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2025 AgriLearn. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Tab functionality
        const tabs = document.querySelectorAll('.tab');
        const contentSections = document.querySelectorAll('.content-section');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // Hide all content sections
                contentSections.forEach(section => {
                    section.classList.remove('active');
                });
                
                // Show the corresponding content section
                const tabId = tab.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    </script>
</body>
</html>