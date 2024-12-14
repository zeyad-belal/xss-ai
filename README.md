# XSS Vulnerability Scanner

A web application that scans input text for potential XSS (Cross-Site Scripting) vulnerabilities using pattern-based detection.

## Features

- Real-time XSS vulnerability scanning
- Pattern-based detection of common XSS attack vectors
- Confidence scoring
- Detailed reporting of detected patterns
- Mobile-responsive UI

## Setup

1. Clone the repository:
```bash
git clone <your-repo-url>
cd rana
```

2. Set up Python virtual environment:
```bash
python3 -m venv venv
source venv/bin/activate  # On Windows: venv\Scripts\activate
pip install -r requirements.txt
```

3. Start the Python ML service:
```bash
python ml_service.py
```
The service will run on http://localhost:5001

4. Start the PHP server:
```bash
cd public
php -S localhost:8000
```
The web interface will be available at http://localhost:8000

## Usage

1. Open http://localhost:8000 in your web browser
2. Enter text in the input field
3. Click "Scan for XSS"
4. View the results, including:
   - Whether XSS was detected
   - Confidence level
   - List of detected suspicious patterns

## Dependencies

### Python
- Flask
- Flask-CORS
- scikit-learn
- numpy
- requests

### PHP
- PHP 7.4+ with cURL extension

### Frontend
- Swiper.js
- Font Awesome

## License

MIT License
