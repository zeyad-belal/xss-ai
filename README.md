# XSS Vulnerability Scanner

A web application that combines PHP and Machine Learning to detect potential XSS (Cross-Site Scripting) vulnerabilities in input text.

## Features

- Hybrid ML model combining Random Forest and Logistic Regression
- Real-time XSS vulnerability scanning
- User-friendly web interface
- Detailed confidence scores for detected vulnerabilities

## Setup Instructions

1. Install Python dependencies:
```bash
pip install -r requirements.txt
```

2. Start the ML service:
```bash
python ml_service.py
```

3. Set up a PHP server:
```bash
php -S localhost:8000
```

4. Access the application at `http://localhost:8000`

## Project Structure

- `ml_service.py`: Python Flask service hosting the ML model
- `xss_checker.php`: PHP integration with the ML service
- `index.php`: Main web interface
- `header.php`: Common header component
- `footer.php`: Common footer component
- `css/style.css`: Styling for the web interface

## Usage

1. Open the web application in your browser
2. Enter text in the input field
3. Click "Scan for XSS"
4. View the results showing whether XSS vulnerabilities were detected

## Notes

- The ML model is trained on a basic dataset and can be improved with more training data
- Make sure both the Python ML service and PHP server are running
- The application requires PHP with curl extension enabled
