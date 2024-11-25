import sys
import json

def analyze(data):
    # Example: Return the square of numbers
    return [x**2 for x in data]

if __name__ == "__main__":
    input_data = json.loads(sys.argv[1])  # Accept JSON input from PHP
    result = analyze(input_data)
    print(json.dumps(result))  # Return JSON output
