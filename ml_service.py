from flask import Flask, request, jsonify
from flask_cors import CORS
import re

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

class XSSDetector:
    def __init__(self):
        # Common XSS patterns
        self.xss_patterns = [
            r'<script.*?>',
            r'javascript:',
            r'onerror\s*=',
            r'onload\s*=',
            r'onclick\s*=',
            r'onmouseover\s*=',
            r'alert\s*\(',
            r'eval\s*\(',
            r'document\.cookie',
            r'document\.write',
            r'<iframe.*?>',
            r'<img.*?onerror.*?>',
            r'data:.*?base64',
            r'prompt\s*\(',
            r'confirm\s*\('
        ]
        self.patterns = [re.compile(pattern, re.IGNORECASE) for pattern in self.xss_patterns]
    
    def analyze_input(self, input_text):
        if not input_text:
            return {
                'is_xss': False,
                'confidence': 0.0,
                'matches': []
            }
        
        matches = []
        match_count = 0
        
        # Check for XSS patterns
        for i, pattern in enumerate(self.patterns):
            if pattern.search(input_text):
                match_count += 1
                matches.append(self.xss_patterns[i])
        
        # Calculate confidence based on number of matches
        confidence = min(match_count / 2, 1.0)  # 2 or more matches = 100% confidence
        
        return {
            'is_xss': confidence > 0.3,  # Consider it XSS if confidence > 30%
            'confidence': confidence,
            'matches': matches
        }

# Initialize detector
detector = XSSDetector()

@app.route('/analyze', methods=['POST'])
def analyze_input():
    try:
        data = request.get_json()
        if not data or 'input' not in data:
            return jsonify({'error': 'No input provided'}), 400
            
        input_text = data['input']
        if not input_text:
            return jsonify({'error': 'Empty input'}), 400
            
        result = detector.analyze_input(input_text)
        return jsonify(result)
        
    except Exception as e:
        return jsonify({'error': str(e)}), 500

if __name__ == '__main__':
    print("XSS Detection Service running on http://localhost:5001")
    app.run(host='0.0.0.0', port=5001, debug=True)
